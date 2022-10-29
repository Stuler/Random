<?php
declare(strict_types=1);

namespace App\components\Viewer;

use App\Constants;
use App\types\Enum\EOrderType;
use Nette\Application\Attributes\Persistent;
use Nette\Application\UI\Control;
use Nette\Database\Table\Selection;
use Nette\Utils\Paginator;

/**
 * Component represents simple viewer
 * Items labels/names are shown to user
 * Basic functions (changing view order, edit, delete) are allowed
 */
class ViewerComp extends Control {

	/**
	 * Returns desired page from paginator
	 */
	#[Persistent]
	public int $page = 1;

	/**
	 * Basic array of items data
	 */
	#[Persistent]
	public ?Selection $items = null;

	/**
	 * Current order of items
	 */
	#[Persistent]
	public ?string $order = null;

	/**
	 * Count of number of items shown in one page
	 */
	#[Persistent]
	public int $itemsPerPage = Constants::ITEMS_PER_PAGE;

	/**
	 * Selection table column to show
	 */
	public string $columnLabel;

	/**
	 * Number of pages shown adjacent to the current paginator page
	 */
	public int $radius = Constants::PAGES_SHOWN_RADIUS;

	/**
	 * Options for items per page count
	 */
	public array $itemsPerPageOptions = [];

	/**
	 * Calls processes on DELETE button click event
	 */
	public array|\Closure $onDelete;

	/**
	 * Calls processes on EDIT button click event
	 */
	public array|\Closure $onClick;

	/**
	 * TODO: pagination into component
	 */
	public function render() {
		$t = $this->template;
		$paginator = new Paginator();
		$paginator->setItemCount($this->items->count());
		$paginator->setBase(1);
		$paginator->setItemsPerPage($this->itemsPerPage);
		$paginator->setPage($this->page);
		$page = $paginator->getPage();
		$pages = $paginator->getPageCount();

		$t->itemsPerPage = $this->itemsPerPage;
		$t->page = $page;
		$t->pages = $pages;
		$t->left = max($this->page - $this->radius, 1);
		$t->right = $page + $this->radius <= $pages ? $page + $this->radius : $pages;
		$t->items = $this->getItemsDataForPaginator($paginator->getLength(), $paginator->getOffset());
		$t->itemsPerPageOptions = $this->itemsPerPageOptions;
		$t->paginator = $paginator;
		$t->setFile(__DIR__ . "/viewerComp.latte");
		$t->render();
	}

	/**
	 * Returns items data array in accordance with pagination setup
	 */
	public function getItemsDataForPaginator(?int $limit = null, ?int $offset = null): array {
		$selection = $this->items;
		if ($this->order && in_array($this->order, EOrderType::getCases())) {
			if ($this->order === EOrderType::getASC()) {
				$selection->order($this->columnLabel . " ASC")->limit($limit, $offset);
			} else {
				$selection->order($this->columnLabel . " DESC")->limit($limit, $offset);
			}
		} else {
			$selection = $this->items->order("date_created DESC")->limit($limit, $offset);
		}
		return $selection->fetchAll();
	}

	/**
	 * Sets array of items data do view
	 */
	public function setItems(selection $items) {
		$this->items = $items;
	}

	/**
	 * Sets column name containing item label
	 */
	public function setColumnLabel(string $columnLabel) {
		$this->columnLabel = $columnLabel;
	}

	/**
	 * Sets an array of items per page choices for paginator
	 */
	public function setItemsPerPageOptions(array $options) {
		$this->itemsPerPageOptions = $options;
	}

	public function setItemsPerPageDefault(int $itemsPerPage) {
		$this->itemsPerPage = $itemsPerPage;
	}

	/**
	 * Changes view order
	 */
	public function handleChangeOrder(string $order) {
		$this->order = $order;
		$this->redrawControl();
	}

	/**
	 * Redirects to page set by user from paginator
	 */
	public function handleSetPage(int $page) {
		$this->page = $page;
		$this->redrawControl();
	}

	/**
	 * Sets count of items shown in one page
	 */
	public function handleSetItemsPerPage(int $itemsPerPage) {
		$this->itemsPerPage = $itemsPerPage;
		$this->redrawControl();
	}

	/**
	 * Opens brand form in modal window
	 */
	public function handleShowEditDialog(?int $id) {
		$this->onClick($id);
		$this->redrawControl();
	}

	/**
	 * Calls processes on DELETE button click event
	 */
	public function handleDelete(int $id) {
		$this->onDelete($id);
		$this->redrawControl();
	}
}