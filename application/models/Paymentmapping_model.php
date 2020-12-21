<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentmapping_model extends MY_Model {

    function __construct() {
        $this->_table = ' invoice_payment_map';
        $this->_primaryKey = 'id';
    }   


}
