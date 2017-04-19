<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter extends MY_Controller {

	public function findAll() {
		if (!$this->isActive()) {
			return;
		}
		$this->printReturn(RET_OK, $this->NewsletterModel->findAll());		
	}

	public function insert() {
		if (!$this->isActive()) {
			return;
		}		

		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$data['email'] = $data;
		$object = json_decode($data);		
		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(10));
			return;
		}

		if ($this->NewsletterModel->existEmail($object->email)) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(18));
			return;	
		}
		
		$valid =  Helper::inputValidation($object, $this->NewsletterModel->getValidation());
		if ($this->checkValidation($valid) && $this->checkExec(array('exec' => $this->NewsletterModel->save($object)))) {			
			$this->printReturn(RET_OK, $this->NewsletterModel->getLastInsertedId(), Helper::getMessage(0));
		}		
	}

	public function remove() {
		if (!$this->isActive()) {
			return;
		}

		$data = $this->AniversarianteModel->findById($this->uri->segment(3));		
		if ($this->checkExec(array('exec' => $this->NewsletterModel->remove($this->uri->segment(3))))) {			
			$this->printReturn(RET_OK, null, Helper::getMessage(1));	
		}
		
	}
}