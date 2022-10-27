<?php
declare(strict_types=1);

namespace App\Model\Process;

use App\Model\Exceptions\BrandsException;
use App\Model\Repository\Table\BrandRepository;
use App\Model\Repository\Table\LoginRepository;
use App\Model\Repository\Table\LoginRoleRepository;
use App\types\db\Tables\TDbBrand;
use App\types\Form\TFormBrand;

class BrandProcess {
	public function __construct(
		private BrandRepository $brandRepo,
	) {
	}

	/**
	 * Saves brand values into db
	 * @throws \App\Model\Exceptions\BrandsException
	 */
	public function save(TFormBrand $values): int {
		if ($this->validateBrandLabel($values->label) === false) {
			throw new BrandsException("Značka se stejným názvem již existuje!");
		}
		$saveValues = new TDbBrand();
		$saveValues->id = $values->id;
		$saveValues->label = $values->label;
		$saveValues->note = $values->note;
		$saveValues->description = $values->description;
		$saveValues->brand_category_id = $values->brand_category_id;
		$saveValues->created_by = LoginRepository::ADMIN_ID; // default admin id, todo: add authorization
		return $this->brandRepo->save($saveValues);
	}

	/**
	 * Checks brand's name duplicity
	 * Returns FALSE if duplicity EXISTS!
	 */
	private function validateBrandLabel(string $label): bool {
		$brand = $this->brandRepo->findAllActive()
			->where("label", $label)
			->limit(1)
			->fetch();

		return !$brand;
	}

	/**
	 * Marks brand as deleted
	 */
	public function softDeleteDate(int $brandId) {
		$this->brandRepo->softDeleteDate($brandId, LoginRepository::ADMIN_ID);
	}
}