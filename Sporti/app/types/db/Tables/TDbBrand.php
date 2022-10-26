<?php
declare(strict_types=1);

namespace App\types\db\Tables;

use Nette\Utils\ArrayHash;

/**
 * Table: brand
 * @property int                        $id;
 * @property string                     $label;
 * @property int                        $brand_category_id;
 * @property string                     $description;
 * @property string                     $note;
 * @property int                        $created_by;
 *
 * @property-read TDbBrandCategory|null $brand_category
 */
class TDbBrand extends ArrayHash {

}