<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoiceheader_model extends MY_Model {

    function __construct() {
        $this->_table = 'exportinvoiceheader';
        $this->_primaryKey = 'id';
        $this->_joinTable = 'exportinvoiceitems';

    }   

    public function getInvoiceData($id) {
         
         $select = "".$this->_table.".*,  exportinvoiceitems.product, exportinvoiceitems.packing_type, exportinvoiceitems.qty, exportinvoiceitems.rate, exportinvoiceitems.amount"; 
         $this->db->select( $select );
         $this->db->from($this->_table);
         $this->db->join('exportinvoiceitems', $this->_table.'.id = exportinvoiceitems.invoice_no', 'left');
         $this->db->where($this->_table.'.invoice_id', $id);
         $query = $this->db->get();
         $result = $query->result_array();
         return $result;

    }

    public function license_usage($id) {

        $sql = "SELECT ".$this->_table.".da_no_name, ".$this->_table.".invoice_no FROM ".$this->_table." WHERE FIND_IN_SET(".$id.", ad_lic_no)";
        $query = $this->db->query($sql);   
        return $query->result_array();

    }
}
