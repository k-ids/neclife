<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plantpackinglist_model extends MY_Model {

    function __construct() {
        $this->_table = 'plantpackinglist';
        $this->_primaryKey = 'id';
    } 

     public function check_unique_field_name($data = array()) {
            $this->db->where($data['field'], $data['value']);
            if($data['id']) {
                $this->db->where_not_in('id', $data['id']);
            }
            return $this->db->get($this->_table)->num_rows();
    }  

    public function findAllPackingListByDa($where = null) {

        $select = "".$this->_table.".*, daheader.da_no as daname,party.party, product.product as product_name, product.hscode as product_hscode, datype.datype as datype_name, department.department as department_name, productform.productform, productgrade.productgrade,daitems.qauntity_dispatched,kindofpackages.kindofpackages"; 
        
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
        $this->db->join('kindofpackages', $this->_table.'.packing_type = kindofpackages.kindofpackages', 'left');

        if(!empty($where)) {
            $this->db->where($this->_table.'.da_no', $where);
        }
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
         
        $this->_userDaDepartments(); // get data on da type and department basis conditonal global function : location: Core -> My_Model.php
        $this->_userRoles();  // get data when user role is PPIC: location: Core -> My_Model.php
        
         $this->db->group_by($this->_table.'.id'); 
         //$this->db->group_by($this->_table.'.product_form'); 
         //$this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }


    public function findAllPackingList($where = null) {

        $select = "".$this->_table.".*, daheader.da_no as daname,party.party, product.product as product_name, datype.datype as datype_name, department.department as department_name, productform.productform, productgrade.productgrade,daitems.qauntity_dispatched,kindofpackages.kindofpackages"; 
        
        //$this->db->distinct($this->_table.'.da_no');
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('daheader', $this->_table.'.da_no = daheader.id', 'left');
        $this->db->join('daitems', $this->_table.'.product_form = daitems.product_form', 'left');
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
        
        $this->_userDaDepartments(); // get data on da type and department basis conditonal global function : location: Core -> My_Model.php
        $this->_userRoles();  // get data when user role is PPIC: location: Core -> My_Model.php

        $this->db->group_by($this->_table.'.da_no'); 
        $this->db->group_by($this->_table.'.product'); 
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }

    public function findAllPackingListManagerQA($where = null) {

        $select = "".$this->_table.".*, daheader.da_no as daname,party.party, product.product as product_name, datype.datype as datype_name, department.department as department_name, productform.productform, productgrade.productgrade,daitems.qauntity_dispatched,kindofpackages.kindofpackages"; 
        
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('party', $this->_table.'.buyer = party.id', 'left');
        $this->db->join('daheader', $this->_table.'.da_no = daheader.id', 'left');
        $this->db->join('daitems', $this->_table.'.product_form = daitems.product_form', 'left');
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
        
        $this->_userDaDepartments(); // get data on da type and department basis conditonal global function : location: Core -> My_Model.php
        $this->_userRoles();  // get data when user role is PPIC: location: Core -> My_Model.php
        
        $condition = array($this->_table.'.approved_by!=' => NULL);
        $this->db->where( $condition );

        $this->db->group_by($this->_table.'.da_no');
        $this->db->group_by($this->_table.'.product'); 
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }

    public function findAllPackingListByProductForm($dano, $product_form) {

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
        $this->db->where($this->_table.'.da_no', $dano);
        $this->db->where($this->_table.'.product_form', $product_form);
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
       
        $this->db->group_by($this->_table.'.id');
        $this->db->order_by('id', 'ASC');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }



}
