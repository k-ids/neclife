<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Declaration_model extends MY_Model {

    function __construct() {
        $this->_table = 'declaration';
        $this->_primaryKey = 'id';
    }   

    public function check_unique_field_name($id = '', $field) {
            $this->db->where('declaration', $field);
            if($id) {
                $this->db->where_not_in('id', $id);
            }
            return $this->db->get($this->_table)->num_rows();
    }
}
