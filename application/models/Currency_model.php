<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Currency_model extends MY_Model {

    function __construct() {
        $this->_table = 'currency';
        $this->_primaryKey = 'id';
    }   
}
