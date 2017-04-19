<?php

class AtracaoModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'atracao';
	}	

	function getValidation() {
		return array(
				'titulo' => array('Título', 'string', '255', true)
			);
	}
}