<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Despatch_model extends MY_Model {

    function __construct() {
        $this->_table = 'despatchto';
        $this->_primaryKey = 'id';
    }   
}
