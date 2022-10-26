<?php
declare(strict_types=1);

namespace App\Presenters;

use App\Model\DataSource\Form\BrandFormDataSource;
use App\Model\Exceptions\BrandsException;
use App\Model\Repository\Table\BrandCategoryRepository;
use App\Model\Repository\Table\BrandRepository;
use App\types\Form\TFormBrand;
use Nette\Application\UI\Form;

class BrandsPresenter extends SecuredPresenter {

	public function __construct(
		private BrandRepository         $brandRepo,
		private BrandCategoryRepository $brandCategoryRepo,
		private BrandFormDataSource     $brandFormDS,
	) {
		parent::__construct();
	}

	public function renderDefault() {
		$t = $this->template;
		$t->brands = $this->brandRepo->findAllActive()->fetchAll();
	}

	/**
	 * Opens brand form in modal window
	 */
	public function handleShowAddBrandDialog(?int $id) {
		$this->template->showModal = true;
		if ($id) {
			$this['formBrand']->setDefaults(
				$this->brandFormDS->getDefaults($id)
			);
		}
		$this->redrawControl();
	}

	/**
	 * Basic brand edit/create form
	 * TODO: add logo uploader?
	 */
	public function createComponentFormBrand(): Form {
		$form = new Form();
		$form->getElementPrototype()->class("ajax");

		$brandCategories = $this->brandCategoryRepo->findAllActive()->fetchPairs("id", "label");

		$form->addHidden("id");
		$form->addText("label", "Název")->setRequired();
		$form->addSelect("category_id", "Kategorie", $brandCategories)->setRequired()->setPrompt("?");
		$form->addText("description", "Popis");
		$form->addTextArea("note", "Poznámka");
		$form->addSubmit("save", "Uložit");
		$form->onSuccess[] = function (Form $form, TFormBrand $values) {
			try {
				$this->brandFormDS->save($values);
				$this->flashMessage('Značka úspěšně uložena.', 'ok');
				$this->redrawControl();
			} catch (BrandsException $e) {
				$this->flashMessage($e->getMessage(), 'err');
			}
		};
		return $form;
	}

	/**
	 * Closes brand form modal window
	 */
	public function handleCloseModal() {
		$this->redrawControl("modal");
	}
}