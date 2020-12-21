<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shipmentmode_model extends MY_Model {

    function __construct() {
        $this->_table = 'shippingmode';
        $this->_primaryKey = 'id';
    }   
}
