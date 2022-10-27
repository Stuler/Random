<?php
declare(strict_types=1);

namespace App\Presenters;

use App\Model\DataSource\Form\BrandFormDataSource;
use App\Model\DataSource\Viewer\BrandViewerDataSource;
use App\Model\Exceptions\BrandsException;
use App\Model\ProcessManager\BrandProcessManager;
use App\Model\Repository\Table\BrandCategoryRepository;
use App\Model\Repository\Table\BrandRepository;
use App\types\Form\TFormBrand;
use Nette\Application\UI\Form;

class BrandsPresenter extends SecuredPresenter {

	private ?string $order = null;

	public function __construct(
		private BrandCategoryRepository $brandCategoryRepo,
		private BrandFormDataSource     $brandFormDS,
		private BrandViewerDataSource   $brandViewerDS,
	) {
		parent::__construct();
	}

	public function renderDefault() {
		$t = $this->template;
		$t->brands = $this->brandViewerDS->getActiveBrands($this->order);
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
	 * Changes brands order
	 */
	public function handleChangeOrder(string $order) {
		$this->order = $order;
		$this->redrawControl("brandsViewer");
	}

	/**
	 * Marks brand as deleted
	 */
	public function handleDeleteBrand(int $id) {
		$this->brandViewerDS->deleteBrand($id);
		$this->redrawControl("brandsViewer");
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

}