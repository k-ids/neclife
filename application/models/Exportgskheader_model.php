<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exportgskheader_model extends MY_Model {

    function __construct() {
        $this->_table = 'export_gsk_invoice_header';
        $this->_primaryKey = 'id';
    }   
}
