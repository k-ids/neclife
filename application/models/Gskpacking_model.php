<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gskpacking_model extends MY_Model {

    function __construct() {
        $this->_table = 'gsk_packing';
        $this->_primaryKey = 'id';
    }  


    public function getAll($where = null) {

    	$select = "".$this->_table.".*, daheader.da_no as da_name, daheader.financial_year";
    	$this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('daheader', $this->_table.'.da_no = daheader.id', 'left');
        
        if($this->session->userdata('admin_id') == ADMIN) {
               $this->db->where('daheader.da_type', DA_API);
        } else {
              $this->db->where('daheader.da_type', $this->session->userdata('da_type'));
        }
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getAllMangerQA($where = null) {

        $select = "".$this->_table.".*, daheader.da_no as da_name, daheader.financial_year";
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('daheader', $this->_table.'.da_no = daheader.id', 'left');
        
        if($this->session->userdata('admin_id') == ADMIN) {
               $this->db->where('daheader.da_type', DA_API);
        } else {
              $this->db->where('daheader.da_type', $this->session->userdata('da_type'));
        }
        if(!empty($where)) {
            $this->db->where($where);
        }
        $condition = array($this->_table.'.approved_by!=' => NULL);
        $this->db->where( $condition );
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getAllForLogistics() {

        $select = "".$this->_table.".*, daheader.da_no as da_name, daheader.financial_year";
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('daheader', $this->_table.'.da_no = daheader.id', 'left'); 

        /*if($this->session->userdata('admin_id') != '1' ) {
            $this->db->where('daheader.da_type', $this->session->userdata('da_type'));
            $this->db->where('daheader.department', $this->session->userdata('department'));
        }*/

        //$this->_userDaDepartments();
        //$this->_userRoles();

        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getAllForLogisticsById($id) {

        $select = "".$this->_table.".*, daheader.da_no as da_name, daheader.financial_year, department.department as dept_name";
        $this->db->select( $select );
        $this->db->from($this->_table);
        $this->db->join('daheader', $this->_table.'.da_no = daheader.id', 'left');
        $this->db->join('department', 'daheader.department = department.id', 'left'); 

        

       /* if($this->session->userdata('admin_id') != '1') {
            $this->db->where('daheader.da_type', $this->session->userdata('da_type'));
            if($this->session->userdata('department') != '10'){
                $this->db->where('daheader.department', $this->session->userdata('department'));
            }
        }*/

        if(!empty($where)) {
            $this->db->where($this->_table.'.id', $id);
        }

        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

}
