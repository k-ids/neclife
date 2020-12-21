<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Financialyear_model extends MY_Model {

    function __construct() {
        $this->_table = 'financial_year';
        $this->_primaryKey = 'id';
    }

    public function check_unique_field_name($id = '', $field) {
        $this->db->where('financial_year', $field);
        if($id) {
            $this->db->where_not_in('id', $id);
        }
        return $this->db->get($this->_table)->num_rows();
    }

   
}
