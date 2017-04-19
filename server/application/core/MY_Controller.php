<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH."helpers/jwt_helper.php");

class MY_Controller extends CI_Controller {

    public $emailContato = '';

	function __construct() {
        parent::__construct();
    }


    public function isActive() {
        $pathReq = $this->uri->uri_string;
        if (explode('/', $pathReq)[0] == 'public' ||  $pathReq != 'usuario/login') {
            $headers = getallheaders();
            if (isset($headers['X-Requested-With'])) {
                $auth = getallheaders()['X-Requested-With'];
                if (JWT::decodeWithTime($auth) !== 0) {
                    $this->printReturn(RET_LOGIN);
                    return false;
                }
            } else {
                $this->printReturn(RET_LOGIN);
                return false;
            }
        }
        return true;
    }

    public function printReturn($return, $data = null, $message = null) {
    	print_r(json_encode(array('res'=>$return, 'dataRes'=>$data, 'message'=>$message)));
    }

    public function checkValidation($valid) {
    	if ($valid !== OK) {
    		$this->printReturn(RET_ERROR, null, $valid);
    		return false;
    	} else {
    		return true;
    	}
    }

    public function checkExec($response) {
        $pathReq = $this->uri->uri_string;
        if (!$response['exec']) {
            if (strpos($pathReq, '/remove/') !== false) {
                $this->printReturn(RET_ERROR, null, Helper::getMessage(17));    
            } else {
                $this->printReturn(RET_ERROR, null, Helper::getMessage(10));
            }            
            return false;
        } else {
            return true;
        }
    }
    

}