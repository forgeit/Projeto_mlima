<?php

class BuffetModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'buffet';
	}	

	function getValidation() {
		return array(
				'titulo' => array('Título', 'string', '255', true)
			);
	}
}