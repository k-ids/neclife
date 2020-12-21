<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoicepackinglist_model extends MY_Model {

    function __construct() {
        $this->_table = 'exportinvoicepackinglist';
        $this->_primaryKey = 'id';
    }   
}
