<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transportmode_model extends MY_Model {

    function __construct() {
        $this->_table = 'transportmodetocha';
        $this->_primaryKey = 'id';
    }   
}
