<?php
declare(strict_types=1);

namespace App\Model\Repository\Table;

use App\model\BaseModel\BaseModel;

class LoginRoleRepository extends BaseModel {
	protected string $table = "login_role";

	public const ROLE_ADMIN = 1;
	public const ROLE_EMPLOYEE = 2;

}