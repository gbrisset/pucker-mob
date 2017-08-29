<?php 

// This is a helper class to make paginating
// records easier
class Pagination {

	public static $sortLinks = [
		['id' => 1,
			'label' => 'Newest',
			'shortname' => 'mr'],
		['id' => 2,
			'label' => 'Title: A-Z',
			'shortname' => 'az'],
		['id' => 3,
			'label' => 'Title: Z-A',
			'shortname' => 'za'],
		['id' => 4,
			'label' => 'Status: Pending',
			'shortname' => '2'],
		['id' => 5,
			'label' => 'Status: Draft',
			'shortname' => '3'],
		['id' => 6,
			'label' => 'Name',
			'shortname' => 'az'],
		['id' => 7,
			'label' => 'Email Address',
			'shortname' => 'az'],
	];
	
	public $current_page;
	public $per_page;
	public $total_count;
	
	// Since these attributes are the core of this object, let's set
	// them in the contructor
	
	public function __construct($page=1, $per_page=10, $total_count=0) {

		// So...we can't make a Pagination object of we don't have the info
		// that is passed in the arg's above.
		
		$this->current_page = (int)$page;
		$this->per_page = (int)$per_page;
		$this->total_count = (int)$total_count;
	}

	public function offset() {
		// Assuming 10 items per page:
		// page 1 has an offset of 0	(1-1) * 10
		// page 2 has an offset of 10	(2-1) * 10
		//		in other words, page 2 starts with item 21
		return ($this->current_page - 1) * $this->per_page;
		
	}

	public function total_pages() {
		return ceil($this->total_count/$this->per_page);	
	}
	
	public function previous_page() {
		return $this->current_page - 1;	
	}
	
	public function next_page() {
		return $this->current_page + 1;	
	}
	
	public function has_previous_page() {
		return $this->previous_page() >= 1 ? true : false;
	}
	
	public function has_next_page() {
		return $this->next_page() <= $this->total_pages() ? true : false;
	}


}


?>