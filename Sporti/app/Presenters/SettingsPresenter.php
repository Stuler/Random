<?php
declare(strict_types=1);

namespace App\Presenters;

use App\Model\DataSource\Form\BrandCategoryFormDataSource;
use App\Model\Exceptions\BrandsCategoryException;
use App\Model\Repository\Table\BrandCategoryRepository;
use App\types\Form\TFormBrandCategory;
use Nette\Application\UI\Form;

class SettingsPresenter extends SecuredPresenter {

	public function __construct(
		private BrandCategoryFormDataSource $brandCategoryFormDS,
		private BrandCategoryRepository     $brandCategoryRepo,
	) {
		parent::__construct();
	}

	public function renderDefault() {
		$t = $this->template;
		$t->categories = $this->brandCategoryRepo->findAllActive()->fetchAll();
	}

	/**
	 * Opens brand category form in modal window
	 */
	public function handleShowAddBrandCategoryDialog(?int $id) {
		$this->template->showModal = true;
		if ($id) {
			$this['formBrandCategory']->setDefaults(
				$this->brandCategoryFormDS->getDefaults($id)
			);
		}
		$this->redrawControl();
	}

	/**
	 * Basic brand edit/create form
	 */
	public function createComponentFormBrandCategory(): Form {
		$form = new Form();
		$form->getElementPrototype()->class("ajax");

		$form->addHidden("id");
		$form->addText("label", "Název")->setRequired();
		$form->addText("description", "Popis");
		$form->addTextArea("note", "Poznámka");
		$form->addSubmit("save", "Uložit");
		$form->onSuccess[] = function (Form $form, TFormBrandCategory $values) {
			try {
				$this->brandCategoryFormDS->save($values);
				$this->flashMessage('Kategorie úspěšně uložena.', 'ok');
				$this->redrawControl();
			} catch (BrandsCategoryException $e) {
				$this->flashMessage($e->getMessage(), 'err');
			}
		};
		return $form;
	}

	/**
	 * Closes brand category form modal window
	 */
	public function handleCloseModal() {
		$this->redrawControl("modal");
	}
}