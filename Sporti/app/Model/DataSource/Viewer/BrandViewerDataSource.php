<?php
declare(strict_types=1);

namespace App\Model\DataSource\Viewer;

use App\Model\ProcessManager\BrandProcessManager;
use App\Model\Repository\Table\BrandRepository;
use Nette\Database\Table\Selection;

class BrandViewerDataSource {

	public function __construct(
		private BrandProcessManager $brandPM,
		private BrandRepository     $brandRepo,
	) {
	}

	/**
	 * Returns all undeleted brands configured in accordance with pagination and chosen order
	 */
	public function getActiveBrands(?string $order = null, ?int $limit = null, ?int $offset = null): array {
		return $this->brandRepo->fetchActiveBrands($order, $limit, $offset);
	}

	/**
	 * Marks brand record as deleted by user in db
	 */
	public function deleteBrand(int $id) {
		$this->brandPM->delete($id);
	}
}