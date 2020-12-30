<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Qualityassurance extends MY_Controller {

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
            $this->load->library('excel');
            
            $this->sessionSelected = $this->session->userdata('financial_year');
            $this->currentSession = $this->currentSession();

            $this->role = $this->session->userdata('role');
            if($this->role != 1 && $this->role != 15) {
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

            return redirect(base_url().$this->router->fetch_class().'/packing_list_plant_check');
        }


        /**
        * Function to add packing_list_plant_check.
        * @param 
        * Created On:  09-June-2020
        * Created By:  karan.parihar@ids
        */

        public function packing_list_plant_check() {

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
            //echo "<pre>"; print_r($packing_list);die;
            $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['packing_list'] = $packing_list;
            $data['pageTitle'] = 'Neclife- QA | Plant Packing Lsit Check/Uncheck';
            $data['template']  = 'qa/index';
            $this->load->view('template_admin',$data);
        }


        /**
        * Function tare_weight_change_form.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function packing_list_plant_check_form($dano = '', $product_form = '') {

            if(empty($dano) || empty($product_form)) {
                $this->session->set_flashdata('warning', 'No direct script access allowed.');
                return redirect(base_url().$this->router->fetch_class().'/packing_list_plant_check');
            }
            
            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
          
            $data = array();
            $packing_list = $this->packing_list->findAllPackingListByProductForm($dano,$product_form);

            //echo "<pre>"; print_r($this->db->last_query());die;

            $post = $this->input->post();

            if(!empty($post)) {

                if($this->sessionSelected != $this->currentSession) {
                    $this->session->set_flashdata('session-mismatch','session-mismatch');
                    return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$dano.'/'.$product_form);
               }
                
               if(!empty($packing_list[0]['approved_by'])) {
                    
                    $this->session->set_flashdata('info', 'Sorry changes are not possible to packing list now. Its has been gone through the Futher steps.');
                    return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$dano.'/'.$product_form);
               }
    
               $check_uncheck = !empty($post['check_uncheck']) ? $this->session->userdata('username'): '';
               $message = !empty($post['check_uncheck']) ? 'Checked': 'Unchecked';
               $table_array =  array('checked_by' => $check_uncheck);
               $insert = $this->packing_list->update( $table_array , array('da_no'=>$dano,'product_form' =>$product_form));
               
               if(!empty($insert)) {

                        $audit_trial = array(
                                'transaction_date' => date('Y-m-d'),
                                'transaction_time' => date("H:i:s"),
                                'username' => $this->session->userdata()['username'],
                                'action' => 'Packing list checked for '.$dano,
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
                                $data['message'] = 'A Packing list checked successfully added to DA Entry "'.$dano.'"';
                                $message = $this->load->view('email-templates/da-mail', $data, true);
                                $this->emailsender_model->sendMail($value['email'], 'Neclife DA Entry', $message);
                               }
                            }
                         }


                     $this->session->set_flashdata('success','Plant list '.$message.' successfully');
                     return redirect(base_url().$this->router->fetch_class().'/packing_list_plant_check');
               } else {
                    $this->session->set_flashdata('error','Unable to process your request. Please try agin later.');
                    return redirect(base_url().$this->router->fetch_class().'/packing_list_plant_check');
               }
            }
            $da_header = $this->da_header->findHeaderItems($dano);
            
            $da_items = $this->da_items->findDAItems(array('da_no' => $dano, 'product_form'=>$product_form));
            

            if(empty($packing_list)) {
                 $this->session->set_flashdata('warning','Packing list is not generated yet.');
               return redirect(base_url().$this->router->fetch_class().'/packing_list_plant_check');
            }

            
            $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $data['packing_list'] = $packing_list;

            //echo "<pre>"; print_r($packing_list);die;
            $data['da_items'] = $da_items[0];
            $data['da_header'] = $da_header;
            
            $data['pageTitle'] = 'Neclife- QA | Plant Packing Lsit Check/Uncheck Form';
            $data['template']  = 'qa/check-uncheck-form';
            $this->load->view('template_admin',$data);
        }

        /**
        * Function to add packing_list_plant_check.
        * @param 
        * Created On:  09-June-2020
        * Created By:  karan.parihar@ids
        */

        public function packing_list_plant_qa_approve() {

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

            $data['pageTitle'] = 'Neclife- QA | Plant Packing Approve';
            $data['template']  = 'qa/qa-approve';
            $this->load->view('template_admin',$data);
        }


         /**
        * Function to add packing_list_plant_check.
        * @param 
        * Created On:  09-June-2020
        * Created By:  karan.parihar@ids
        */

        public function generate_production_excel($id ='', $itemId = '') {
             
            if(empty($id) || empty($itemId)){
                $this->session->set_flashdata('warning', 'No direct script access allowed.');
                return redirect(base_url().$this->router->fetch_class());
            }

            $item = $this->da_items->findOne(array('id' => $itemId));
            $findone  = $this->da_header->findOne(array('id' => $id));
            $data['findone'] = $findone;

            if(empty($findone) || empty($item) ) {
                 $this->session->set_flashdata('warning','Unauthorised access.');
                  return redirect(base_url().$this->router->fetch_class().'/packing_list');
            }

            $da_header = $this->da_header->findHeaderItems($id);
            $findQty =  $this->da_items->findAll(array('da_no' => $id));

            if(!empty($findQty)){
                $totalQty = false;
                foreach($findQty as $key => $value) {
                    $totalQty += $value['quantity'];
                }
            }
            $data['total_da_qty'] = number_format((float)$totalQty, 2, '.', '');
            $da_items = $this->da_items->findDAItemsById($itemId);
            
            $packing_list = $this->packing_list->findAll(array('product' => $da_items[0]['product'], 'da_no' => $da_items[0]['da_no'] ), array('orderby' => 'id','order' => 'ASC')); 

            if(!empty($packing_list)) {
                $packing_list_final = [];
                foreach ($packing_list as $key => $value) {
                      $packing_list_final[$value['batch_no']][] = $value;
                }
            }
         
            $last_index = count($packing_list) - 1;   
            $data['production_remarks'] = $packing_list[0]['production_remarks'];

            //echo "<pre>"; print_r($packing_list[0]['packing_list_date']);die;
            
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PACKING LIST');
            $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Work : Vill Saidpura Teh Derabassi Distt Mohali (Punjab)');
            $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Oral Section');
            $objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Finished Good Packing Details');
        
            $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Party Name');
            $objPHPExcel->getActiveSheet()->SetCellValue('D5',  $da_header['buyer_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G5',  $da_header['da_no']);

            $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Product Name');
            $objPHPExcel->getActiveSheet()->SetCellValue('D6',  isset($da_items[0]['product_name']) ? $da_items[0]['product_name'] : '') ;
            $objPHPExcel->getActiveSheet()->SetCellValue('G6',  isset($da_items[0]['productgrade']) ? $da_items[0]['productgrade'] : '' / isset($da_items[0]['productform'] ) ? $da_items[0]['productform'] : '');
                    
            $objPHPExcel->getActiveSheet()->SetCellValue('A7', 'Qauntity');
            $objPHPExcel->getActiveSheet()->SetCellValue('D7',  isset(
                $da_items[0]['quantity']) ? $da_items[0]['quantity']. ' KGS' : '');
            
            $objPHPExcel->getActiveSheet()->SetCellValue('A8', 'Excise Sr No');
            $objPHPExcel->getActiveSheet()->SetCellValue('D8',  $packing_list[0]['excise_sr_no'] .' to '.$packing_list[$last_index]['excise_sr_no']);
            $date = date_create($packing_list[$last_index]['packing_list_date']);
            $dp = date_format($date,"d.m.Y");
            $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Despatched Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('D9',  $dp);


            $objPHPExcel->getActiveSheet()->SetCellValue('A10', 'Batch No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('B10', 'Sr.No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('C10', 'Exc No.');
            $objPHPExcel->getActiveSheet()->SetCellValue('D10', 'Tare Weight');
            $objPHPExcel->getActiveSheet()->SetCellValue('E10', 'Net Weight');
            $objPHPExcel->getActiveSheet()->SetCellValue('F10', 'Gross Weight');
            $objPHPExcel->getActiveSheet()->SetCellValue('G10', 'Mfg Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('H10', 'Exp Date');
            
            // set Row
            $rowCount = 11;
            $counter  = 0;
            $loopCounter = 0;

            $nextAfterLoop = ($rowCount + count($packing_list)) + 1;

            foreach ($packing_list as $key => $list) {

                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list['batch_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, ++$counter);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['excise_sr_no']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['outer_tare_weight']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['net_weight']);
               $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['outer_gross_weight']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['mfg_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list['exp_date']);
               
                  $rowCount++; 
                  $loopCounter++;
            }   

             $objPHPExcel->getActiveSheet()->SetCellValue('D'.$nextAfterLoop, 'Dimensions '.$packing_list[0]['pallet_dimensions']);
            
            $filename = "API PACKING LIST - ".$da_header['da_no']. date("Y-m-d-H-i-s").".csv";
            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
            $objWriter->save('php://output'); 


        } 


        /**
        * Function tare_weight_change_form.
        * @param 
        * Created On:  18-May-2020
        * Created By:  karan.parihar@ids
        */

        public function packing_list_plant_qa_approve_form($dano = '', $product_form = '') {
            
            if(empty($dano) || empty($product_form)) {
                $this->session->set_flashdata('warning', 'No direct script access allowed.');
                return redirect(base_url().$this->router->fetch_class().'/packing_list_plant_qa_approve');
            }
            
            $data = array();
            $post = $this->input->post();
            $packing_list = $this->packing_list->findAllPackingListByProductForm($dano,$product_form);

            if(!empty($post)) {

                if($this->sessionSelected != $this->currentSession) {
                    $this->session->set_flashdata('session-mismatch','session-mismatch');
                    return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$dano.'/'.$product_form);
                }

                if(!empty($packing_list[0]['manager_qa'])) {
                    $this->session->set_flashdata('info', 'Sorry changes are not possible to packing list now. Its has been gone through the Futher steps.');
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
                                    'checked_by' => $post['post_checked_by'],
                                    'qa_remarks' => $post['qa_remarks'],
                                    'approved_by' => $this->session->userdata()['username']
                                );
                            }
                        }
                        
                        //echo "<pre>";print_r($packing_list_table_array);die;
                        if(!empty($packing_list_table_array)){
                             $this->packing_list->deleteWhere(array('da_no'=>$dano,'product_form' =>$product_form));
                             $insert = $this->packing_list->insertBatch($packing_list_table_array);
                        }
                    } else {
                         $this->session->set_flashdata('error','Please add the packing list properly.');
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
                            'approved_by' => $this->session->userdata()['username']
                         

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
                                    'action' => 'QA remarks added for '.$dano,
                                );
                            $this->audit->insert($audit_trial);
                            
                         $this->session->set_flashdata('success','QA remarks added successfully');
                         return redirect(base_url().$this->router->fetch_class().'/packing_list_plant_qa_approve');
                   } else {
                        $this->session->set_flashdata('success','Unable to process your request. Please try agin later.');
                        return redirect(base_url().$this->router->fetch_class().'/packing_list_plant_qa_approve');
                   }

               } else {
                    
                    $this->session->set_flashdata('error','Form validation.Please check the form.');
               }
            }
            $da_header = $this->da_header->findHeaderItems($dano);
           
            $da_items = $this->da_items->findDAItems(array('da_no' => $dano, 'product_form'=>$product_form));

            if(empty($packing_list) ) {
                 $this->session->set_flashdata('warning','Unauthorised access.');
               return redirect(base_url().$this->router->fetch_class().'/packing_list_plant_qa_approve');
            }
            
            $data['buyers'] = $this->party->findAll(null, array('orderby' => 'party','order' => 'ASC'));
            $packing_type = $this->packing_type->findAll(array('datype' => $da_header['da_type']));
            //echo "<pre>";print_r($packing_type);die;
            $data['packing_type'] = $packing_type;
            $data['packing_list'] = $packing_list;
            $data['da_items'] = $da_items[0];
            $data['da_header'] = $da_header;
            $data['db_file_path'] = !empty($packing_list[0]['file_path']) ? $packing_list[0]['file_path'] : '';
            
            $data['pageTitle'] = 'Neclife- QA | Plant Packing Approve Form';
            $data['template']  = 'qa/qa-approve-form';
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
           // echo "<pre>"; print_r($this->db->last_query());die;
            $data['packing_list'] = $gsk_packing_list;
            $data['pageTitle'] = 'Neclife- QA | GSK Packing List';
            $data['template']  = 'qa/gsk/index';
            $this->load->view('template_admin',$data);
           
        }

        public function gsk_packing_check_uncheck($id = '') {
            
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
                
              /* if(!empty($gsk_packing_main['approved_by'])) {
                    
                    $this->session->set_flashdata('info', 'Sorry changes are not possible to gsk packing list now. Its has been gone through the Futher steps.');
                    return redirect(base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$id);
               }*/

               

               $check_uncheck = !empty($post['check_uncheck']) ? $this->session->userdata('username'): '';
               $message = !empty($post['check_uncheck']) ? 'Checked': 'Unchecked';
               $table_array =  array('checked_by' => $check_uncheck);
               $insert = $this->gsk_packing->update( $table_array , array('id' => $id ));

               if(!empty($insert)) {

                        $audit_trial = array(
                                'transaction_date' => date('Y-m-d'),
                                'transaction_time' => date("H:i:s"),
                                'username' => $this->session->userdata()['username'],
                                'action' => 'GSk Packing list checked for '.$post['gsk_da'],
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
                                $data['message'] = 'A GSK Packing list checked successfully added to DA Entry "'.$dano.'"';
                                $message = $this->load->view('email-templates/da-mail', $data, true);
                                $this->emailsender_model->sendMail($value['email'], 'Neclife GSK Packing List Checked/Unchecked', $message);
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
            $data['template']  = 'qa/gsk/check-uncheck-form';
            $this->load->view('template_admin',$data);
        }

        public function gsk_packing_approval() {

            if($this->session->userdata('error')) {
                $this->session->unset_userdata('error');
            }
            $data = array();
            $post = $this->input->post();

            if(!empty($post)) {

            }

            $gsk_packing_list = $this->gsk_packing->getAll();
            $data['packing_list'] = $gsk_packing_list;
            $data['pageTitle'] = 'Neclife- QA | GSK Packing List';
            $data['template']  = 'qa/gsk/qa-approve';
            $this->load->view('template_admin',$data);
           
        }

        public function gsk_packing_approval_form($id = '') {
            
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
                
               if(!empty($gsk_packing_main['manager_qa'])) {
                    
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
                    'approved_by' => $this->session->userdata('username'),
                    'qa_remarks' => strip_tags($post['qa_remarks'])

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
                                $data['message'] = 'A GSK Packing list approval successfully added to DA Entry "'.$post['gsk_da'].'"';
                                $message = $this->load->view('email-templates/da-mail', $data, true);
                                $this->emailsender_model->sendMail($value['email'], 'Neclife GSK Packing List QA Approved', $message);
                               }
                            }
                         }

                     $this->session->set_flashdata('success','GSK Packing List '.$message.' successfully');
                     return redirect(base_url().$this->router->fetch_class().'/gsk_packing_approval');
               } else {

                    $this->session->set_flashdata('error','Unable to process your request. Please try agin later.');
                    return redirect(base_url().$this->router->fetch_class().'/gsk_packing_approval');
               }
            } 

            $gsk_packing_list_map = $this->gsk_packing_map->findAll(array('gsk_id' => $id));
            $da_header = $this->da_header->findOne(array('id' => $gsk_packing_main['da_no']));

            $data['gsk_packing'] = $gsk_packing_main;
            $data['packing_list'] = $gsk_packing_list_map;
            $data['da_header'] = $da_header;

            $data['pageTitle'] = 'Neclife- QA | GSK Packing List';
            $data['template']  = 'qa/gsk/qa-approve-form';
            $this->load->view('template_admin',$data);
        }
         

        public function generate_excel($da_no = '') {

                if(empty($da_no)) {

                    $this->session->set_flashdata('warning', 'Unauthorised action.');
                    return redirect(base_url(). $this->router->fetch_class(). '/gsk');
                }

                $gsk_packing = $this->gsk_packing->findOne(array('da_no' => $da_no));
                $gsk_packing_map = $this->gsk_packing_map->findAll(array('da_no' => $da_no));
                
                if(!empty($gsk_packing_map)) {
                     
                    $gsk_packing_map1 =  array();
                    $counterStrike = (count($gsk_packing_map) * 6 );

                    foreach ($gsk_packing_map as $key => $value) {

                        for($i = 1 ; $i <= 6; $i++) {

                                $gsk_packing_map1[] = array(
                                    'data' => $value,
                                    'bag_no1' => $i,        
                                );
                            }

                        }
                    }
                //echo "<pre>"; print_r($gsk_packing_map1);die;

                $da = $this->da_header->findOne(array('id' => $da_no));
                $da_name  = $da['da_no'];

                if(empty($gsk_packing) && empty($gsk_packing_map)) {
                   $this->session->set_flashdata('info', 'Not able to generate the excel at moment. Please verify once and try again.');
                   return redirect(base_url(). $this->router->fetch_class(). '/manage_gsk_packing/'.$da_no);
                }

                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);

                // set Header

                $objPHPExcel->getActiveSheet()->SetCellValue('F1', '(Oral Section)');
                $objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Finished Goods Packing List (Export)');
                $objPHPExcel->getActiveSheet()->SetCellValue('F3', 'DA '.$da_name);
                
                $objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Party Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('D5',  $gsk_packing['party_name']);

                $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Product Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('D6',  $gsk_packing['product_name']);


                $objPHPExcel->getActiveSheet()->SetCellValue('A7', 'Qauntity');
                $objPHPExcel->getActiveSheet()->SetCellValue('D7',  $gsk_packing['qauntity']);

                $objPHPExcel->getActiveSheet()->SetCellValue('A8', 'Purchase Order No');
                $objPHPExcel->getActiveSheet()->SetCellValue('D8',  $gsk_packing['po_no']);

                $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Invoice No');
                $objPHPExcel->getActiveSheet()->SetCellValue('D9',  $gsk_packing['invoice_no']);

                $objPHPExcel->getActiveSheet()->SetCellValue('A10', 'Despatch Date.');
                $objPHPExcel->getActiveSheet()->SetCellValue('D10',  $gsk_packing['despatch_date']);

                $objPHPExcel->getActiveSheet()->SetCellValue('A12', 'S.No.');
                $objPHPExcel->getActiveSheet()->SetCellValue('B12', 'Excise S.No.');
                $objPHPExcel->getActiveSheet()->SetCellValue('C12', 'Bag No.');
                $objPHPExcel->getActiveSheet()->SetCellValue('D12', 'Batch No.');
                $objPHPExcel->getActiveSheet()->SetCellValue('E12', 'Mfg Date');
                $objPHPExcel->getActiveSheet()->SetCellValue('F12', 'Retest Date');
                $objPHPExcel->getActiveSheet()->SetCellValue('G12', 'Tare Wt.(Polybag)');
                $objPHPExcel->getActiveSheet()->SetCellValue('H12', 'Net Wt.');
                $objPHPExcel->getActiveSheet()->SetCellValue('I12', 'Gross Wt.(Bag)');
                $objPHPExcel->getActiveSheet()->SetCellValue('J12', 'Tare Wt.(Corrugated Box)');   
                $objPHPExcel->getActiveSheet()->SetCellValue('K12', 'Gross Wt.(Corrugated Box)');
                $objPHPExcel->getActiveSheet()->SetCellValue('L12', 'Gross Wt.(Pallet)');
                
                // set Row
                $rowCount = 13;
                $nextAfterLoop = ($rowCount + count($gsk_packing_map1)) + 1;

                $secondLoop = $nextAfterLoop + 2;
                $thirdLoop = $secondLoop +1;
                $fourthLoop = $thirdLoop + 1;
                $fifthLoop = $fourthLoop + 1;
                
                $tare_wt = 0 ;

                
                foreach ($gsk_packing_map1 as $list) {
                    
                    if($list['bag_no1'] == '1') {
                          $serial_no = $list['data']['serial_no'];
                          $excise_serial_no = $list['data']['excise_serial_no'];
                          $tare_wt_corrugated = $list['data']['tare_wt_corrugated'];
                          $gross_wt_corrugated = $list['data']['gross_wt_corrugated'];
                          $gross_wt_pallet = $list['data']['gross_wt_pallet'];

                    } else {

                         $serial_no = '';
                         $excise_serial_no = '';
                         $tare_wt_corrugated = '';
                         $gross_wt_corrugated  = '';
                         $gross_wt_pallet = '';

                    }
                
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $serial_no);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $excise_serial_no);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['bag_no1']);

                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['data']['batch_no']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['data']['mfg_date']);
                   
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['data']['retest_date']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['data']['tare_wt']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list['data']['net_wt']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $list['data']['gross_wt']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $tare_wt_corrugated);
 
                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $gross_wt_corrugated);

                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount,  $gross_wt_pallet);
                      $rowCount++; 
                }   
              
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$nextAfterLoop, 'Travel Sample');
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$nextAfterLoop,  $gsk_packing['travel_sample1']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$nextAfterLoop,  $gsk_packing['travel_sample2']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$nextAfterLoop,  $gsk_packing['travel_sample3']);

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$nextAfterLoop, 'Travel Sample');
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$nextAfterLoop,  $gsk_packing['travel_sample1']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$nextAfterLoop,  $gsk_packing['travel_sample2']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$nextAfterLoop,  $gsk_packing['travel_sample3']);

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$secondLoop, 'Grand Total');
               

                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$secondLoop,  $gsk_packing['grand_tare'].' KGS');
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$secondLoop,  $gsk_packing['grand_net'].' KGS');
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$secondLoop,  $gsk_packing['grand_gross'].' KGS');
                   $objPHPExcel->getActiveSheet()->SetCellValue('J'.$secondLoop,  $gsk_packing['grand_tare_coggurated'].' KGS');
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$secondLoop,  $gsk_packing['grand_gross_coggurated'].' KGS');
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$secondLoop,  $gsk_packing['grand_gross_pallet'].' KGS');



                $gsk_info = strip_tags($gsk_packing['gsk_info']);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$thirdLoop, 'Note: Pallet having following Excise No. Containing Temp Tales');
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fourthLoop, trim($gsk_info));
 
                $pallet_dimensions  = strip_tags($gsk_packing['pallet_dimensions']);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fifthLoop, 'Pallet Dimensions');
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fifthLoop, trim($pallet_dimensions));
                
                $filename = "GSK-Packing-list-".$da_name. date("Y-m-d-H-i-s").".csv";
                header('Content-Type: application/vnd.ms-excel'); 
                header('Content-Disposition: attachment;filename="'.$filename.'"');
                header('Cache-Control: max-age=0'); 
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
                $objWriter->save('php://output'); 
         }
    }