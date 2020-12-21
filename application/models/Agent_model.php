<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agent_model extends MY_Model {

    function __construct() {
        $this->_table = 'agent';
        $this->_primaryKey = 'id';
    }   
}
