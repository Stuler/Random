<?php
declare(strict_types=1);

namespace App\components\Viewer;

use App\Constants;
use App\types\Enum\EOrderType;
use Nette\Application\Attributes\Persistent;
use Nette\Application\UI\Control;
use Nette\Database\Table\Selection;
use Nette\Utils\Paginator;

class ViewerComp extends Control {

	#[Persistent]
	public int $page = 1;

	#[Persistent]
	public ?Selection $items = null;

	#[Persistent]
	public ?string $order = null;

	#[Persistent]
	public int $itemsPerPage = Constants::ITEMS_PER_PAGE;

	public string $columnLabel;

	public int $radius = Constants::PAGES_SHOWN_RADIUS;

	public array|\Closure $onDelete;

	public array|\Closure $onClick;

	public function __construct() {
	}

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
		$t->paginator = $paginator;
		$t->setFile(__DIR__ . "/viewerComp.latte");
		$t->render();
	}

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

	public function setItems(selection $items) {
		$this->items = $items;
	}

	public function setColumnLabel(string $columnLabel) {
		$this->columnLabel = $columnLabel;
	}

	/**
	 * Changes brands order
	 */
	public function handleChangeOrder(string $order) {
		$this->order = $order;
		$this->redrawControl("viewer");
	}

	public function handleSetItemsPerPage(int $itemsPerPage) {
		$this->itemsPerPage = $itemsPerPage;
		$this->redrawControl("viewer");
	}

	/**
	 * Opens brand form in modal window
	 */
	public function handleShowAddDialog(?int $id) {

	}

	public function handleDelete(int $id) {
		$this->onDelete($id);
	}

	public function handleSetPage(int $page) {
		$this->page = $page;
		$this->redrawControl("viewer");
	}

}