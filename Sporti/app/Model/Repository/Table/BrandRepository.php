<?php
declare(strict_types=1);

namespace App\Model\Repository\Table;

use App\model\BaseModel\BaseModel;

class BrandRepository extends BaseModel {

	protected string $table = 'brand';

	public const ORDER_ASC = "ASC";
	public const ORDER_DESC = "DESC";

	/**
	 * Returns all undeleted brands configured in accordance with pagination and chosen order
	 */
	public function fetchActiveBrands(?string $order = null, ?int $limit = null, ?int $offset = null): array {
		$selection = $this->findAllActive();
		if ($order === self::ORDER_ASC) {
			$selection->order("label ASC");
		} elseif ($order === self::ORDER_DESC) {
			$selection->order("label DESC");
		}
		$selection->page($limit, $offset);
		return $selection->fetchAll();
	}
}