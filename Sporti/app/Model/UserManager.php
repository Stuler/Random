<?php
declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\Table\LoginRepository;
use App\Model\Repository\Table\LoginRoleRepository;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;
use Nette\SmartObject;

/**
 * User Authorization and authentication processes
 */
class UserManager implements Authenticator {
	use SmartObject;

	private const
		TABLE_NAME = 'login',
		COLUMN_ID = 'id',
		COLUMN_NAME = 'name',
		COLUMN_PASSWORD_HASH = 'password',
		COLUMN_EMAIL = 'email',
		COLUMN_ROLE = 'login_role_id',
		COLUMN_CREATOR = 'created_by';

	/** @var IIdentity|false */
	protected IIdentity|false $identity = false;

	protected string $table = 'login';

	public function __construct(
		private Explorer        $db,
		private Passwords       $passwords,
		private LoginRepository $loginRepo
	) {
	}

	/**
	 * Performs an authentication.
	 * @throws AuthenticationException
	 */
	public function authenticate($user, $password): IIdentity {

		$row = $this->db->table($this->table)
			->where('name', $user)
			->fetch();

		if (!$row) {
			throw new AuthenticationException('Uživate nenalezen.');
		} elseif (!$this->passwords->verify($password, $row->password)) {  // Ověří zadané heslo.
			throw new AuthenticationException('Zadané heslo není správně.');
		} elseif ($this->passwords->needsRehash($row->password)) { // Zjistí zda heslo potřebuje rehashovat.
			// Rehashuje heslo (bezpečnostní opatření).
			$row->update([
				'password' => $this->passwords->hash($password),
			]);
		}
		$data = $row->toArray();

		unset($data['password']);
		return new SimpleIdentity(
			$row->id,
			$row->login_role->name,
			$data
		);
	}

	public function fetchById($id): ?ActiveRow {
		return $this->db->table($this->table)
			->where('id', $id)
			->where('is_active', 1)
			->fetch();
	}

	public function createIdentity(int $loginId): Identity {
		$row = $this->fetchById($loginId);
		if (!$row) {
			throw new AuthenticationException('Uživatel není aktivní.');
		}
		$data = $row->toArray();
		return new SimpleIdentity(
			$row->id,
			$row->login_role->name,
			$data
		);
	}

	/**
	 * @throws DuplicateNameException
	 */
	public function add($nick, $email, $password): int {
		try {
			$saveValues = [
				self::COLUMN_NAME          => $nick,
				self::COLUMN_PASSWORD_HASH => $this->passwords->hash($password),
				self::COLUMN_EMAIL         => $email,
				self::COLUMN_ROLE          => LoginRoleRepository::ROLE_EMPLOYEE,
				self::COLUMN_CREATOR       => 1,
			];

			return $this->loginRepo->save($saveValues);
		} catch (UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	}
}

class DuplicateNameException extends \Exception {
}