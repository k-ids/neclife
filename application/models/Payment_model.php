<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_model extends MY_Model {

    function __construct() {
        $this->_table = 'invoice_payment';
        $this->_primaryKey = 'id';
    }   

     public function daHavingInvoiceGenerated($where = false) {

        $select = "".$this->_table.".*, party.party, SUM(invoice_payment_map.amount_pay) as total_paid_amount"; 
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('daheader', $this->_table.'.da_no =  daheader.id', 'left');
        $this->db->join('party', 'daheader.buyer =  party.id', 'left');
        $this->db->join('invoice_payment_map', $this->_table.'.id =  invoice_payment_map.invoice_pay_id', 'left');
      
        if(!empty($where)) {
        	$this->db->where('daheader.party', $where);
        }

        $this->db->where($this->_table.'.financial_year', $this->session->userdata('financial_year'));
        
        $this->_userDaDepartments(); // get data on da type and department basis conditonal global function : location: Core -> My_Model.php
        $this->_userRoles();  // get data when user role is PPIC: location: Core -> My_Model.php

        $this->db->group_by($this->_table.'.id'); 
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
}
