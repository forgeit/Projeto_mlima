<?php

class DecoracaoModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'decoracao';
	}	

	function getValidation() {
		return array(
				'titulo' => array('Título', 'string', '255', true)
			);
	}
}