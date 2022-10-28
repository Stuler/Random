<?php
declare(strict_types=1);

namespace App\Model;

use App\Model\ProcessManager\BrandProcessManager;
use App\Model\Repository\Table\BrandRepository;

class BrandDataManager {
	public function __construct(
		private BrandRepository     $brandRepo,
		private BrandProcessManager $brandPM,
	) {
	}


	/**
	 * Returns all undeleted brands configured in accordance with pagination and chosen order
	 */
	public function getActiveBrands(?string $order = null, ?int $limit = null, ?int $offset = null): array {
		return $this->brandRepo->fetchActiveBrands($order, $limit, $offset);
	}

	/**
	 * Returns active brands count for paginator algorithm
	 */
	public function getActiveBrandsCount(): int {
		return $this->brandRepo->getBrandsCount();
	}

	/**
	 * Marks brand record as deleted by user in db
	 */
	public function deleteBrand(int $id) {
		$this->brandPM->delete($id);
	}
}