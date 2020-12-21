<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deliveryterms_model extends MY_Model {

    function __construct() {
        $this->_table = 'deliveryterm';
        $this->_primaryKey = 'id';
    }   
}
