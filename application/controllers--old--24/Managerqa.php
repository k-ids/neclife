<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Managerqa extends MY_Controller {

        public function __construct() {

            parent::__construct();

            $this->load->library('form_validation');
            $this->load->model(array('admin_model', 'datype_model','department_model'));
            $this->load->model('Userrole_model', 'role');
            $this->load->model('Audittrail_model', 'audit');
            $this->load->model('financialyear_model','financial_year');
            $this->load->model('admin_model');
            $this->load->model('ecgc_model');

            $this->load->model('daheader_model', 'da_header');
            $this->load->model('daitems_model', 'da_items');
            $this->load->model('dadocuments_model', 'da_document');
            $this->load->model('party_model', 'party');
            $this->load->model('department_model', 'department');
            $this->load->model('plantpackinglist_model', 'packing_list');
            $this->load->model('packagestype_model', 'packing_type');
            $this->load->model('emailsender_model');

            $this->load->model('gskpacking_model', 'gsk_packing');
            $this->load->model('gskpackingmap_model', 'gsk_packing_map');

            $this->load->model('exportgskheader_model', 'export_gsk_header');
            
            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();

            $this->role = $this->session->userdata('role');
            if($this->role != 1 && $this->role != 16) {
                 $this->session->set_flashdata('session-mismatch', true);
                return redirect(base_url());
            } 
            
        }
        
        /**
        * Function index.
        * @param 
        * Created On:  09-June-2020
        * Created By:  karan.parihar@ids
        */

        public function index() {

            return redirect(base_url().$this->router->fetch_class().'/packing_list_manager_qa_approve');
        }

        /**
        * Function to add packing_list_plant_check.
        * @param 
        * Created On:  09-June-2020
        * Created By:  karan.parihar@ids
        */

        public function packing_list_manager_qa_approve() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();

            if(!empty($post)) {
                 $where = $post['buyer'];
            }  else {
                 $where = null;
            }
            
            $packing_list = $this->packing_list->findAllPackingList($where);
            if(empty($packing_list)) {
               $this->session->set_flashdata('error','No Record Found.');
            }
            //$da_header = $this->da_header->findHeaderItems($id);
            $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            //$packing_type = $this->packing_type->findAll(array('datype' => $da_header['da_type']));
            
            $data['packing_list'] = $packing_list;
           // $data['packing_type'] = $packing_type;

            $data['pageTitle'] = 'Neclife- Manager QA | Plant Packing Lsit Approve Form';
            $data['template']  = 'qa/manager-qa-approve';
            $this->load->view('template_admin',$data);
        }


        /**
        * Function tare_weight_change_form.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function packing_list_manager_qa_approve_form($dano = '', $product_form = '') {

            if(empty($dano) || empty($product_form)) {
                $this->session->set_flashdata('warning', 'No direct script access allowed.');
                return redirect(base_url().$this->router->fetch_class().'/packing_list_manager_qa_approve');
            }
            
            $data = array();
            
            $post = $this->input->post();
            if(!empty($post)) {
               
               if($this->sessionSelected != $this->currentSession) {
                    $this->session->set_flashdata('session-mismatch','session-mismatch');
                    return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$dano.'/'.$product_form);
               }
               $this->form_validation->set_rules('qa_remarks','QA remarks', 'required');
               $this->form_validation->set_error_delimiters('<span class="text-danger">','<span>');
               if($this->form_validation->run() == TRUE) {

                //echo "<pre>";print_r($post);die;
                if($post['post_da_type'] == '1' || $post['post_da_type'] == '3' || $post['post_da_type'] == '5') {
                    if(!empty($post['packing_type'])) {
                        $count = count($post['packing_type']);
                        $packing_list_table_array = array();
                        for($i = 0; $i <= $count - 1; $i++) {
                            if(!empty($post['packing_type'][$i])) {

                                $packing_list_table_array[] = array (
                                    'financial_year' => $post['financial_year'],
                                    'da_financial_year' => $post['financial_year'],
                                    'da_no' => $post['post_da_no'],
                                    'da_type' => $post['post_da_type'],
                                    'department' => $post['post_dept'],
                                    'buyer' => $post['post_buyer'],
                                    'product' => $post['post_product'],
                                    'product_form' => $post['post_product_form'],
                                    'grade' => $post['post_grade'],
                                    'qty' => $post['quantity'],
                                    'total_qty_in_list' => $post['qty_in_list'],
                                    'total_qty_despatch' => $post['qauntity_dispatched'],
                                    'packing_type' => $post['packing_type'][$i],
                                    'packing_list_date' => date('Y-m-d'),
                                    'packing_list_time' => date('H:i:s'),
                                    'prefix' => $post['perfix'][$i],
                                    'excise_sr_no' => $post['excise_sr_no'][$i],
                                    'batch_no' => $post['batch_no'][$i],
                                    'container_no' => $post['container'][$i],
                                    'seal_no' => $post['seal_no'][$i],
                                    'inner_tare_weight' => $post['inner_tare_weight'][$i],
                                    'outer_tare_weight' => $post['outer_tare_weight'][$i],
                                    'net_weight' => $post['net_weight'][$i],
                                    'inner_gross_weight' => $post['inner_tare_weight'][$i] + $post['net_weight'][$i],
                                    'outer_gross_weight' => $post['outer_tare_weight'][$i] + $post['net_weight'][$i],
                                    'mfg_date' => $post['mgf_date'][$i],
                                    'exp_date' => $post['exp_date'][$i],
                                    'rate_st_date' => $post['retest_date'][$i],
                                    'dimensions' => $post['dimensions'][$i],
                                    'pallet_dimensions' => $post['pallet_dimensions'][$i],
                                    'pallet_gross_weight' => $post['pallet_gross_weight'][$i],
                                    'pallet_no' => $post['pallet_no'][$i],
                                    'box_no' => $post['box_no'][$i],
                                    'total_no_boxes' => $post['total_no_boxes'][$i],
                                    'total_no_packs' => $post['total_no_packs'][$i],
                                    'production_remarks' => $post['post_production_remarks'],
                                    'created_by' => $post['post_created_by'],
                                    'checked_by' => $post['checked_by'],
                                    'approved_by' => $post['approved_by'],
                                    'qa_remarks' => $post['post_qa_remarks'],
                                    'manager_qa' => $this->session->userdata('username'),
                                    'manager_remarks' => $post['qa_remarks']
                                );
                            }
                        }
                        if(!empty($packing_list_table_array)){
                             $this->packing_list->deleteWhere(array('da_no'=>$dano,'product_form' =>$product_form));
                             $insert = $this->packing_list->insertBatch($packing_list_table_array);
                          
                        } else {
                            $this->session->set_flashdata('error','Please add the packing list properly.');
                        }
                    }

                } else {
                    //$this->session->set_flashdata('info','Functionality under construction. we are on discussion with Neclife team upon it. Thank you!');
                    //return redirect(base_url(). $this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$id.'/'.$itemId);
                   if(!empty($_FILES['packing_excel']['name'])){
                        
                        $file_name = $post['da_no'].'-'.$post['financial_year'].'-'.time().'-'.$_FILES['packing_excel']['name'];
                        $config['upload_path'] = 'resources/packing-list-import/';
                        $config['allowed_types'] = '*';
                        $config['file_name'] = $file_name;
                        
                        //Load upload library and initialize configuration
                        $this->load->library('upload',$config);
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('packing_excel')){
                            $uploadData = $this->upload->data();
                            $picture = $uploadData['file_name'];

                        }else {
                            
                            $this->session->set_flashdata('validation-error', $this->upload->display_errors());
                              return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$dano.'/'.$product_form);
                            $picture = '';
                        }
                    } else {

                            $picture = $post['db-file-name'];
                    }
                   
                    $table_array = array(
                            'packinglist_type' => '2',
                            'file_path' => $picture,
                            'financial_year' => $post['financial_year'],
                            'da_financial_year' => $post['financial_year'],
                            'da_no' => $post['post_da_no'],
                            'da_type' => $post['post_da_type'],
                            'department' => $post['post_dept'],
                            'buyer' => $post['post_buyer'],
                            'product' => $post['post_product'],
                            'product_form' => $post['post_product_form'],
                            'grade' => $post['post_grade'],
                            'qty' => $post['post_quantity'],
                            'packing_list_date' => date('Y-m-d'),
                            'packing_list_time' => date('H:i:s'),
                            'production_remarks' => $post['post_production_remarks'],
                            'created_by' => $post['post_created_by'],
                            'checked_by' => $post['post_checked_by'],
                            'qa_remarks' => $post['qa_remarks'],
                            'approved_by' => $post['approved_by'],
                            'manager_qa' => $this->session->userdata('username'),
                            'manager_remarks' => $post['qa_remarks']
                         
                    );

                        if(empty($post['db-file-name'])) {
                             $insert = $this->packing_list->insert($table_array);
                        } else {
                           $insert = $this->packing_list->update($table_array, array('da_no' => $dano , 'product' => $post['post_product'] ));
                        }
                }

                    if(!empty($insert)) {

                                       $audit_trial = array(
                                                'transaction_date' => date('Y-m-d'),
                                                'transaction_time' => date("H:i:s"),
                                                'username' => $this->session->userdata()['username'],
                                                'action' => 'Manager QA remarks added for '.$dano,
                                            );
                                        $this->audit->insert($audit_trial);

                                        $role = $this->admin_model->findAll(array('admin_group' => 1));
                                       
                                        if(!empty($role)) {
                                            $userdata = array();
                                            foreach ($role as $key => $value) {
                                                 $userdata[$key]['name'] = $value['first_name'].' '.$value['last_name'];
                                                 $userdata[$key]['email'] = $value['email'];
                                            }
                                            if(!empty($userdata)) {
                                                foreach($userdata as $key => $value) {
                                                $data['username'] = $value['name'];
                                                $data['message'] = 'Manager QA remaks added for DA Entry "'.$post['post_da_no'].'" ';
                                                $message = $this->load->view('email-templates/da-mail', $data, true);
                                                $this->emailsender_model->sendMail($value['email'], 'Neclife DA Entry', $message);
                                               }
                                            }
                                         }

                                     $this->session->set_flashdata('success','Manager QA approved  successfully');
                                     return redirect(base_url().$this->router->fetch_class().'/packing_list_manager_qa_approve');
                               } else {
                                    $this->session->set_flashdata('success','Unable to process your request. Please try agin later.');
                                    return redirect(base_url().$this->router->fetch_class().'/packing_list_manager_qa_approve');
                            }

               } else {
                    $this->session->set_flashdata('error','Form validation.Please check the form.');
               }
            }
            $da_header = $this->da_header->findHeaderItems($dano);
            $packing_list = $this->packing_list->findAllPackingListByProductForm($dano,$product_form);
            $da_items = $this->da_items->findDAItems(array('da_no' => $dano, 'product_form'=>$product_form));

            if(empty($packing_list) || ( ($this->session->userdata('department') != $da_header['department'])  && ($this->session->userdata('admin_id') != '1') ) ) {
                 $this->session->set_flashdata('warning','Unauthorised access.');
               return redirect(base_url().$this->router->fetch_class().'/packing_list_manager_qa_approve');
            }
            
            $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $packing_type = $this->packing_type->findAll(array('datype' => $da_header['da_type']));
            //echo "<pre>";print_r($packing_type);die;
            $data['packing_type'] = $packing_type;
            $data['packing_list'] = $packing_list;
            $data['da_items'] = $da_items[0];
            $data['da_header'] = $da_header;
            $data['db_file_path'] = !empty($packing_list[0]['file_path']) ? $packing_list[0]['file_path'] : '';
            
            $data['pageTitle'] = 'Neclife- Manager QA | Plant Packing Lsit Approve Form';
            $data['template']  = 'qa/manager-qa-approve-form';
            $this->load->view('template_admin',$data);
        }


        public function gsk_packing_list() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
            $data = array();
            $post = $this->input->post();

            if(!empty($post)) {

            }

            $gsk_packing_list = $this->gsk_packing->getAll();
            $data['packing_list'] = $gsk_packing_list;
            $data['pageTitle'] = 'Neclife- Manager QA | GSK Packing List';
            $data['template']  = 'qa/gsk/manager-index';
            $this->load->view('template_admin',$data);
           
        }


        public function gsk_packing_approval($id = '') {
            
            $gsk_packing_main = $this->gsk_packing->findOne(array('id' => $id));
            if(empty($id) && empty( $gsk_packing_main)){
                $this->session->set_flashdata('warning', 'No direct script access allowed.');
                return redirect(base_url().$this->router->fetch_class());
            }

            if($this->session->userdata('error')) {
                  $this->session->unset_userdata('error');
            }

            $data = array();
            $post = $this->input->post();

            if(!empty($post)) {
               
                if($this->sessionSelected != $this->currentSession) {
                    $this->session->set_flashdata('session-mismatch','session-mismatch');
                    return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$id);
               }
               
               $checkInvoice = $this->export_gsk_header->findOne(array('da_no' => $post['da_no']));
               if(!empty($checkInvoice)) {

                    $this->session->set_flashdata('info', 'Sorry changes are not possible to gsk packing list now. Its has been gone through the Futher steps.');
                    return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$id);
               }
                
                //echo "<pre>"; print_r($post);die;

                $gsk_packing_array = array(
                    
                    'da_no' => $post['da_no'],
                    'party_name' => strip_tags($post['buyer_name']),
                    'product_name' => strip_tags($post['product']),
                    'qauntity' => strip_tags($post['qauntity']),
                    'invoice_no' => strip_tags($post['invoice_no']),
                    'po_no' => strip_tags($post['po_no']),
                    'despatch_date' => strip_tags($post['despatch_date']),
                    'travel_sample1' => strip_tags($post['travel_sample1']),
                    'travel_sample2' => strip_tags($post['travel_sample2']),
                    'travel_sample3' => strip_tags($post['travel_sample3']),
                    'grand_tare ' => strip_tags($post['grand_tare']),
                    'grand_net' => strip_tags($post['grand_net']),
                    'grand_gross' => strip_tags($post['grand_gross']),
                    'grand_tare_coggurated' => strip_tags($post['grand_tare_coggurated']),
                    'grand_gross_coggurated' => strip_tags($post['grand_gross_coggurated']),
                    'grand_gross_pallet' => strip_tags($post['grand_gross_pallet']),
                    'gsk_info' => $post['gsk_info'],
                    'pallet_dimensions' => $post['pallet_dimensions'],
                    'manager_qa' => $this->session->userdata('username'),
                    'manager_remarks' => strip_tags($post['manager_remarks'])

               );
               
               $insert = $this->gsk_packing->update($gsk_packing_array, array('id' => $id));

               if(!empty($insert)) {

                        if(!empty($post['serial_no'])) {
                            $count = count($post['serial_no']);
                            $gsk_map_table_array = array();
                            for($i = 0; $i <= $count - 1; $i++) {
                             if(!empty($post['serial_no'][$i])) {
                                $gsk_map_table_array[] = array (

                                    'gsk_id' => $id,
                                    'da_no' => $post['da_no'],
                                    'serial_no' => $post['serial_no'][$i],
                                    'excise_serial_no' => $post['excise_serial_no'][$i],
                                    'bag_no' => $post['bag_no'][$i],
                                    'batch_no' => $post['batch_no'][$i],
                                    'mfg_date' => $post['mfg_date'][$i],
                                    'retest_date' => $post['retest_date'][$i],
                                    'tare_wt' => $post['tare_wt'][$i],
                                    'net_wt' => $post['net_wt'][$i],
                                    'gross_wt' => $post['gross_wt'][$i],
                                    'tare_wt_corrugated' => $post['tare_wt_corrugated'][$i],
                                    'gross_wt_corrugated' => $post['gross_wt_corrugated'][$i],
                                    'gross_wt_pallet' => $post['gross_wt_pallet'][$i]

                                );
                              }
                            }

                            if(!empty($gsk_map_table_array)) {
                                 $this->gsk_packing_map->deleteWhere(array('gsk_id' => $id ));
                                $this->gsk_packing_map->insertBatch($gsk_map_table_array);
                            }
                        }

                        $audit_trial = array(
                                'transaction_date' => date('Y-m-d'),
                                'transaction_time' => date("H:i:s"),
                                'username' => $this->session->userdata()['username'],
                                'action' => 'GSk Packing list approved for '.$post['gsk_da'],
                            );
                        $this->audit->insert($audit_trial);

                        $role = $this->admin_model->findAll(array('admin_group' => 1));
                                       
                        if(!empty($role)) {
                            $userdata = array();
                            foreach ($role as $key => $value) {
                                 $userdata[$key]['name'] = $value['first_name'].' '.$value['last_name'];
                                 $userdata[$key]['email'] = $value['email'];
                            }
                            if(!empty($userdata)) {
                                foreach($userdata as $key => $value) {
                                $data['username'] = $value['name'];
                                $data['message'] = 'A GSK Packing list Manager approved successfully added to DA Entry "'.$post['gsk_da'].'"';
                                $message = $this->load->view('email-templates/da-mail', $data, true);
                                $this->emailsender_model->sendMail($value['email'], 'Neclife GSK Packing List Manager QA Approved', $message);
                               }
                            }
                         }

                     $this->session->set_flashdata('success','GSK Packing List '.$message.' successfully');
                     return redirect(base_url().$this->router->fetch_class().'/gsk_packing_list');
               } else {

                    $this->session->set_flashdata('error','Unable to process your request. Please try agin later.');
                    return redirect(base_url().$this->router->fetch_class().'/gsk_packing_list');
               }
            } 

            $gsk_packing_list_map = $this->gsk_packing_map->findAll(array('gsk_id' => $id));
            $da_header = $this->da_header->findOne(array('id' => $gsk_packing_main['da_no']));

            $data['gsk_packing'] = $gsk_packing_main;
            $data['packing_list'] = $gsk_packing_list_map;
            $data['da_header'] = $da_header;

            $data['pageTitle'] = 'Neclife- QA | GSK Packing List';
            $data['template']  = 'qa/gsk/manager-qa-approve-form';
            $this->load->view('template_admin',$data);
        }
         


        
    }