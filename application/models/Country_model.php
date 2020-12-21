<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Country_model extends MY_Model {

    function __construct() {
        $this->_table = 'country';
        $this->_primaryKey = 'id';
    }   
}
