<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gskpackingmap_model extends MY_Model {

    function __construct() {
        $this->_table = 'gsk_packing_map';
        $this->_primaryKey = 'id';
    }   
}
