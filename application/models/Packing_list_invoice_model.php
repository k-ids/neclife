<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Packing_list_invoice_model extends MY_Model {

    function __construct() {
        $this->_table = ' packing_list_invoice';
        $this->_primaryKey = 'id';
    }   
}
