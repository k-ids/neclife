<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Daitems_model extends MY_Model {

    function __construct() {
        $this->_table = 'daitems';
        $this->_primaryKey = 'id';
    }   


    public function findDAItems($where = null) {
         
    	$select = "".$this->_table.".*, product.product as product_name, productform.productform, productgrade.productgrade, kindofpackages.kindofpackages";

    	$this->db->select($select);
    	$this->db->from($this->_table);
        $this->db->join('product', $this->_table.'.product = product.id', 'left');
        $this->db->join('productform', $this->_table.'.product_form = productform.id','left');
		$this->db->join('productgrade', $this->_table.'.grade = productgrade.id', 'left');
        $this->db->join('kindofpackages', $this->_table.'.packing_type = kindofpackages.id', 'left');
    	if(!empty($where)) {
    		$this->db->where($where);
    	}
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
        $this->db->order_by('id', 'DESC');
    	$query = $this->db->get();
        $result = $query->result_array();
        return $result;
    	
    }

  

    public function findDAItemsForInvoice($id) {
        
        $select = "".$this->_table.".*, product.product as product_name, productform.productform, productgrade.productgrade, kindofpackages.kindofpackages";
        $this->db->select($select);
        $this->db->from($this->_table);
        $this->db->join('product', $this->_table.'.product = product.id', 'left');
        $this->db->join('productform', $this->_table.'.product_form = productform.id','left');
        $this->db->join('productgrade', $this->_table.'.grade = productgrade.id', 'left');
        $this->db->join('kindofpackages', $this->_table.'.packing_type = kindofpackages.id', 'left');
        $this->db->join('plantpackinglist', $this->_table.'.product_form = plantpackinglist.product_form', 'left');

        if(!empty($id)) {
            $this->db->where($this->_table.'.da_no', $id);
        }
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));

        $this->db->group_by('plantpackinglist.product_form');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;

    }

    public function findDAItemsById($where = null) {
         
        $select = "".$this->_table.".*, product.product as product_name, productform.productform, productgrade.productgrade, kindofpackages.kindofpackages";

        $this->db->select($select);
        $this->db->from($this->_table);
        $this->db->join('product', $this->_table.'.product = product.id', 'left');
        $this->db->join('productform', $this->_table.'.product_form = productform.id','left');
        $this->db->join('productgrade', $this->_table.'.grade = productgrade.id', 'left');
        $this->db->join('kindofpackages', $this->_table.'.packing_type = kindofpackages.id', 'left');

        if(!empty($where)) {
            $this->db->where($this->_table.'.'.$this->_primaryKey, $where);
        }
        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
        
    }

    public function checkUniqueExciseNumber($data = array()) {

        $this->db->where('excise_invoice_no', $data['invoice_number']);
            if($data['id']) {
                $this->db->where_not_in('id', $data['id']);
            }
            return $this->db->get($this->_table)->num_rows();
    }
}
