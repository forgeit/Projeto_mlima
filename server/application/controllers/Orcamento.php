<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orcamento extends MY_Controller {

	public function update() {
		if (!$this->isActive()) {
			return;
		}

		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$object = json_decode($data);

		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(10));
			return;
		}

		if ($this->checkExec(array('exec' => $this->OrcamentoModel->lerOrcamento($object->id)))) {	
			$this->printReturn(RET_OK);
		}
	}

	public function findNaoLidos() {
		if (!$this->isActive()) {
			return;
		}

		$countCal = $this->CalendarioModel->getEventosHoje();
		$countOrc = $this->OrcamentoModel->getOrcamentosNaoLidos();
		print_r(json_encode(array('orc' => $countOrc, 'cal'=> $countCal['count'])));
	}

	public function find() {
		if (!$this->isActive()) {
			return;
		}

		$elem = $this->OrcamentoModel->findById($this->uri->segment(3));
		
		$this->OrcamentoModel->lerOrcamento($elem['id']);

		print_r(json_encode($elem));
	}

	public function findAll() {
		if (!$this->isActive()) {
			return;
		}
		$this->printReturn(RET_OK, $this->OrcamentoModel->findAll());		
	}	

	public function remove() {
		if (!$this->isActive()) {
			return;
		}

		$data = $this->OrcamentoModel->findById($this->uri->segment(3));		
		if ($this->checkExec(array('exec' => $this->OrcamentoModel->remove($this->uri->segment(3))))) {
			$this->printReturn(RET_OK, null, Helper::getMessage(1));	
		}
		
	}
}