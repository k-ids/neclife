<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Productform_model extends MY_Model {

    function __construct() {
        $this->_table = 'productform';
        $this->_primaryKey = 'id';
    }   
}
