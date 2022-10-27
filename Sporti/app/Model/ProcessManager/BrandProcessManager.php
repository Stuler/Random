<?php
declare(strict_types=1);

namespace App\Model\ProcessManager;

use App\Model\Process\BrandProcess;
use App\types\Form\TFormBrand;

class BrandProcessManager {

	public function __construct(
		private BrandProcess $brandProcess,
	) {
	}

	/**
	 * Saves brand data into db
	 * @throws \App\Model\Exceptions\BrandsException
	 */
	public function save(TFormBrand $values): int {
		return $this->brandProcess->save($values);
	}

	public function delete(int $id) {
		$this->brandProcess->softDeleteDate($id);
	}

}