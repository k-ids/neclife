<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Party_model extends MY_Model {

    function __construct() {
        $this->_table = 'party';
        $this->_primaryKey = 'id';
    }   
}
