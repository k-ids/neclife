<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                
        }

        public function update_table($id = '' , $table_name = '', $table_array ='') {

            $this->db->where('id', $id);
            $this->db->update($table_name, $table_array);
            $afftectedRows = $this->db->affected_rows();
            return $afftectedRows;
             
        }

 }
