<?php

class CalendarioModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'calendario';
	}	

	function getEventosHoje() {
		$query = $this->db->query("SELECT COUNT(*) AS count FROM calendario WHERE (data_ini = CURRENT_DATE AND data_fim IS NULL) OR (data_ini <= CURRENT_DATE AND data_fim >= CURRENT_DATE)");
		 if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
	}

	function getValidation() {
		return array(
			'titulo' => array('Título', 'string', '255', true),
			'data_ini' => array('Data Inicial', 'date', null, true),
			'data_fim' => array('Data Final', 'date', null, false),
			);
	}
}