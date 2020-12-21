<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Audittrail_model extends MY_Model {

    function __construct() {
        $this->_table = 'audittrial';
        $this->_primaryKey = 'id';
    }
   

    public function get_result($first_date = '', $second_date = '') {

        $this->db->where('transaction_date >=', $first_date);
        $this->db->where('transaction_date <=', $second_date);
        $query =  $this->db->get($this->_table);
        return $query->result_array();
    }


}
