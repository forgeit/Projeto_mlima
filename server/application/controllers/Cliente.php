<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends MY_Controller {

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

		$valid =  Helper::inputValidation($object, $this->ClienteModel->getValidation());
		if ($this->checkValidation($valid) && $this->checkExec(array('exec' => $this->ClienteModel->update($object->id, $object)))) {	
			$response = array('exec' => $this->ClienteModel->update($object->id, $object));
			$this->printReturn(RET_OK, $object->id, Helper::getMessage(0));
		}
	}

	public function find() {
		if (!$this->isActive()) {
			return;
		}

		print_r(json_encode($this->ClienteModel->findById($this->uri->segment(3))));
	}

	public function findAll() {
		if (!$this->isActive()) {
			return;
		}
		$this->printReturn(RET_OK, $this->ClienteModel->findAll());		
	}

	public function insert() {
		if (!$this->isActive()) {
			return;
		}		

		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$object = json_decode($data);
		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(10));
			return;
		}
		
		$valid =  Helper::inputValidation($object, $this->ClienteModel->getValidation());
		if ($this->checkValidation($valid) && $this->checkExec(array('exec' => $this->ClienteModel->save($object)))) {			
			if ($object->email) {
				$news = array('email' => $object->email);
				$this->NewsletterModel->save($news);
			}
			$this->printReturn(RET_OK, $this->ClienteModel->getLastInsertedId(), Helper::getMessage(0));
		}	
	}

	public function remove() {
		if (!$this->isActive()) {
			return;
		}

		$this->AniversarianteModel->removeByIdCliente($this->uri->segment(3));		
		$data = $this->ClienteModel->findById($this->uri->segment(3));		
		if ($this->checkExec(array('exec' => $this->ClienteModel->remove($this->uri->segment(3))))) {			
			$this->printReturn(RET_OK, null, Helper::getMessage(1));	
		}
		
	}
}