<?php
declare(strict_types=1);

namespace App\model\BaseModel;

use Nette\Database\Context;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class BaseModel {
	use SmartObject;

	protected string $table = "";

	function __construct(
		private Context $db
	) {
	}

	public function findById(int $id): Selection {
		return $this->db->table($this->table)->wherePrimary($id);
	}

	public function fetchById(int $id): ?ActiveRow {
		return $this->findById($id)->fetch();
	}

	public function findAll(): Selection {
		return $this->db->table($this->table);
	}

	public function findAllActive(): Selection {
		return $this->findAll()->where("$this->table.date_deleted IS NULL");
	}

	public function save(array|ArrayHash $values): int {
		if ($values instanceof ArrayHash) {
			$values = (array)$values;
		}

		if ($this->isSetId($values)) {
			$id = $values['id'];
			unset($values['id']);
			$this->db->query("UPDATE `$this->table` SET ? WHERE id = ?", $values, $id);
			return intval($id);
		} else {
			if (array_key_exists('id', $values)) {
				unset($values['id']);
			}
			$this->db->query("INSERT INTO `$this->table`", $values);
			return intval($this->db->getInsertId());
		}
	}

	/**
	 * New or existing record detection
	 */
	public function isSetId(array|ArrayHash $values): bool {
		return array_key_exists('id', $values) && intval($values['id']) > 0;
	}

	public function getColumnNames($tableName): array {
		return $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME ='$tableName' AND TABLE_SCHEMA='skss'")
			->fetchPairs(null, "COLUMN_NAME");
	}

	/**
	 * @return int 1|0
	 */
	public function delete(int|string $id): int {
		return $this->db->table($this->table)->wherePrimary($id)->delete();
	}

	/**
	 * Sets item as deleted
	 */
	public function softDelete(int|string $id, null|string $column = 'is_deleted') {
		$this->db->query("UPDATE `$this->table` SET $column = 1 WHERE id = ?", $id);
	}

	/**
	 * Sets item as deleted with time stamp and user id
	 */
	public function softDeleteDate(int $id, int $loginId) {
		$args = ["date_deleted" => new \DateTime, "deleted_by" => $loginId];
		$this->db->query("UPDATE `$this->table` SET ? WHERE id = ?", $args, $id);
	}
}