<?php

namespace MainBundle\Services;

class PaginationWidget {
	protected $size;
	protected $firstPage;
	protected $lastPage;
	protected $actualPage;
	protected $previousPage;
	protected $nextPage;
	
	private $offsetToCentrumPosition;
	
	public function __construct($actualPage = 1, $numberOfPages = 1) {
		$this->size = 5;
		$this->actualPage = $actualPage;
		$this->numberOfPages = $numberOfPages;
		
		if ($numberOfPages <= $this->size)
			$this->size = $numberOfPages;
		
		$this->offsetToCentrumPosition = ( int ) ($this->size / 2);
		
		if ($actualPage > $this->offsetToCentrumPosition)
			$this->NumberOfPagesGreaterThanDistanceToCenter();		
		else 
			$this->NumberOfPagesSmallerThanDistanceToCenter();

		$this->setPreviousPageButton();
		$this->setNextPageButton();
		
	}
	private function NumberOfPagesGreaterThanDistanceToCenter() {
		if ($this->IsDisplayedLastPage ()) {
			$this->lastPage = $this->numberOfPages;
			$this->firstPage = $this->lastPage - $this->size + 1;
		} else {
			$this->firstPage = $this->actualPage - $this->offsetToCentrumPosition;
			$this->lastPage = $this->actualPage + $this->offsetToCentrumPosition;
		}
	}
	private function IsDisplayedLastPage() {
		$distanceToEnd = $this->numberOfPages - $this->offsetToCentrumPosition;
		if ($this->actualPage > $distanceToEnd) {
			return true;
		} else
			return false;
	}
	
	private function NumberOfPagesSmallerThanDistanceToCenter() {
		$this->firstPage = 1;
		$this->lastPage = $this->size;
	}
	
	private function setNextPageButton(){
		$this->nextPage = $this->actualPage++;
		if ($this->nextPage >= $this->numberOfPages)
			$this->nextPage = $this->numberOfPages;	
	}
	private function setPreviousPageButton(){
		$this->previousPage = $this->actualPage-1;
		if ($this->previousPage <= 0)
			$this->previousPage = 1;
	}
	public function getFirstPage() {
		return $this->firstPage;
	}
	public function getLastPage() {
		return $this->lastPage;
	}
	public function getActualPage() {
		return $this->actualPage;
	}
	public function getPreviousPage() {
		return $this->previousPage;
	}
	public function getNextPage() {
		return $this->nextPage;
	}

}