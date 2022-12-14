<?php
declare(strict_types=1);

namespace App\types\db\Tables;

use Nette\Utils\ArrayHash;

/**
 * Table: brand_category
 * @property int    $id;
 * @property string $label;
 * @property string $description;
 * @property string $note;
 * @property int    $created_by;
 */
class TDbBrandCategory extends ArrayHash {

}