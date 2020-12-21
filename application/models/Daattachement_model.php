<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Daattachement_model extends MY_Model {

    function __construct() {
        $this->_table = 'daattachment';
        $this->_primaryKey = 'id';
    }   
}
