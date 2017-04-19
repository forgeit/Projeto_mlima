<?php

class ClienteModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'cliente';
	}	

	function findRelatorio1() {
		$query = $this->db->query(
			"SELECT c.id, c.nome, c.telefone, c.email, a.nome as nomeAniversariante, DATE_FORMAT(a.dt_nasc, '%d/%m/%Y') as dtNascAniversariante " .
			"FROM cliente c " .
			"JOIN aniversariante a ON a.id_cliente = c.id " .
			"ORDER BY EXTRACT(month FROM a.dt_nasc) ASC, EXTRACT(day FROM a.dt_nasc) ASC"
			);
		return $query->result_array();
	}

	function getValidation() {
		return array(
			'nome' => array('Nome', 'string', '255', true),
			'cpf' => array('CPF', 'cpf', '14', false),
			'cep' => array('CEP', 'cep', '8', false),
			'endereco' => array('Endereço', 'string', '500', false),
			'telefone' => array('Telefone', 'string', '16', false),
			'email' => array('Email', 'string', '255', false)
			);
	}
}