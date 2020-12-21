<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Department_model extends MY_Model {

    function __construct() {
        $this->_table = 'department';
        $this->_joinTable = 'datype';
        $this->_primaryKey = 'id';
    }

    public function getJoinData() {

    	$this->db->select("$this->_table.*, $this->_joinTable.datype as datype")
         ->from($this->_table)
         ->join($this->_joinTable, "$this->_table.da_type = $this->_joinTable.id");
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function department($id) {
        
        return $this->db->get_where( $this->_table, array('da_type'=> $id))->result_array();
    }

}
