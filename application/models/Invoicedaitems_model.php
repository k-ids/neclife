<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoicedaitems_model extends MY_Model {

    function __construct() {
        $this->_table = 'exportinvoiceitems';
        $this->_primaryKey = 'id';
    }   
}
