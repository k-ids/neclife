<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Utilities extends MY_Controller {

        public function __construct() {

            parent::__construct();

            $this->load->library('form_validation');
            $this->load->model('admin_model');
            $this->load->model('Audittrail_model', 'audit');
            $this->load->model('emailsender_model');

            
        }

        protected function generateSalt() {
            $salt = "xiORG17N6ayoEn6X3";
            return $salt;
        }


        /**
        * Function change password.
        * @param id
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function change_password() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();
            if(!empty($post)) {

               $this->form_validation->set_rules('currentpassword','current password','required|min_length[5]');    
               $this->form_validation->set_rules('password','password','required|min_length[5]');
               $this->form_validation->set_rules('confirmpassword','confirm password','required|min_length[5]|matches[password]');
               $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

              if($this->form_validation->run() == TRUE) {

                  $salt = $this->generateSalt();
                  $current_pas = md5($salt.$this->input->post('currentpassword'));
                  $newpassword = md5($salt.$this->input->post('password'));

                  $id = $this->session->userdata()['admin_id'];
                  $getCurrentPasswordFromDb = $this->admin_model->findOne($id);

                  if($getCurrentPasswordFromDb['password'] != $current_pas) {

                      $this->session->set_flashdata('error','Your current password is incorrect.');
                    
                  } else if($current_pas == $newpassword) {
                       
                       $this->session->set_flashdata('error','A new password should not be same to current password.Please choose another password.');

                  } else {
                      
                        $password_array = array('password' => md5($salt.$post['password']));
                        $update = $this->admin_model->update($password_array, array('id' => $id)); 
                        if(!empty($update)) {

                            $audit_trial = array(
                                     'transaction_date' => date('Y-m-d'),
                                     'transaction_time' => date("H:i:s"),
                                     'username' => $this->session->userdata()['username'],
                                     'action' => 'Password changed',
                             );
                            $this->audit->insert($audit_trial);

                            $this->session->set_flashdata('success', 'Password changed successfully');
                            return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method());
                        } else {
                            $this->session->set_flashdata('error', 'Unable to process your request. Please try again later.');
                            return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method());
                        }
                  }

              } else {
                    
                    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
              }

            }
            
            $data['pageTitle'] = 'Neclife- Utilities | Change Password';
            $data['template'] = 'utilities/change-password';
            $this->load->view('template_admin',$data);

        }

        /**
        * Function change password.
        * @param id
        * Created On:  13-May-2020
        * Created By:  karan.parihar@ids
        */

        public function contact_admin() {

          $data = array();
          $post = $this->input->post();
          if(!empty($post)) {
              
              $admin = $this->admin_model->findOne(array('id' => '1'));

              $admin_email = $admin['email'];
              $data['username'] = $admin['first_name'].' '.$admin['last_name'];
              $data['message'] = strip_tags($post['message']);
              $message = $this->load->view('email-templates/da-mail', $data, true);
              $sent = $this->emailsender_model->sendMail($admin_email, 'Neclife user query', $message);

              if(!empty($sent)) {
                  $this->session->set_flashdata('success','Message sent successfully.');
                  return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method());
              } else {
                  $this->session->set_flashdata('error','Unable to send the message. Please try again later.');
                  return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method());
              }
           
          }

          $data['pageTitle'] = 'Neclife- Utilities | Contact Admin';
          $data['template'] = 'utilities/contact-admin';
          $this->load->view('template_admin',$data);

        }
    }