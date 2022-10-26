<?php
declare(strict_types=1);

namespace App\Presenters;

use App\Model\Repository\Table\BrandCategoryRepository;
use App\Model\Repository\Table\BrandRepository;
use App\types\Form\TFormBrand;
use Nette\Application\UI\Form;

class BrandsPresenter extends SecuredPresenter {

	public function __construct(
		private BrandRepository         $brandRepo,
		private BrandCategoryRepository $brandCategoryRepo,
	) {
		parent::__construct();
	}

	public function renderDefault() {
		$t = $this->template;
		$t->brands = $this->brandRepo->findAllActive()->fetchAll();
	}

	public function handleShowAddBrandDialog() {
		$this->template->showModal = true;
		$this->template->modalName = "FormBrand";
		$this->redrawControl();
	}

	// TODO: add logo uploader?
	public function createComponentFormBrand(): Form {
		$form = new Form();
		$form->getElementPrototype()->class("ajax");

		$brandCategories = $this->brandCategoryRepo->findAllActive()->fetchPairs("id", "label");

		$form->addHidden("id");
		$form->addText("label", "Označení")->setRequired();
		$form->addSelect("category_id", "Kategorie", $brandCategories)->setRequired();
		$form->addText("description", "Popis");
		$form->addText("note", "Poznámka");
		$form->addSubmit("save", "Uložit");
		$form->onSuccess[] = function (Form $form, TFormBrand $values) {

		};
		return $form;
	}

	public function handleCloseModal() {
		$this->redrawControl("modal");
	}
}