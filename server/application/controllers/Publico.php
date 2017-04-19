<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publico extends MY_Controller {

	public function home() {
		$complexo = $this->ComplexoModel->getRandomOfTable('complexo');
		$equipe = $this->EquipeModel->getRandomOfTable('equipe');
		$atracao = $this->AtracaoModel->getRandomOfTable('atracao');
		$buffet = $this->BuffetModel->getRandomOfTable('buffet');
		$parceiroList = $this->ParceiroModel->findAll();

		print_r(json_encode(array(
			'complexo'=>$complexo,
			'equipe'=>$equipe,
			'atracao'=>$atracao,
			'buffet'=>$buffet,
			'parceiroList'=>$parceiroList
			)));
	}

	public function atracao() {
		print_r(json_encode($this->AtracaoModel->findAll()));
	}

	public function equipe() {
		print_r(json_encode($this->EquipeModel->findAll()));
	}

	public function buffet() {
		print_r(json_encode($this->BuffetModel->findAll()));
	}

	public function complexo() {
		print_r(json_encode($this->ComplexoModel->findAll()));
	}

	public function orcamento() {
		print_r(json_encode(array(
			'equipeList' =>$this->EquipeModel->findAll(),
			'decoracaoList' =>$this->DecoracaoModel->findAll()
			)));	
	}

	public function pacote() {
		$listPacote = $this->PacoteModel->findAll();
		for ($x=0; $x<count($listPacote); $x++) {
			$listSecao = $this->PacoteModel->findSecoes($listPacote[$x]['id']);
			for ($y=0; $y<count($listSecao); $y++) {
				$listSecao[$y]['listItem'] = $this->SecaoModel->findItens($listSecao[$y]['id']);
			}
			$listPacote[$x]['listSecao'] = $listSecao;
		}

		print_r(json_encode($listPacote));
	}

	public function saveOrcamento() {
		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$object = json_decode($data);

		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(10));
			return;
		}

		$valid = Helper::inputValidation($object, $this->OrcamentoModel->getValidation());
		if ($this->checkValidation($valid)) {
			if ($object->data) {
				$object->data = Helper::strDatetoDate($object->data);
			}
			if ($this->checkExec(array('exec' => $this->OrcamentoModel->save($object)))) {			
				$this->printReturn(RET_OK, null, Helper::getMessage(2));

				$message = ''.
				'NOME: ' . $object->nome . "\r\n" .
				'TELEFONE: ' . $object->telefone . "\r\n" .
				'EMAIL: ' . $object->email . "\r\n" .
				'NOME DO ANIVERSARIANTE: ' . $object->nome_aniversariante . "\r\n" .
				'IDADE DO ANIVERSARIANTE: ' . $object->idade_aniversariante . "\r\n" .
				'DATA DA FESTA: ' . $object->data . "\r\n" .
				'NÚMERO DE CONVIDADOS: ' . $object->num_convidados . "\r\n" .
				'ONDE NOS ENCONTROU: ' . $object->onde_encontrou . "\r\n" .
				'OBS.: ' . wordwrap($object->obs, 70, "\r\n");

				//Helper::sendMail($this->emailContato, null, 'Orçamento Site', $message);
			} 
		} else {
			$this->OrcamentoModel->printError();
		}		
	}
	
	public function saveContato() {
		if (true) {
			$this->printReturn(RET_OK, null, Helper::getMessage(3));
			return;
		}

		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$object = json_decode($data);

		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(10));
			return;
		}

		$message = ''.
		'NOME: ' . $object->nome . "\r\n" .
		'TELEFONE: ' . $object->telefone . "\r\n" .
		'EMAIL: ' . $object->email . "\r\n" .
		'MENSAGEM: ' . wordwrap($object->mensagem, 70, "\r\n");

		Helper::sendMail($this->emailContato, null, 'Contato Site', $message);

		$this->printReturn(RET_OK, null, Helper::getMessage(3));
	}

	public function newsletter() {
		$data = $this->security->xss_clean($this->input->raw_input_stream);
		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(10));
			return;
		}

		$data = array('email' => str_replace("\"", "", $data));
		$object = (object) $data;

		if ($this->NewsletterModel->existEmail($object->email)) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(18));
			return;	
		}
		
		$valid =  Helper::inputValidation($object, $this->NewsletterModel->getValidation());
		if ($this->checkValidation($valid) && $this->checkExec(array('exec' => $this->NewsletterModel->save($object)))) {			
			$this->printReturn(RET_OK, $this->NewsletterModel->getLastInsertedId(), Helper::getMessage(0));
		}
	}

}