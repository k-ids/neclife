<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userrole_model extends MY_Model {

    function __construct() {
        $this->_table = 'user_roles';
        $this->_primaryKey = 'id';
    }

}
