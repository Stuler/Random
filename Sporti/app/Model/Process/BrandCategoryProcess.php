<?php
declare(strict_types=1);

namespace App\Model\Process;

use App\Model\Exceptions\BrandsCategoryException;
use App\Model\Repository\Table\BrandCategoryRepository;
use App\Model\Repository\Table\LoginRepository;
use App\types\db\Tables\TDbBrandCategory;
use App\types\Form\TFormBrandCategory;

class BrandCategoryProcess {
	public function __construct(
		private BrandCategoryRepository $brandCategoryRepo,
	) {
	}

	/**
	 * Saves brand category values into db
	 * @throws \App\Model\Exceptions\BrandsCategoryException
	 */
	public function saveBrandCategory(TFormBrandCategory $values): int {
		if ($this->validateBrandCategoryLabel($values->label) === false) {
			throw new BrandsCategoryException("Značka se stejným názvem již existuje!");
		}
		$saveValues = new TDbBrandCategory();
		$saveValues->id = $values->id;
		$saveValues->label = $values->label;
		$saveValues->note = $values->note;
		$saveValues->description = $values->description;
		$saveValues->created_by = LoginRepository::ADMIN_ID;
		return $this->brandCategoryRepo->save($saveValues);
	}

	/**
	 * Checks brand's category name duplicity
	 * Returns FALSE if duplicity EXISTS!
	 */
	private function validateBrandCategoryLabel(string $label): bool {
		$category = $this->brandCategoryRepo->findAllActive()
			->where("label", $label)
			->limit(1)
			->fetch();

		return !$category;
	}

	/**
	 * Marks brand category as deleted
	 */
	public function softDeleteDateBrandCategory(int $brandId) {
		$this->brandCategoryRepo->softDeleteDate($brandId, LoginRepository::ADMIN_ID);
	}
}