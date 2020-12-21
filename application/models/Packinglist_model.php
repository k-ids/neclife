<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Packinglist_model extends MY_Model {

    function __construct() {
        $this->_table = 'plantpackinglist';
        $this->_primaryKey = 'id';
    }


    public function findAllPackingList($where = null) {

        $select = "".$this->_table.".*, daheader.da_no as daname,party.party, product.product as product_name, datype.datype as datype_name, department.department as department_name, productform.productform, productgrade.productgrade,daitems.qauntity_dispatched,kindofpackages.kindofpackages"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('daheader', $this->_table.'.da_no = daheader.id', 'left');
        $this->db->join('daitems', $this->_table.'.product = daitems.product', 'left');
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('department', $this->_table.'.department = department.id', 'left');
        $this->db->join('product', $this->_table.'.product = product.id', 'left');
        $this->db->join('productform', $this->_table.'.product_form = productform.id', 'left');
        $this->db->join('productgrade', $this->_table.'.grade = productgrade.id', 'left');
        $this->db->join('kindofpackages', $this->_table.'.packing_type = kindofpackages.id', 'left');

        if(!empty($where)) {
            $this->db->where($this->_table.'.buyer', $where);
        }
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
        
        $this->_userDaDepartments();
        $this->_userRoles();

        $this->db->group_by($this->_table.'.product_form'); 
        $this->db->order_by($this->_table.'.id', 'DESC');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }  

      public function findAllPacking($where = null) {
        
        $select = "".$this->_table.".*, daheader.da_no as daname,party.party, product.product as product_name, datype.datype as datype_name, department.department as department_name, productform.productform, productgrade.productgrade,daitems.qauntity_dispatched,kindofpackages.kindofpackages"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('daheader', $this->_table.'.da_no = daheader.id', 'left');
        $this->db->join('daitems', $this->_table.'.product = daitems.product', 'left');
        $this->db->join('datype', $this->_table.'.da_type = datype.id', 'left');
        $this->db->join('department', $this->_table.'.department = department.id', 'left');
        $this->db->join('product', $this->_table.'.product = product.id', 'left');
        $this->db->join('productform', $this->_table.'.product_form = productform.id', 'left');
        $this->db->join('productgrade', $this->_table.'.grade = productgrade.id', 'left');
        $this->db->join('kindofpackages', $this->_table.'.packing_type = kindofpackages.id', 'left');

        if(!empty($where)) {
            $this->db->where($this->_table.'.da_no', $where['da_no']);
            $this->db->where($this->_table.'.product_form', $where['product_form']);
        }
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
        
        $this->_userDaDepartments();
        $this->_userRoles();

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }  
}
