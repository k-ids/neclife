<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dadocuments_model extends MY_Model {

    function __construct() {
        $this->_table = 'dadocumentsrequired';
        $this->_primaryKey = 'id';
    }   
}
