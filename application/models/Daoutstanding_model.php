<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Daoutstanding_model extends MY_Model {

    function __construct() {
        $this->_table = 'daoutstanding';
        $this->_primaryKey = 'id';
    }   
}
