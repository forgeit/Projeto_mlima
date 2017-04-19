<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
    var $table = "";
    
    function __construct() {
        parent::__construct();
    }
    
    function save($data) {
        if (!isset($data)) {
            return false;
        }
        $result = $this->db->insert($this->table, $data);
        self::printError();
        return $result;
    }    
    
    function findById($id) {
        if(is_null($id)) {
            return false;
        }

        $this->db->where('id', $id);

        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }
    
    function findAll($sort = 'id', $order = 'asc') {
        $this->db->order_by($sort, $order);

        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }
    
    function update($id, $data) {
        if(is_null($id) || !isset($data)) {
            return false;
        }

        $this->db->where('id', $id);
        $result =  $this->db->update($this->table, $data);

        self::printError();
        return $result;
    }
    
    function remove($id) {
        if(is_null($id)) {
            return false;
        }

        $this->db->where('id', $id);
        $result = $this->db->delete($this->table);

        self::printError();
        return $result;
    }

    function getLastInsertedId() {
        return $this->db->insert_id();
    }

    function getRandomOfTable($table) {
        $query = $this->db->query("SELECT * FROM ".$table." ORDER BY RAND() LIMIT 1");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function printError() {   
        $err = $this->db->error();
        if (isset($err) && $err['message']) {
            $file = APPPATH.'/logs/error.log';
            // The new person to add to the file
            $person = "\n".date('d/m/y H:i:s').' - '.$err['message'];
            // Write the contents to the file, 
            // using the FILE_APPEND flag to append the content to the end of the file
            // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
            file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
        }
    }
}