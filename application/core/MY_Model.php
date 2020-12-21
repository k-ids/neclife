<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class MY_Model
 */
class MY_Model extends CI_Model {

    protected $_table = '';
    protected $_primaryKey = '';
    private $_select;
    private $_join;
    private $_where;

    function __call($method, $params = array()) {
        if (method_exists($this->db, $method)) {
            call_user_func_array(array($this->db, $method), $params);
            return $this;
        }
    }

    /*
     * Insert admin user data
     */

    public function insert($data = array()) {
        $insert = $this->db->insert($this->_table, $data);
        if ($insert) {
            $id = $this->db->insert_id();
            return $id;
        } else {
            return false;
        }
    }


    public function insertBatch($data = array()) {
        $insert = $this->db->insert_batch($this->_table, $data);
        if ($insert) {
            $id = $this->db->insert_id();
            return $id;
        } else {
            return false;
        }
    }

    /*
     * Update admin user data
     */

    public function update($data = array(), $conditions = array()) {
        $update = $this->db->update($this->_table, $data, $conditions);
        return $update ? true : false;
    }

    public function delete($id) {

        $this->db->where($this->_primaryKey, $id);

        $this->db->delete($this->_table);
        
        return $this->db->affected_rows();
    }

    public function deleteWhere($data) {
        return $this->db->delete($this->_table, $data);
    }

    /*
     * Seems not to be used (don't why though)
     * To physically delete file from folder we use /application/controllers/backend/Ajax.php -> delete_file
     */

    protected function remove_file($id, $table, $field, $dir) {
        $item = $this->db->where($this->_primaryKey, $id)->get($table)->row_array();
        if (!empty($item[$field])) {
            unlink(FCPATH . UPLOAD_DIR . '/' . $dir . '/' . $item[$field]);
        }
    }

    public function count($params = [], $where_cond = null) {
        $this->db->from($this->_table);
        if (!empty($where_cond))
            $this->db->where($where_cond);
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        return $this->db->count_all_results();
    }

    public function findAll($where_cond = null, $params = [], $type = 'array' , $select='*') {
        if (!empty($where_cond))
            $this->db->where($where_cond);
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        if(array_key_exists("orderby", $params)){
            $this->db->order_by($params['orderby'] , isset($params['order']) ? $params['order'] : 'desc');
        }
        // if(array_key_exists("join", $params)){
        //     $this->db->join($params['table'] , )
        // }
        if(is_array($select)){
            $this->db->select($select);
        }
        $query = $this->db->get($this->_table);
        if ($query->num_rows() >= 1) {
            return $query->result($type);
        } else {
            return FALSE;
        }
    }

    public function select($select = '*') {
        $this->_select = $this->db->select($select);
    }

    public function join($table, $condition, $type = 'left') {
        $this->_join = $this->db->join($table, $condition, $type);
    }

    /**
     * @name get_user_data
     * @desc method for geting info for specifed user
     * @param int $id
     */
    function findOne($id, $type = 'array') {
        if (!is_numeric($id))
            $query = $this->db->where($id)->limit(1)->get($this->_table);
        else
            $query = $this->db->where($this->_table .'.'. $this->_primaryKey, $id)->get($this->_table);

        if ($query->num_rows() == 1) {
            return $query->row(0, $type);
        } else {
            return FALSE;
        }
    }

    public function findList($keyField, $valueField, $where_cond = null) {
        if (!empty($where_cond))
            $this->db->where($where_cond);
        $query = $this->db->get($this->_table);
        if ($query->num_rows() >= 1) {
            $list = [];
            foreach ($query->result() as $row) {
                $list[$row->$keyField] = $row->$valueField;
            }
            return $list;
        } else {
            return NULL;
        }
    }

    /* Copy file from URL $url to Directory $dirname. Name of new file -- $name */

    public function copyFile($url, $dirname, $name) {
        if (!empty($name)) {
            $path = $dirname . $name;

            if (file_exists($path)) {/*             * Do something if file exist */
            }

            $file_headers = @get_headers($url);

            if ($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.1 403 Forbidden') {
                return false;
            } else {
                @$file = fopen($url, "rb");
                if (!$file)
                    return false;
                else {
                    $fc = fopen($path, "wb");
                    while (!feof($file)) {
                        $line = fread($file, 1028);
                        @fwrite($fc, $line);
                    }
                    fclose($fc);
                }
                return true;
            }
        }
    }

    /*
     * Get rows from the admin users table
     */

    public function getRows($params = array()) {
        $this->db->from($this->_table);
        //fetch data by conditions
        if (array_key_exists("conditions", $params)) {
            if(is_array($params['conditions'])) {
                foreach ($params['conditions'] as $key => $value) {
                    $this->db->where($key, $value);
                }
            } else
            $this->db->where($params['conditions']);
        }

        if (array_key_exists($this->_primaryKey, $params)) {
            $this->db->where($this->_primaryKey, $params["$this->_primaryKey"]);
            $query = $this->db->get();
            $result = $query->row_array();
        } else {
            //set start and limit
            if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit'], $params['start']);
            } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit']);
            }

            if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
                $result = $this->db->count_all_results();
            } elseif (array_key_exists("returnType", $params) && $params['returnType'] == 'single') {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->row_array() : FALSE;
            } else {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
            }
        }
        //return fetched data
        return $result;
    }

    /**
     *
     * Function to remove reference in table from a deleted file (pdf or image)
     * Used in Controllers backend Ajax
     * @table table to udpate
     * @field_to_udpate name of field to update in table
     * @id id to update
     * @return boolean
     */
    public function udpate_table_deleted_file($table, $field_to_update, $id) {
        $data = array(
            $field_to_update => ''  // reset to null
            );

        $this->db->where($this->_primaryKey, $id);
        $this->db->update($table, $data);

        return true;
    }
    public function get_by_name($where_cond){
        $this->db->where($where_cond);
        $query = $this->db->get($this->_table);
        return $query->row();
    }

    public function _userRoles() {
           
        if($this->session->userdata('role') == '13') {
              $this->db->where($this->_table.'.da_type', $this->session->userdata('da_type'));
        }
    }

    public function _userDaDepartments() {

        if($this->session->userdata('admin_id') != ADMIN ) {

              $datypeSwitch = $this->session->userdata('da_type');

              switch ($datypeSwitch) {

                  case DA_API:
                    $this->db->where($this->_table.'.da_type', $datypeSwitch); 
                    if( $this->session->userdata('department') != API )   {
                        $this->db->where($this->_table.'.department', $this->session->userdata('department'));
                    }
                    break;

                case DA_FORMULATION:
                    $this->db->where($this->_table.'.da_type', $datypeSwitch); 
                    if( $this->session->userdata('department') != FORMULATION )   {
                        $this->db->where($this->_table.'.department', $this->session->userdata('department'));
                    }
                    break;

                case DA_MENTHOL:
                    $this->db->where($this->_table.'.da_type', $datypeSwitch); 
                    if( $this->session->userdata('department') != MENTHOL )   {
                        $this->db->where($this->_table.'.department', $this->session->userdata('department'));
                    }
                break;

                case DA_DIAGNOSTIC:
                    $this->db->where($this->_table.'.da_type', $datypeSwitch); 
                    if( $this->session->userdata('department') != DIAGNOSTIC )   {
                        $this->db->where($this->_table.'.department', $this->session->userdata('department'));
                    }
                break;

                case DA_CAPSULE:
                    $this->db->where($this->_table.'.da_type', $datypeSwitch); 
                    if( $this->session->userdata('department') != CAPSULE )   {
                        $this->db->where($this->_table.'.department', $this->session->userdata('department'));
                    }
                break;

                case DA_ALL:
                      break;
                  
                  default:
                       echo "Go back simon";die;
                      break;
            }
           
        } 
        return true;
    }

 

}
