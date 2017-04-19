<?php

class UsuarioModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'usuario';
	}	

	function findByLoginAndSenha($login, $senha) {
		$this->db->where('login', $login);
		$this->db->where('senha', $senha);

		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return null;
		}
	}
	
}