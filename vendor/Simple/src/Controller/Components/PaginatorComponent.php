<?php  
	namespace Simple\Controller\Components;

	class PaginatorComponent
	{
		private $listQuantity;

		private $totalQuantity = 50;

		private $currentPage = 1;

		private $buttonsPaginator;

		private $pageLink;

		public function showPage(int $page)
		{
			$this->setCurrentPage($page);

			return $this;
		}

		public function buttonsLink(string $link)
		{
			$this->setButtonLink($link);

			return $this;
		}

		public function itensTotalQuantity(int $total)
		{
			$this->setTotalQuantity($total);

			return $this;
		}

		public function limit(int $quantity)
		{
			$this->setListQuantity($quantity);

			return $this;
		}

		public function display()
		{
			return $this->text() . $this->buttons();
		}

		protected function buttons()
		{
			$buttonsPaginator = '<ul class="pagination pull-right">';
			$currentPage = $this->getCurrentPage();
			$totalPages = $this->getTotalPages();
			$pagesToShow = $currentPage + 10;

			for ($page = 1; $page <= $totalPages; $page++) {
				if ($page === $currentPage) {
					$buttonsPaginator .= '
						<li class="active"><a>' . $page . '</a></li>
					';
				}
				else {
					$buttonsPaginator .= '
						<li>
							<a href="' . $this->getButtonLink() . $page . '">
								' . $page . '
							</a>
						</li>
					';
				}
			}

			return $buttonsPaginator . '</ul>';
		}

		protected function text()
		{
			return '<div class="pull-right list-shown">
				<p>
					Página <strong>' . $this->getCurrentPage() . '</strong>,
					listando <strong>' . $this->getShownQuantity() . '</strong>
					itens de <strong>' . $this->getTotalQuantity() . '</strong>.
				</p>
			</div>';
		}

		protected function setButtonLink(string $link)
		{
			$this->pageLink = $link;
		}

		public function getButtonLink()
		{
			return $this->pageLink;
		}

		protected function setListQuantity(int $quantity)
		{
			$this->listQuantity = $quantity;
		}

		public function getListQuantity()
		{
			return $this->listQuantity;
		}

		protected function setCurrentPage(int $page)
		{
			if (strlen($page) <= 8) {
				$this->currentPage = $page;
			}
		}

		public function getCurrentPage()
		{
			return $this->currentPage;
		}

		protected function setTotalQuantity(int $total)
		{
			$this->totalQuantity = $total;
		}

		public function getTotalQuantity()
		{
			return $this->totalQuantity;
		}

		public function getStartPosition()
		{
			$startPosition = $this->getListQuantity() * ($this->getCurrentPage() - 1);

			return ($startPosition > 0) ? $startPosition : 0;
		}

		public function getShownQuantity()
		{
			$shownQuantity = $this->getCurrentPage() * $this->getListQuantity();

			if ($shownQuantity > $this->getTotalQuantity()) {
				return $this->getTotalQuantity();
			}
			return $shownQuantity;
		}

		public function getTotalPages()
		{
			return (int) round(
				$this->getTotalQuantity() / $this->getListQuantity()
			);
		}
	}