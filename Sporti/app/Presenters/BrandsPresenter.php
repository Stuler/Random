<?php
declare(strict_types=1);

namespace App\Presenters;

use App\components\Viewer\ViewerComp;
use App\components\Viewer\ViewerCompFactory;
use App\Constants;
use App\Model\DataSource\Form\BrandFormDataSource;
use App\Model\Exceptions\BrandsException;
use App\Model\Repository\Table\BrandCategoryRepository;
use App\Model\Repository\Table\BrandRepository;
use App\types\Form\TFormBrand;
use Nette\Application\Attributes\Persistent;
use Nette\Application\UI\Form;

class BrandsPresenter extends SecuredPresenter {

	//	public ?string $order = null;
	//
	//	public int $itemsPerPage = Constants::ITEMS_PER_PAGE;
	//
	//	public int $radius = Constants::PAGES_SHOWN_RADIUS;

	public function __construct(
		private BrandCategoryRepository $brandCategoryRepo,
		private BrandFormDataSource     $brandFormDS,
		private ViewerCompFactory       $viewerCompFactory,
		private BrandRepository         $brandRepo,
	) {
		parent::__construct();
	}

	/**
	 * TODO: move paginator config into component
	 */
	public function renderDefault(int $page = 1) {

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
	 * Closes brand form modal window
	 */
	public function handleCloseDialog() {
		$this->redrawControl("modal");
	}

	/**
	 * Marks brand as deleted
	 */
	public function handleDeleteBrand(int $id) {
		//		$this->brandDM->deleteBrand($id);
		//		$this->redrawControl("brandsViewer");

	}

	public function handleSetItemsPerPage(int $itemsPerPage) {
		$this->itemsPerPage = $itemsPerPage;
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
		$form->addSelect("brand_category_id", "Kategorie", $brandCategories)->setRequired()->setPrompt("?");
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

	public function createComponentViewerComp(): ViewerComp {
		$viewer = $this->viewerCompFactory->create();
		$items = $this->brandRepo->findAllActive();
		$viewer->setItems($items);
		$viewer->setColumnLabel("label");
		$viewer->onDelete[] = function ($id) {
			bdump($id);
		};

		$viewer->onClick[] = function ($id) {
			bdump($id);
		};
		return $viewer;
	}

}