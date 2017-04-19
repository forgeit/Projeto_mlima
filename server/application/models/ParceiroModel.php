<?php

class ParceiroModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'parceiro';
	}	

	function getValidation() {
		return array(
				'nome' => array('Nome', 'string', '255', true),
				'link' => array('Link', 'string', '255', true)
			);
	}
}