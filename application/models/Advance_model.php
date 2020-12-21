<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advance_model extends MY_Model {

    function __construct() {
        $this->_table = 'advance';
        $this->_primaryKey = 'id';
    }   

    public function check_unique_field_name($id = '', $field) {
            $this->db->where('lic_no', $field);
            if($id) {
                $this->db->where_not_in('id', $id);
            }
            return $this->db->get($this->_table)->num_rows();
    }


    public function getAll() {

        $select = "".$this->_table.".*,  datype.datype as datype_name, product.product as product_name"; 
         $this->db->select( $select );
         $this->db->from($this->_table);
         $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
         $this->db->join('product',  $this->_table.'.product = product.id', 'left');
         $this->db->order_by('id', 'DESC');
         $query = $this->db->get();
         $result = $query->result_array();
         return $result;
    }

    public function findLicense($id) {

        $select = "".$this->_table.".*,  datype.datype as datype_name, product.product as product_name"; 
         $this->db->select( $select );
         $this->db->from($this->_table);
         $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
         $this->db->join('product',  $this->_table.'.product = product.id', 'left');
         $this->db->where($this->_table .'.'. $this->_primaryKey, $id);
         $query = $this->db->get();
         $result = $query->row_array();
         return $result;
    }

    public function getResult($where = '') {

       $select = "".$this->_table.".*, daheader.da_no, daheader.da_date, datype.datype, party.party as buyer, country.country, product.product as product_name, daitems.quantity"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('daheader', $this->_table.'.id = daheader.advance_lic_no', 'left');
        $this->db->join('daitems', 'daheader.id = daitems.da_no', 'left');
        $this->db->join('datype', 'daheader.da_type = datype.id', 'left');
        $this->db->join('party', 'daheader.buyer = party.id', 'left');
        $this->db->join('country', 'daheader.country = country.id', 'left');
        $this->db->join('product', 'daitems.product = product.id', 'left');
        
        if(!empty($where)) {
             $this->db->where('daheader.advance_lic_no', $where);
        }
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }


    public function getLicnese($product) {
        
        $select = "".$this->_table.".*, product.product as product_name";
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('product', $this->_table.'.product = product.id', 'left');
        $this->db->where_in($this->_table.'.product', $product);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    } 

    public function getLicneseOne($product) {
        
        $select = "".$this->_table.".*, product.product as product_name";
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('product', $this->_table.'.product = product.id', 'left');
        $this->db->where_in($this->_table.'.id', $product);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    } 


}
