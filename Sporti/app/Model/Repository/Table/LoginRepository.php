<?php
declare(strict_types=1);

namespace App\Model\Repository\Table;

use App\model\BaseModel\BaseModel;

class LoginRepository extends BaseModel {
	protected string $table = "login";

	public const ADMIN_ID = 1;
}