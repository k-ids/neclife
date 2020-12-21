<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Administrator extends MY_Controller {

        public function __construct() {

            parent::__construct();

            $this->load->library('form_validation');
            $this->load->model(array('admin_model', 'datype_model','department_model'));
            $this->load->model('Userrole_model', 'role');
            $this->load->model('Audittrail_model', 'audit');
            $this->load->model('financialyear_model','financial_year');
            $this->load->model('admin_model');
            $this->load->model('emailsender_model');
            
            if($this->session->userdata('role') != 1 && $this->session->userdata('role') != 13 ) {
                return redirect(base_url());
            }
            
        }

        protected function generateSalt() {
                $salt = "xiORG17N6ayoEn6X3";
                return $salt;
        }

        protected function generateVerificationKey() {
            $length = 10;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        /**
        * Function index to show users listing.
        * @param 
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function index() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
            $users = $this->admin_model->findAllUser();
            $data['users'] = $users;
            $data['template'] = 'administartor/users/index';
            $this->load->view('template_admin',$data);
            
        }
        
        /**
        * Function index to show create user and create_user view.
        * @param GET, POST
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function create_user() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            
            $post = $this->input->post();
            
            if(!empty($post) && isset($post)) {
               
               $this->form_validation->set_rules('emp_code' , 'Employee code' , 'required|is_unique[admin.emp_code]');
               $this->form_validation->set_rules('email' , 'Email' , 'required');
               $this->form_validation->set_rules('first_name' , 'First name' , 'required');
               $this->form_validation->set_rules('last_name' , 'Last name' , 'required');
               $this->form_validation->set_rules('name' , 'Username' , 'required|is_unique[admin.username]');
               $this->form_validation->set_rules('da_type' , 'Da type' , 'required');
               $this->form_validation->set_rules('department' , 'department' , 'required');
               $this->form_validation->set_rules('password' , 'password' , 'required');
               $this->form_validation->set_rules('role' , 'role' , 'required');
               $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

                if($this->form_validation->run() == TRUE) {

                    if(!empty($_FILES['signature']['name'])){
                        $config['upload_path'] = 'resources/employee-signature/';
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['max_size']    = '3000';
                        $config['max_width']  = '200';
                        $config['max_height']  = '100';
                        $config['file_name'] = $_FILES['signature']['name'];
                        
                        //Load upload library and initialize configuration
                        $this->load->library('upload',$config);
                        $this->upload->initialize($config);
                        
                        if($this->upload->do_upload('signature')){
                            $uploadData = $this->upload->data();
                            $picture = $uploadData['file_name'];
                        }else{
                            
                            $this->session->set_flashdata('validation-error', $this->upload->display_errors());
                             return redirect(base_url().$this->router->fetch_class().'/create_user');
                            $picture = '';
                        }
                    }else{
                        $picture = '';
                    }

                    $da_type = explode('-', $post['da_type']);
                    $salt = $this->generateSalt();
                    $table_array  = array (
                            'emp_code' => strip_tags($post['emp_code']),
                            'email' => strip_tags($post['email']),
                            'username' => strip_tags($post['name']),
                            'first_name' => strip_tags($post['first_name']),
                            'last_name' => strip_tags($post['last_name']),
                            'da_type' => strip_tags($da_type[0]),
                            'department' => strip_tags($post['department']),
                            'password' => strip_tags(md5($salt.$post['password'])),
                            'admin_group' => strip_tags($post['role']),
                            'verification_key' => $this->generateVerificationKey(),
                            'signature' => $picture

                        );
                    //echo "<pre>"; print_r($table_array);die;
                    $insert = $this->admin_model->insert($table_array);
                    if(!empty($insert)) {
                         
                        $last_inserted_user = $this->admin_model->findOne($insert);
                        $data['user'] = $last_inserted_user;
                        $data['user_password'] = strip_tags($post['password']);
                        $message = $this->load->view('email-templates/create-user', $data, true);
                        $this->emailsender_model->sendMail(strip_tags($post['email']), 'Neclife registration', $message);
                        
                         $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Add User-'.$post['name'],
                         );
                        $this->audit->insert($audit_trial);

                        $this->session->set_flashdata('success', 'User added successfully!.A guideline email has been sent to added user.');
                        return redirect(base_url().'administrator');

                    } else {
                        $this->session->set_flashdata('error', 'Unable to process your request, please try again later.');
                        return redirect(base_url().'administrator');
                    }
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }
            } 
            
            $data['da_types'] = $this->datype_model->findAll(null, array('orderby' => 'datype' ,'order' => 'ASC'));
            $data['roles'] = $this->role->findAll(null, array('orderby' => 'role' ,'order' => 'ASC'));
            
            $data['pageTitle'] = 'Neclife- Administrator | Create User';
            $data['template'] = 'administartor/users/add';
            $this->load->view('template_admin',$data);
        }

        /**
        * Function index to show edit user and edit_user view.
        * @param GET, POST, id
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function edit_user($id = '') {
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $post = $this->input->post();

            if(!empty($post) && isset($post)) {

               $this->form_validation->set_rules('emp_code' , 'Employee code' , 'required|callback_check_unique_emp_code_field');
               $this->form_validation->set_rules('email' , 'Email' , 'required');  
               $this->form_validation->set_rules('first_name' , 'First name' , 'required');
               $this->form_validation->set_rules('last_name' , 'Last name' , 'required');
               
               $this->form_validation->set_rules('name' , 'Username' , 'required|callback_check_unique_username_field');
               $this->form_validation->set_rules('da_type' , 'Da type' , 'required');
               $this->form_validation->set_rules('department' , 'department' , 'required');
               $this->form_validation->set_rules('role' , 'role' , 'required');
               $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

                if($this->form_validation->run() == TRUE) {

                    if(!empty($_FILES['signature']['name'])){
                        $config['upload_path'] = 'resources/employee-signature/';
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['max_size']    = '3000';
                        $config['max_width']  = '200';
                        $config['max_height']  = '100';
                        $config['file_name'] = $_FILES['signature']['name'];
                        
                        //Load upload library and initialize configuration
                        $this->load->library('upload',$config);
                        $this->upload->initialize($config);
                        
                        if($this->upload->do_upload('signature')){
                            $uploadData = $this->upload->data();
                            $picture = $uploadData['file_name'];
                        }else{
                            
                            $this->session->set_flashdata('validation-error', $this->upload->display_errors());
                             return redirect(base_url().$this->router->fetch_class().'/edit_user/'.$id);
                            $picture = '';
                        }
                    }else{
                        $picture = $post['db-image-name'];
                    }

                    $da_type = explode('-', $post['da_type']) ;
                    $salt = $this->generateSalt();
                    $table_array  = array (
                            'emp_code' => strip_tags($post['emp_code']),
                            'email' => strip_tags($post['email']),
                            'username' => strip_tags($post['name']),
                            'first_name' => strip_tags($post['first_name']),
                            'last_name' => strip_tags($post['last_name']),
                            'da_type' => strip_tags($da_type[0]),
                            'department' => strip_tags($post['department']),
                            'admin_group' => strip_tags($post['role']),
                            'signature' => $picture,
                        );
                   
                    $update = $this->admin_model->update($table_array , array('id' => $id));

                    if(!empty($update)) {

                        $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Edit User-'.$post['name'],
                         );
                        $this->audit->insert($audit_trial);

                        $this->session->set_flashdata('success', 'User updated successfully!');
                        return redirect(base_url().'administrator');

                    } else {
                        $this->session->set_flashdata('error', 'Unable to process your request, please try again later.');
                        return redirect(base_url().'administrator');
                    }
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }
            }

            $user = $this->admin_model->findOne($id);
            if(empty($user)) {
                return redirect(base_url().'administrator');
            }

            $data['user'] = $user;
            $data['da_types'] = $this->datype_model->findAll(null, array('orderby' => 'datype' ,'order' => 'ASC'));
            $data['roles'] = $this->role->findAll(null, array('orderby' => 'role' ,'order' => 'ASC'));

            $data['pageTitle'] = 'Neclife- Administrator | Edit User';
            $data['template'] = 'administartor/users/edit';
            $this->load->view('template_admin',$data);
        }
        
        /**
        * Function index to  delete user.
        * @param id
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function delete_user($id = '') {
           
            if(!empty($id)) {
                
                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {
                     $user = $this->admin_model->findOne($id);
                     $result = $this->admin_model->delete($id);
                    
                     if(!empty($result)) {
                         $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Delete User-'.$user['username'],
                         );
                        $this->audit->insert($audit_trial);

                        $response = array ('success' => 'Record deleted successfully!');
                    }  else {
                         $response = array ('error' => 'Unable to process your request, please try again later.');
                    }
                    echo json_encode($response);die;
                } 
            }  

        }


        /**
        * Manage department ajax request.
        *
        * @return Response
        */
        public function get_department($id) { 

            if(!empty($id)) {

                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {

                     $result = $this->department_model->findAll('da_type ='.$id);
                     if(!empty($result)) {
                        $response = array ('success' => $result);
                    }  else {
                        
                         $response = array ('error' => 'true');
                    }
                     echo json_encode($response);die;
                } 
            }  
        }


        /**
        * Function department to  show deoartment listing.
        * @param id
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function department() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data  = array();
            $departments = $this->department_model->getJoinData();
            $data['departments'] = $departments;

            $data['pageTitle'] = 'Neclife- Administrator | Department';
            $data['template'] = 'administartor/department/index';
            $this->load->view('template_admin',$data);

        }


        /**
        * Function add_department to  add departments.
        * @param id
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function create_department() {
         
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            
            $post = $this->input->post();
            
            if(!empty($post) && isset($post)) {

                $this->form_validation->set_rules('department', 'department', 'required');
                $this->form_validation->set_rules('da_type','Da type', 'required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','</span');

                if($this->form_validation->run() == TRUE) {

                    $table_array  = array (

                            'da_type' => strip_tags($post['da_type']),
                            'department' => strip_tags($post['department']),
                        );

                    $insert = $this->department_model->insert( $table_array);
                    if(!empty($insert)) {

                         $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Add Department-'.$post['department'],
                         );
                        $this->audit->insert($audit_trial);

                        $this->session->set_flashdata('success', 'Department added successfully!');
                        return redirect(base_url().'administrator/department');

                    } else {
                        $this->session->set_flashdata('error', 'Unable to process your request, please try again later.');
                        return redirect(base_url().'administrator/department');
                    }
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }
            }

            $data['da_types'] = $this->datype_model->findAll(null, array('orderby' => 'datype' ,'order' => 'ASC'));

            $data['pageTitle'] = 'Neclife- Administrator | Create Department';
            $data['template'] = 'administartor/department/add';
            $this->load->view('template_admin',$data);

        } 

        /**
        * Function edit_department to  edit departments
        * @param GET, POST, id
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function edit_department($id = '') {
         
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            
            $post = $this->input->post();
            
            if(!empty($post) && isset($post)) {

                $this->form_validation->set_rules('department', 'department', 'required');
                $this->form_validation->set_rules('da_type','Da type', 'required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','</span');

                if($this->form_validation->run() == TRUE) {

                    $table_array  = array (

                            'da_type' => strip_tags($post['da_type']),
                            'department' => strip_tags($post['department']),
                        );

                    $update = $this->department_model->update($table_array , array('id' => $id));
                    if(!empty($update)) {

                        $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'EDit Department-'.$post['department'],
                         );
                        $this->audit->insert($audit_trial);

                        $this->session->set_flashdata('success', 'Department updated successfully!');
                        return redirect(base_url().'administrator/department');

                    } else {
                        $this->session->set_flashdata('error', 'Unable to process your request, please try again later.');
                        return redirect(base_url().'administrator/department');
                    }
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }
            }
            
            $data['department'] = $this->department_model->findOne($id);
            if(empty($data['department'])){
                return redirect(base_url().'administrator/department');
            }
            $data['da_types'] = $this->datype_model->findAll(null, array('orderby' => 'datype' ,'order' => 'ASC'));

            $data['pageTitle'] = 'Neclife- Administrator | Edit Department';
            $data['template'] = 'administartor/department/edit';
            $this->load->view('template_admin',$data);

        } 

        /**
        * Function index to  delete user.
        * @param id
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function delete_department($id = '') {
           
            if(!empty($id)) {
                
                if (!$this->input->is_ajax_request()) {
                       exit('No direct script access allowed');
                } else {
                     $findOne = $this->department_model->findOne($id);
                     $result = $this->department_model->delete($id);
                     if(!empty($result)) {

                        $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Delete Department-'.$findOne['department'],
                         );

                        $this->audit->insert($audit_trial);
                        $response = array ('success' => 'Record deleted successfully!');
                    }  else {
                         $response = array ('error' => 'Unable to process your request, please try again later.');
                    }
                    echo json_encode($response);die;
                } 
            }  

        }


        /**
        * Function Audit trail 
        * @param GET, POST
        * created on : 18-May-2020
        * created by : karan.parihar@ids
        */

        public function audit_trial() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            if($this->session->userdata('info')) {
                $this->session->unset_userdata('info');
            }

            $data = array();
            
            $post = $this->input->post();

            if (!empty($post)  && isset($post)) {
                
                $this->form_validation->set_rules('from_date', '' ,'required|callback_compareDate');
                $this->form_validation->set_rules('upto_date', '' ,'required|callback_compareDate');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

                if($this->form_validation->run() == TRUE) {
                  
                    $from_date = nice_date($post['from_date'],'Y-m-d');
                    $upto_date = nice_date($post['upto_date'] , 'Y-m-d');
                    
                    $result = $this->audit->get_result($from_date,$upto_date);
                    if(!empty($result)) {
                        $data['result'] = $result;
                        $data['search'] = array ('from' => $post['from_date'] , 'upto' => $post['upto_date']);
                    } else {
                       $this->session->set_flashdata('info','No result found between '.$post['from_date'].' To '. $post['upto_date']);
                    }
                
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }

            }
            
            $data['pageTitle'] = 'Neclife- Administrator | Audit Trail';
            $data['template'] = 'administartor/audit-trial/index';
            $this->load->view('template_admin',$data);
        }


        /**
        * Call back function to compare the date
        *
        * @return validation response 
        */

         function compareDate() {
          
              $startDate = strtotime($_POST['from_date']);
              $endDate = strtotime($_POST['upto_date']);

              if ($endDate >= $startDate) {
                return true;
              } else {
                $this->form_validation->set_message('compareDate', 'Start date should be less than end date.');
                return false;
              }
        }

        /**
        * Function Finacila year
        * @param 
        * created on : 18-May-2020
        * created by : karan.parihar@ids
        */

        public function financial_year() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            
            $post = $this->input->post();

            if (!empty($post)  && isset($post)) {
                
                $this->form_validation->set_rules('financial_year', 'Financial year' ,'required|is_unique[financial_year.financial_year]');
                $this->form_validation->set_rules('from_date', 'Start date' ,'required|callback_compareDate');
                $this->form_validation->set_rules('upto_date', 'End date' ,'required|callback_compareDate');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

                if($this->form_validation->run() == TRUE) {
                  
                    $from_date = nice_date($post['from_date'],'Y-m-d');
                    $upto_date = nice_date($post['upto_date'] , 'Y-m-d');

                    $table_array = array (
                          'financial_year' => strip_tags($post['financial_year']),
                          'financial_year_start' => strip_tags($from_date),
                          'financial_year_end' => strip_tags( $upto_date)

                     );
                    
                    $result = $this->financial_year->insert($table_array);
                    if(!empty($result)) {
                        $this->session->set_flashdata('success', 'Financial year added successfully!');
                        return redirect(base_url().'administrator/financial_year');

                    } else {
                        $this->session->set_flashdata('error', 'Unable to process your request, please try again later.');
                        return redirect(base_url().'administrator/financial_year');
                    }
                
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }

            }
            
            $data['result'] = $this->financial_year->findAll(null, array('orderby' => 'id'));
            $data['pageTitle'] = 'Neclife- Administrator | Financial Year';
            $data['template'] = 'administartor/financial-year/index';
            $this->load->view('template_admin',$data);

        }

        /**
        * Function Financial year edit
        * @param 
        * created on : 18-May-2020
        * created by : karan.parihar@ids
        */

        public function edit_financial_year($id = '') {
            

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
             
            $data = array();
            
            $post = $this->input->post();

            if (!empty($post)  && isset($post)) {
                
                $this->form_validation->set_rules('financial_year', 'Financial year' ,'required|callback_check_unique_financial_year');
                $this->form_validation->set_rules('from_date', 'Start date' ,'required|callback_compareDate');
                $this->form_validation->set_rules('upto_date', 'End date' ,'required|callback_compareDate');
                $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
                 
                if($this->form_validation->run() == TRUE) {
                  
                    $from_date = nice_date($post['from_date'],'Y-m-d');
                    $upto_date = nice_date($post['upto_date'] , 'Y-m-d');

                    $table_array = array (
                          'financial_year' => strip_tags($post['financial_year']),
                          'financial_year_start' => strip_tags($from_date),
                          'financial_year_end' => strip_tags( $upto_date)

                     );
                    
                    $result = $this->financial_year->update($table_array, array('id' => $id));
                    if(!empty($result)) {

                        $audit_trial = array(
                                 'transaction_date' => date('Y-m-d'),
                                 'transaction_time' => date("H:i:s"),
                                 'username' => $this->session->userdata()['username'],
                                 'action' => 'Add Financial year',
                         );

                        $this->audit->insert($audit_trial);

                        $this->session->set_flashdata('success', 'Financial year udpated successfully!');
                        return redirect(base_url().'administrator/financial_year');

                    } else {
                        $this->session->set_flashdata('error', 'Unable to process your request, please try again later.');
                        return redirect(base_url().'administrator/financial_year');
                    }
                
                }  else {
                   $this->session->set_flashdata('error', 'Validation error. Please check the form.');
                }

            }
            
            $data['f_year'] = $this->financial_year->findOne($id);
            if(empty($data['f_year'])) {
                return redirect(base_url().'administrator/financial_year');
            }

            $data['pageTitle'] = 'Neclife- Administrator | Edit Financial Year';
            $data['template'] = 'administartor/financial-year/edit';
            $this->load->view('template_admin',$data);

        }
         
        /**
        * Call back function to check unique finacial year field on edit.
        *
        * @return validation response 
        */

        function check_unique_financial_year($field) {
            
            if($this->uri->segment(3))
                $id = $this->uri->segment(3);
            else
                $id = '';
            $result = $this->financial_year->check_unique_field_name($id, $field);
            if($result == 0)
                $response = true;
            else {
                $this->form_validation->set_message('check_unique_financial_year', 'Finacial year must be unique.');
                $response = false;
            }
            return $response;
        }

        /**
        * Call back function to check unique emp code on edit user.
        *
        * @return validation response 
        */

        function check_unique_emp_code_field($field) {
            
            if($this->uri->segment(3))
                $id = $this->uri->segment(3);
            else
                $id = '';
            $result = $this->admin_model->check_unique_field_name($id, $field);
            if($result == 0)
                $response = true;
            else {
                $this->form_validation->set_message('check_unique_emp_code_field', 'Employee code  must be unique.');
                $response = false;
            }
            return $response;
        }

        /**
        * Call back function to check unique email on edit user.
        *
        * @return validation response 
        */

        function check_unique_email_field($field) {
            
            if($this->uri->segment(3))
                $id = $this->uri->segment(3);
            else
                $id = '';
            $result = $this->admin_model->check_unique_email_field_name($id, $field);
            if($result == 0)
                $response = true;
            else {
                $this->form_validation->set_message('check_unique_email_field', 'Email must be unique.');
                $response = false;
            }
            return $response;
        }

        /**
        * Call back function to check unique username on edit user.
        *
        * @return validation response 
        */

        function check_unique_username_field($field) {
            
            if($this->uri->segment(3))
                $id = $this->uri->segment(3);
            else
                $id = '';
            $result = $this->admin_model->check_unique_username_field_name($id, $field);
            if($result == 0)
                $response = true;
            else {
                $this->form_validation->set_message('check_unique_username_field', 'Username must be unique.');
                $response = false;
            }
            return $response;
        }


}


