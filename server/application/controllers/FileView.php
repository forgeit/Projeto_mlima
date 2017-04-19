<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FileView extends MY_Controller {

	public function view() {
		$img = array();
		if (!$this->uri->segment(2) || $this->uri->segment(2) == 'null') {
			$img['type'] = 'image/jpeg';
			$img['caminho'] = 'images/image-loading.jpg';			
		} else {
			$img = $this->ArquivoModel->findById($this->uri->segment(2));			
		}
		$remoteImage = $img['caminho'];
		$imginfo = getimagesize($remoteImage);
		
		header('Content-type: '.$img['type']);
		readfile($remoteImage);
	}

}