<?php
declare(strict_types=1);

namespace App\Presenters;

use App\Model\BrandDataManager;
use App\Model\DataSource\Form\BrandFormDataSource;
use App\Model\Exceptions\BrandsException;
use App\Model\Repository\Table\BrandCategoryRepository;
use App\types\Enum\EOrderType;
use App\types\Form\TFormBrand;
use Nette\Application\Attributes\Persistent;
use Nette\Application\UI\Form;
use Nette\Utils\Paginator;

class BrandsPresenter extends SecuredPresenter {

	#[Persistent]
	public ?string $order = null;

	public const ITEMS_PER_PAGE = 3;

	public function __construct(
		private BrandCategoryRepository $brandCategoryRepo,
		private BrandFormDataSource     $brandFormDS,
		private BrandDataManager        $brandDM,
	) {
		parent::__construct();
	}

	public function renderDefault(int $page = 1, int $itemsPerPage = self::ITEMS_PER_PAGE) {
		$t = $this->template;
		$paginator = new Paginator();
		$paginator->setItemCount($this->brandDM->getActiveBrandsCount());
		$paginator->setItemsPerPage($itemsPerPage);
		$paginator->setPage($page);
		if ($this->order && in_array($this->order, EOrderType::getCases())) {
			$t->brands = $this->brandDM->getActiveBrands($this->order, $paginator->getLength(), $paginator->getOffset());
		} else {
			$t->brands = $this->brandDM->getActiveBrands(null, $paginator->getLength(), $paginator->getOffset());
		}
		$t->paginator = $paginator;
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
		$this->brandDM->deleteBrand($id);
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