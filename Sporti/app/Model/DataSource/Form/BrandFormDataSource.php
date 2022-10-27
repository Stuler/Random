<?php
declare(strict_types=1);

namespace App\Model\DataSource\Form;

use App\Model\ProcessManager\BrandProcessManager;
use App\Model\Repository\Table\BrandRepository;
use App\types\Form\TFormBrand;

class BrandFormDataSource {

	public function __construct(
		private BrandRepository     $brandRepo,
		private BrandProcessManager $brandPM,
	) {
	}

	/**
	 * Returns brand values for brand form by brand id
	 */
	public function getDefaults(int $id): TFormBrand {
		/** @var \App\types\db\Tables\TDbBrand $brand */
		$brand = $this->brandRepo->fetchById($id);
		$defaults = new TFormBrand();
		$defaults->id = (string)$brand->id;
		$defaults->label = $brand->label;
		$defaults->note = $brand->note;
		$defaults->description = $brand->description;
		$defaults->brand_category_id = $brand->brand_category_id;
		return $defaults;
	}

	/**
	 * Creates/edits brand from brand form
	 * @throws \App\Model\Exceptions\BrandsException
	 */
	public function save(TFormBrand $values): int {
		return $this->brandPM->save($values);
	}

}