<?php
declare(strict_types=1);

namespace App\Model\DataSource\Form;

use App\Model\ProcessManager\BrandCategoryProcessManager;
use App\Model\Repository\Table\BrandCategoryRepository;
use App\types\Form\TFormBrandCategory;

class BrandCategoryFormDataSource {

	public function __construct(
		private BrandCategoryRepository     $brandCategoryRepo,
		private BrandCategoryProcessManager $brandCategoryPM,
	) {
	}

	/**
	 * Returns brand values for brand category form by category id
	 */
	public function getDefaults(int $id): TFormBrandCategory {
		/** @var \App\types\db\Tables\TDbBrandCategory $brandCategory */
		$brandCategory = $this->brandCategoryRepo->fetchById($id);
		$defaults = new TFormBrandCategory();
		$defaults->id = (string)$brandCategory->id;
		$defaults->label = $brandCategory->label;
		$defaults->note = $brandCategory->note;
		$defaults->description = $brandCategory->description;
		return $defaults;
	}

	/**
	 * Creates/edits brand category from brand category form
	 * @throws \App\Model\Exceptions\BrandsCategoryException
	 */
	public function save(TFormBrandCategory $values): int {
		return $this->brandCategoryPM->saveBrandCategory($values);
	}

}