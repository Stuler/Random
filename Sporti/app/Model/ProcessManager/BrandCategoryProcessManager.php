<?php
declare(strict_types=1);

namespace App\Model\ProcessManager;

use App\Model\Process\BrandCategoryProcess;
use App\types\Form\TFormBrandCategory;

class BrandCategoryProcessManager {

	public function __construct(
		private BrandCategoryProcess $brandCategoryProcess,
	) {
	}

	/**
	 * Saves brand category data into db
	 * @throws \App\Model\Exceptions\BrandsCategoryException
	 */
	public function saveBrandCategory(TFormBrandCategory $values): int {
		return $this->brandCategoryProcess->saveBrandCategory($values);
	}

}