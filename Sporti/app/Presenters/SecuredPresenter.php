<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class SecuredPresenter extends Presenter {

	public function __construct() {
		parent::__construct();
	}

}