<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exportgskdaitems_model extends MY_Model {

    function __construct() {
        $this->_table = 'gsk_export_da_items';
        $this->_primaryKey = 'id';
    }   
}
