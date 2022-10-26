<?php
declare(strict_types=1);

namespace App\Model\DataSource\Form;

use App\types\Form\TFormBrand;

class BrandFormDataSource {

	/**
	 * Returns brand values for brand form by brand id
	 */
	public function getDefaults(int $id): TFormBrand {

		$defaults = new TFormBrand();
		return $defaults;
	}

}