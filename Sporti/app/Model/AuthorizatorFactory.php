<?php
declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\Table\LoginRoleRepository;
use Nette\Security\Permission;

class AuthorizatorFactory {

	/** @var LoginRoleRepository */
	public $loginRoleRepo;

	public function __construct(LoginRoleRepository $loginRoleRepo) {
		$this->loginRoleRepo = $loginRoleRepo;
	}

	public static function create(LoginRoleRepository $roleRepo): Permission {
		$acl = new Permission();

		$roles = $roleRepo->findAll()->fetchAll();
		foreach ($roles as $role) {
			$acl->addRole($role->name);
		}

		return $acl;
	}

}