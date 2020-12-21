<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Productgrade_model extends MY_Model {

    function __construct() {
        $this->_table = 'productgrade';
        $this->_primaryKey = 'id';
    }   
}
