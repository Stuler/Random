<?php
declare(strict_types=1);

namespace App\types\Enum;

enum EOrderType {

	case ASC;
	case DESC;

	public function toString(): string {
		return strtolower($this->name);
	}

	public static function getASC(): string {
		return EOrderType::ASC->toString();
	}

	public static function getDESC(): string {
		return EOrderType::DESC->toString();
	}

	public static function getCases(): array {
		return [self::getASC(), self::getDESC()];
	}
}