<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Epgc_model extends MY_Model {

    function __construct() {
        $this->_table = ' epgc';
        $this->_primaryKey = 'id';
    }   

    public function check_unique_field_name($id = '', $field) {
            $this->db->where('lic_no', $field);
            if($id) {
                $this->db->where_not_in('id', $id);
            }
            return $this->db->get($this->_table)->num_rows();
    }

    public function getResult($where = '') {

       $select = "".$this->_table.".*, daheader.da_no, daheader.da_date, datype.datype, party.party as buyer, country.country, product.product as product_name, daitems.quantity"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('daheader', $this->_table.'.id = daheader.epgc_lic_no', 'left');
        $this->db->join('daitems', 'daheader.id = daitems.da_no', 'left');
        $this->db->join('datype', 'daheader.da_type = datype.id', 'left');
        $this->db->join('party', 'daheader.buyer = party.id', 'left');
        $this->db->join('country', 'daheader.country = country.id', 'left');
        $this->db->join('product', 'daitems.product = product.id', 'left');
        
        if(!empty($where)) {
             $this->db->where('daheader.epgc_lic_no', $where);
        }
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
}
