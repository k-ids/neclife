<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Label_model extends MY_Model {

    function __construct() {
        $this->_table = 'label';
        $this->_primaryKey = 'id';
    }   
}
