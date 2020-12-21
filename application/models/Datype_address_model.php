<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Datype_address_model extends MY_Model {

    function __construct() {
        $this->_table = 'datype_address';
        $this->_primaryKey = 'id';
    }   

    public function findAllAddress() {

         $select = "".$this->_table.".*, datype.datype";
        $this->db->select($select);
    	$this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->from($this->_table);
        $this->db->order_by('id',"DESC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }
}
