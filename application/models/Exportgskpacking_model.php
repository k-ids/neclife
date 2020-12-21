<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exportgskpacking_model extends MY_Model {

    function __construct() {
        $this->_table = 'export_gsk_packing';
        $this->_primaryKey = 'id';
    }   
}
