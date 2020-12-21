<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentterms_model extends MY_Model {

    function __construct() {
        $this->_table = 'paymentterms';
        $this->_primaryKey = 'id';
    }   
}
