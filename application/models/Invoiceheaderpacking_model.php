<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoiceheaderpacking_model extends MY_Model {

    function __construct() {
        $this->_table = 'exportinvoiceheaderpacking';
        $this->_primaryKey = 'id';
        //$this->_joinTable = 'exportinvoiceitems';

    }   

}
