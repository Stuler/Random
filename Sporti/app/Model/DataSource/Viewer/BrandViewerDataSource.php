<?php
declare(strict_types=1);

namespace App\Model\DataSource\Viewer;

use App\Model\ProcessManager\BrandProcessManager;
use App\Model\Repository\Table\BrandRepository;
use Nette\Database\Table\Selection;

class BrandViewerDataSource {

	public const ORDER_ASC = "ASC";
	public const ORDER_DESC = "DESC";

	public function __construct(
		private BrandProcessManager $brandPM,
		private BrandRepository     $brandRepo,
	) {
	}

	/**
	 * Returns all undeleted brands data array
	 */
	public function getActiveBrands(?string $order = null): array {
		bdump($order);
		$selection = $this->brandRepo->findAllActive();
		if ($order === self::ORDER_ASC) {
			$selection->order("label ASC");
		} elseif ($order === self::ORDER_DESC) {
			$selection->order("label DESC");
		}
		return $selection->fetchAll();
	}

	public function deleteBrand(int $id) {
		$this->brandPM->delete($id);
	}
}