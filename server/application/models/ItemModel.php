<?php

class ItemModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'item';
	}	

	function getValidation() {
		return array(
			);
	}
}