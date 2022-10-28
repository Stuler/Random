<?php
declare(strict_types=1);

namespace App\Model\Repository\Table;

use App\model\BaseModel\BaseModel;
use App\types\Enum\EOrderType;

class BrandRepository extends BaseModel {

	protected string $table = 'brand';

	/**
	 * Returns all undeleted brands configured in accordance with pagination and chosen order
	 */
	public function fetchActiveBrands(?string $order = null, ?int $limit = null, ?int $offset = 0): array {
		$selection = $this->findAllActive();
		if ($order === EOrderType::getASC()) {
			$selection->order("label ASC");
		} elseif ($order === EOrderType::getDESC()) {
			$selection->order("label DESC");
		} else {
			$selection->order("date_created DESC");
		}

		$selection->limit($limit, $offset);
		return $selection->fetchAll();
	}

	/**
	 * Returns active brands count for paginator algorithm
	 */
	public function getBrandsCount(): int {
		return $this->findAllActive()->count();
	}
}