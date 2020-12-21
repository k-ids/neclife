<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends MY_Model {

    function __construct() {
        $this->_table = 'product';
        $this->_primaryKey = 'id';
    }   
}
