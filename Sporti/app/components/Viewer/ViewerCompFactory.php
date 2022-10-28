<?php
declare(strict_types=1);

namespace App\components\Viewer;

interface ViewerCompFactory {
	function create(): ViewerComp;
}