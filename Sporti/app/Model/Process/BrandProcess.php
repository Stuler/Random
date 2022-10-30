<?php
declare(strict_types=1);

namespace App\Model\Process;

use App\Model\Exceptions\BrandsException;
use App\Model\Repository\Table\BrandRepository;
use App\Model\Repository\Table\LoginRepository;
use App\Model\Repository\Table\LoginRoleRepository;
use App\types\db\Tables\TDbBrand;
use App\types\Form\TFormBrand;
use function Composer\Autoload\includeFile;

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
		$this->validateBrandLabel((int)$values->id, $values->label);
		$saveValues = new TDbBrand();
		$saveValues->id = $values->id;
		$saveValues->label = $values->label;
		$saveValues->note = $values->note;
		$saveValues->description = $values->description;
		$saveValues->brand_category_id = $values->brand_category_id ?? null;
		$saveValues->created_by = LoginRepository::ADMIN_ID; // default admin id, todo: add authorization
		return $this->brandRepo->save($saveValues);
	}

	/**
	 * Checks brand's name duplicity
	 * Throws Exception if duplicity EXISTS!
	 * @throws \App\Model\Exceptions\BrandsException
	 */
	private function validateBrandLabel(int $id, string $label): void {
		/** @var TDbBrand $brand */
		$selection = $this->brandRepo->findAllActive()
			->where("label", $label);
		if ($id != 0) {
			$selection->where("id <> ?", $id);
		};
		$brand = $selection->limit(1)->fetch();
		if ($brand && (strtolower($brand->label) === strtolower($label))) {
			throw new BrandsException("Značka s názvem '" . $label. "' již existuje!");
		}
	}

	/**
	 * Marks brand as deleted
	 */
	public function softDeleteDate(int $brandId) {
		$this->brandRepo->softDeleteDate($brandId, LoginRepository::ADMIN_ID);
	}
}