<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Packagestype_model extends MY_Model {

    function __construct() {
        $this->_table = 'kindofpackages';
        $this->_primaryKey = 'id';
    }   
}
