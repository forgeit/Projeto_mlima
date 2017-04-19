<?php

class ComplexoModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'complexo';
	}	

	function getValidation() {
		return array(
				'titulo' => array('Título', 'string', '255', true)
			);
	}
}