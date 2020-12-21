<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Documentsrequired_model extends MY_Model {

    function __construct() {
        $this->_table = 'documentsrequired';
        $this->_primaryKey = 'id';
    }   
}
