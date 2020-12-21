<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoicelicqty_model extends MY_Model {

    function __construct() {
        $this->_table = 'invoice_lic_qty';
        $this->_primaryKey = 'id';
    }   
}
