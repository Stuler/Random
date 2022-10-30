<?php
declare(strict_types=1);

namespace App\Presenters;

use App\components\Viewer\ViewerComp;
use App\components\Viewer\ViewerCompFactory;
use App\Model\DataSource\Form\BrandFormDataSource;
use App\Model\Exceptions\BrandsException;
use App\Model\ProcessManager\BrandProcessManager;
use App\Model\Repository\Table\BrandCategoryRepository;
use App\Model\Repository\Table\BrandRepository;
use App\types\Form\TFormBrand;
use Nette\Application\UI\Form;

class BrandsPresenter extends SecuredPresenter {

	public function __construct(
		private BrandCategoryRepository $brandCategoryRepo,
		private BrandFormDataSource     $brandFormDS,
		private ViewerCompFactory       $viewerCompFactory,
		private BrandRepository         $brandRepo,
		private BrandProcessManager     $brandPM,
	) {
		parent::__construct();
	}

	/**
	 * TODO: move paginator config into component
	 */
	public function renderDefault() {
	}

	/**
	 * Opens brand form in modal window
	 */
	public function handleShowAddBrandDialog(?int $id = null) {
		$this->template->showModal = true;
		if ($id) {
			$this['formBrand']->setDefaults(
				$this->brandFormDS->getDefaults($id)
			);
		}
		$this->redrawControl("modal");
	}

	/**
	 * Closes brand form modal window
	 */
	public function handleCloseDialog() {
		$this->redrawControl("modal");
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
		$form->addText("label", "Název")->setRequired("Položka 'Název' musí být vyplněna!");
		$form->addSelect("brand_category_id", "Kategorie", $brandCategories)->setHtmlAttribute("class", "input-field")->setPrompt("?");
		$form->addText("description", "Popis");
		$form->addTextArea("note", "Poznámka");
		$form->addSubmit("save", "Uložit");
		$form->onSuccess[] = function (Form $form, TFormBrand $values) {
			try {
				$this->brandFormDS->save($values);
				$this->flashMessage('Značka úspěšně uložena.', 'ok');
				$this->redrawControl();
			} catch (BrandsException $e) {
				$this->redrawControl("flashes");
				$this->flashMessage($e->getMessage(), 'err');
			}
		};
		return $form;
	}

	/**
	 * Brands Viewer component
	 */
	public function createComponentViewerComp(): ViewerComp {
		$viewer = $this->viewerCompFactory->create();
		$items = $this->brandRepo->findAllActive();
		$viewer->setItems($items);
		$viewer->setColumnLabel("label");
		$viewer->setItemsPerPageOptions([5, 10, 15]);
		$viewer->setItemsPerPageDefault(5);

		$viewer->onDelete[] = function ($id) {
			try {
				$this->brandPM->delete($id);
				$this->flashMessage('Značka úspěšně odstráněna.', 'ok');
				$this->redrawControl("flashes");
			} catch (\Exception $e) {
				$this->redrawControl("flashes");
				$this->flashMessage($e->getMessage(), 'err');
			};
		};

		$viewer->onClick[] = function (?int $id) {
			$this->handleShowAddBrandDialog($id);
		};
		return $viewer;
	}
}