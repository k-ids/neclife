<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masters extends CI_Controller {


     public function __construct()
	 {
		    parent::__construct();
		    $this->load->library('form_validation');
		    $this->load->model('Common_model', 'my_model');
		    $this->load->model('Datype_model');
		    $this->session->unset_userdata('error');

	 }

	public function index()
	{ 
		if ($this->Admin_model->verifyUser()) {
			redirect(base_url(), 'auto');
		} 
	}

	public function datype($page = null, $adminid = 0) {
		if ($this->Admin_model->verifyUser()) {
			if ($this->input->post()){
				$postData = $this->input->post();
				$this->Admin_model->updateAdmins($postData, $postData["action"]);
			}
			if ($page == "add") {
				$this->load->model('Datype_model');
				$data["admin_groups"] = $this->Datype_model->getAdminGroups();
				$this->load->view('header');
				$this->load->view('masters/datype_add', $data);
				$this->load->view('footer');
			}  else {
				$this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getAdmins();
				$this->load->view('header');
				$this->load->view('masters/datype', $data);
				$this->load->view('footer');
			} 	
		}
	}
	
	public function datype_add(){
		
		$this->load->model('Datype_model');
		
		//  This will set the query data
		$data = array();
		 
		$data = array("datype" =>$_POST["datype1"]) ;
		$this->Datype_model->addtype($data);

		
	}


	/**
	* Function Add DA type
	* @param POST
	*
	* Created on : 14-May-2020
	* Created By : Karan Parihar
	*/

	public function add_da_type() {
		$post = $this->input->post();
        
        $this->form_validation->set_rules('datype1', 'da type' , 'required|is_unique[datype.datype]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
				$data["admins"] = $this->Datype_model->getAdmins();
				$this->load->view('header');
				$this->load->view('masters/datype', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('datype' => $post['datype1']);
			$this->db->insert('datype' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'DA type added successfully!.');
				return redirect(base_url().'masters/datype');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/datype');
			}
		}
	}
	
	// Customer view 
	
	public function customer($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["customers"] = $this->Datype_model->getParty();
			$this->load->view('header');
			$this->load->view('masters/customers/customer', $data);
			$this->load->view('footer');
		}
	}
	
	

	/**
	* Function customer add.
	* @param id, POST
	*
	* created on: 13-May-2020
	* created by: Karan  Parihar
	*/

	public function customer_add() {

		$post = $this->input->post();

		if(!empty($post)) {

                $this->form_validation->set_rules('party', 'party', 'required');
                $this->form_validation->set_rules('address1', 'address 1', 'required');
                $this->form_validation->set_rules('address2', 'address 2', 'required');
                $this->form_validation->set_rules('address3', 'address 3', 'required');
                $this->form_validation->set_rules('phone', 'phone', 'required');
                $this->form_validation->set_rules('fax', 'fax', 'required');
                $this->form_validation->set_rules('bankdetails', 'bank details', 'required');
                $this->form_validation->set_rules('ecgcinr', 'ecg inr', 'required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

                if ($this->form_validation->run() == FALSE)  {
                       $this->session->set_flashdata('error', 'Validation error.Please check the form.');
                       $this->load->view('header');
					   $this->load->view('masters/customers/add');
					   $this->load->view('footer');

                } else  {

                     $this->load->model('Datype_model');
					//  This will set the query data
					 $data = array();
					 // party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr
					 $table_array = array("party" =>$post["party"], "address1" =>$post["address1"], "address2" =>$post["address2"], "address3" =>$post["address3"], "phone" =>$post["phone"], "fax" =>$post["fax"], "bankdetails" =>$post["bankdetails"], "ecgcinr" =>$post["ecgcinr"]) ;
					  $this->db->insert('party', $table_array);
					  $inserted =  $this->db->insert_id();
					 if(!empty($inserted)) {

                           $this->session->set_flashdata('success', 'Customer added successfully!');
					 	   return redirect(base_url().'masters/customer');
					 } else {

					 	  $this->session->set_flashdata('error', 'Technical error.');
					 	  return redirect(base_url().'masters/customer');
					 }
                }

		} else {
            
              $this->load->view('header');
			  $this->load->view('masters/customers/add');
			  $this->load->view('footer');
		}
	}

	/**
	* Function customer edit.
	* @param id, POST
	*
	* created on: 13-May-2020
	* created by: Karan  Parihar
	*/

     public function customer_edit($id = '') {

        $data = array();
        $data['customer'] = $this->db->get_where('party', array('id =' => $id))->row_array();
        $post = $this->input->post();

     	if(!empty($post)) {
             
                $this->form_validation->set_rules('party', 'party', 'required');
                $this->form_validation->set_rules('address1', 'address 1', 'required');
                $this->form_validation->set_rules('address2', 'address 2', 'required');
                $this->form_validation->set_rules('address3', 'address 3', 'required');
                $this->form_validation->set_rules('phone', 'phone', 'required');
                $this->form_validation->set_rules('fax', 'fax', 'required');
                $this->form_validation->set_rules('bankdetails', 'bank details', 'required');
                $this->form_validation->set_rules('ecgcinr', 'ecg inr', 'required');
                $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

                if ($this->form_validation->run() == FALSE)  {
                       $this->session->set_flashdata('error', 'Validation error.Please check the form.');
                       //return redirect(base_url().'masters/edit-customer/'.$id);
                       $this->load->view('header');
			           $this->load->view('masters/customers/customer_edit', $data);
			           $this->load->view('footer');
                }
                else {
                       
                       $table_array = array( "party" => $post["party"], "address1" => $post["address1"], "address2" => $post["address2"], "address3" =>$post["address3"], "phone" => $post["phone"], "fax" => $post["fax"], "bankdetails" => $post["bankdetails"], "ecgcinr" => $post["ecgcinr"]) ;
                       
                       $updated = $this->my_model->update_table($id, 'party', $table_array);

                       if(!empty($updated)) {
                             
		                       $this->session->set_flashdata('success', 'Customer updated successfully!');
		                       return redirect(base_url().'masters/customer');

                       } else {
                    
                              $this->session->set_flashdata('info', 'Nothing to update.Please update form otherwise return back.');
                              return redirect(base_url().'masters/edit-customer/'.$id);
                       }
                }

     	} else {

	          $this->load->view('header');
			  $this->load->view('masters/customers/customer_edit', $data);
			  $this->load->view('footer');
     	}
     }
 

	// Currency view 
	
	public function currency($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getCurrency();
			$this->load->view('header');
			$this->load->view('masters/currency', $data);
			$this->load->view('footer');
		}
	}
	
	
	public function currency_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr
		$data = array("currency" =>$_POST["currency"]) ;
		$this->Datype_model->addcurrency($data);*/


		$post = $this->input->post();
        
        $this->form_validation->set_rules('currency', 'currency' , 'required|is_unique[currency.currency]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $data["admins"] = $this->Datype_model->getCurrency();
				$this->load->view('header');
				$this->load->view('masters/currency', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('currency' => $post['currency']);
			$this->db->insert('currency' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Currency added Successfully!.');
				return redirect(base_url().'masters/currency');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/currency');
			}
		}
		
	}


		

	
	
	// shipmentmode view 
	
	public function shipmentmode($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
		$this->load->model('Datype_model');
		$data["admins"] = $this->Datype_model->getShipmentmode();
		$this->load->view('header');
		$this->load->view('masters/shipmentmode', $data);
		$this->load->view('footer');
		}
	
	}
	
	
	public function shipmentmode_add() {
		
	/*	$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr
		$data = array("shippingmode" =>$_POST["shipmentmode"]) ;
		$this->Datype_model->addshipmentmode($data);*/


		$post = $this->input->post();
        
        $this->form_validation->set_rules('shipmentmode', 'shipment mode' , 'required|is_unique[shippingmode.shippingmode]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $data["admins"] = $this->Datype_model->getShipmentmode();
				$this->load->view('header');
				$this->load->view('masters/shipmentmode', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('shippingmode' => $post['shipmentmode']);
			$this->db->insert('shippingmode' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Shipment Mode added Successfully!.');
				return redirect(base_url().'masters/shipmentmode');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/shipmentmode');
			}
		}
		
	}
	
	
	
	//documentsrequired
	public function documentsrequired($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
		$this->load->model('Datype_model');
		$data["admins"] = $this->Datype_model->getDocumentsrequired();
		$this->load->view('header');
		$this->load->view('masters/documentsrequired', $data);
		$this->load->view('footer');
		}
	}
	
	
	public function documentsrequired_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr
		$data = array("documentsrequired" =>$_POST["documentsrequired"]) ;
		$this->Datype_model->adddocumentsrequired($data);*/


		$post = $this->input->post();
        
        $this->form_validation->set_rules('documentsrequired', 'document' , 'required|is_unique[documentsrequired.documentsrequired]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getDocumentsrequired();
				$this->load->view('header');
				$this->load->view('masters/documentsrequired', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('documentsrequired' => $post['documentsrequired']);
			$this->db->insert('documentsrequired' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Documents Required added Successfully!.');
				return redirect(base_url().'masters/documentsrequired');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/documentsrequired');
			}
		}
		
	}

	
	//agent
	public function agent($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
		$this->load->model('Datype_model');
		$data["admins"] = $this->Datype_model->getAgent();
		$this->load->view('header');
		$this->load->view('masters/agent', $data);
		$this->load->view('footer');
		}
	}
	
	
	public function agent_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr
		$data = array("agent" =>$_POST["agent"]) ;
		$this->Datype_model->addagent($data);*/


		$post = $this->input->post();
        
        $this->form_validation->set_rules('agent', 'agent' , 'required|is_unique[agent.agent]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getAgent();
				$this->load->view('header');
				$this->load->view('masters/agent', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('agent' => $post['agent']);
			$this->db->insert('agent' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Agent added Successfully!.');
				return redirect(base_url().'masters/agent');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/agent');
			}
		}
		
	}	
	
	
	
	
	
	//territory
	public function territory($page=null, $adminid=0) {
	if ($this->Admin_model->verifyUser()) {	
		$this->load->model('Datype_model');
		$data["admins"] = $this->Datype_model->getTerritory();
		$this->load->view('header');
		$this->load->view('masters/territory', $data);
		$this->load->view('footer');
	}
	}
	
	
	public function territory_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr
		$data = array("territory" =>$_POST["territory"]) ;
		$this->Datype_model->addterritory($data);
*/


		$post = $this->input->post();
        
        $this->form_validation->set_rules('territory', 'territory' , 'required|is_unique[territory.territory]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getTerritory();
				$this->load->view('header');
				$this->load->view('masters/territory', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('territory' => $post['territory']);
			$this->db->insert('territory' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Territory added Successfully!.');
				return redirect(base_url().'masters/territory');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/territory');
			}
		}
		
	}	
	
	
	
	//deliveryterm
	public function deliveryterm($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
		$this->load->model('Datype_model');
		$data["admins"] = $this->Datype_model->getDeliveryterm();
		$this->load->view('header');
		$this->load->view('masters/deliveryterm', $data);
		$this->load->view('footer');
		}
	}
	
	
	public function deliveryterm_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // deliveryterm 	
		$data = array("deliveryterm" =>$_POST["deliveryterm"]) ;
		$this->Datype_model->adddeliveryterm($data);*/

	    $post = $this->input->post();
        
        $this->form_validation->set_rules('deliveryterm', 'delivery term' , 'required|is_unique[deliveryterm.deliveryterm]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getDeliveryterm();
				$this->load->view('header');
				$this->load->view('masters/deliveryterm', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('deliveryterm' => $post['deliveryterm']);
			$this->db->insert('deliveryterm' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Delivery term added successfully!.');
				return redirect(base_url().'masters/deliveryterm');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/deliveryterm');
			}
		}
		
	}	
	
	
	
	
	
		
	//label
	public function label($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
		$this->load->model('Datype_model');
		$data["admins"] = $this->Datype_model->getLabel();
		$this->load->view('header');
		$this->load->view('masters/label', $data);
		$this->load->view('footer');
		}
	}
	
	
	public function label_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // label 	
		
		$this->Datype_model->addlabel($data);*/


		$post = $this->input->post();
        
        $this->form_validation->set_rules('label', 'label' , 'required|is_unique[label.label]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getLabel();
				$this->load->view('header');
				$this->load->view('masters/label', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('label' => $post['label']);
			$this->db->insert('label' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Label added successfully!.');
				return redirect(base_url().'masters/label');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/label');
			}
		}
		
		
	}	
	
	
		
			
	
	
	//productform
	public function productform($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getProductform();
			$this->load->view('header');
			$this->load->view('masters/productform', $data);
			$this->load->view('footer');
		}
	
	}
	
	
	public function productform_add() {
		
	/*	$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // productform 	
		
		$this->Datype_model->addproductform($data);*/

	    $post = $this->input->post();
       
        $this->form_validation->set_rules('productform', 'product form' , 'required|is_unique[productform.productform]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getProductform();
				$this->load->view('header');
				$this->load->view('masters/productform', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('productform' => $post['productform']);
			$this->db->insert('productform' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Product form added successfully!.');
				return redirect(base_url().'masters/productform');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/productform');
			}
		}
		
	}	
	
	
		
	
	
	//despatchto
	public function despatchto($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getDespatchto();
			$this->load->view('header');
			$this->load->view('masters/despatchto', $data);
			$this->load->view('footer');
		}
	}
	
	
	public function despatchto_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // despatchto 	
		$data = array("despatchto" =>$_POST["despatchto"]) ;
		$this->Datype_model->adddespatchto($data);*/

		$post = $this->input->post();
        
        $this->form_validation->set_rules('despatchto', 'despatch to' , 'required|is_unique[despatchto.despatchto]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getDespatchto();
				$this->load->view('header');
				$this->load->view('masters/despatchto', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('despatchto' => $post['despatchto']);
			$this->db->insert('despatchto' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Despatch-to added successfully!.');
				return redirect(base_url().'masters/despatchto');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/despatchto');
			}
		}
		
	}	
	
			
	
	
	//kindofpackages
	public function kindofpackages($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getKindofpackages();
			$this->load->view('header');
			$this->load->view('masters/kindofpackages', $data);
			$this->load->view('footer');
		}
	}
	
	
	public function kindofpackages_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // despatchto 	
		$data = array("datype" =>$_POST["datype"],"kindofpackages" =>$_POST["kindofpackages"]) ;
		$this->Datype_model->addkindofpackages($data);
*/
		$post = $this->input->post();

        $this->form_validation->set_rules('datype', 'DA type' , 'required');
        $this->form_validation->set_rules('kindofpackages', 'kind of package' , 'required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getKindofpackages();
				$this->load->view('header');
				$this->load->view('masters/kindofpackages', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array =array("datype" =>$_POST["datype"],"kindofpackages" =>$_POST["kindofpackages"]);
			$this->db->insert('kindofpackages' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Kind of packages added successfully!.');
				return redirect(base_url().'masters/kindofpackages');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/kindofpackages');
			}
		}
		
	}	
				
	
	
	//product
	public function product($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getProduct();
			$this->load->view('header');
			$this->load->view('masters/product', $data);
			$this->load->view('footer');
		}
	}
	
	
	public function product_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // despatchto 	
		$data = array("datype" =>$_POST["datype"],"product" =>$_POST["product"],"hscode" =>$_POST["hscode"]) ;
		$this->Datype_model->addproduct($data);*/

		$post = $this->input->post();

        $this->form_validation->set_rules('product', 'product' , 'required|is_unique[product.product]');
        $this->form_validation->set_rules('datype', 'da type' , 'required');
        $this->form_validation->set_rules('hscode', 'hs code' , 'required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getProduct();
				$this->load->view('header');
				$this->load->view('masters/product', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array("datype" =>$post["datype"],"product" =>$post["product"],"hscode" =>$post["hscode"]);
			$this->db->insert('product' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Product added successfully!.');
				return redirect(base_url().'masters/product');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/product');
			}
		}

		
	}	
	
	
		
	
	
	//transportmodetocha
	public function transportmodetocha($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getTransportmodetocha();
			$this->load->view('header');
			$this->load->view('masters/transportmodetocha', $data);
			$this->load->view('footer');
		}
	}
	
	
	public function transportmodetocha_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // transportmodetocha 	
		$data = array("transportmodetocha" =>$_POST["transportmodetocha"]) ;
		$this->Datype_model->addtransportmodetocha($data);*/


		$post = $this->input->post();
        
        $this->form_validation->set_rules('transportmodetocha', 'transport mode to cha' , 'required|is_unique[transportmodetocha.transportmodetocha]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getTransportmodetocha();
				$this->load->view('header');
				$this->load->view('masters/transportmodetocha', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('transportmodetocha' => $post['transportmodetocha']);
			$this->db->insert('transportmodetocha' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Transpost mode added successfully!.');
				return redirect(base_url().'masters/transportmodetocha');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/transportmodetocha');
			}
		}
		
	}	
	
	
	//marketingperson
	public function marketingperson($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getMarketingperson();
			$this->load->view('header');
			$this->load->view('masters/marketingperson', $data);
			$this->load->view('footer');
		}
	}
	
	
	public function marketingperson_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // marketingperson 	
		$data = array("marketingperson" =>$_POST["marketingperson"]) ;
		$this->Datype_model->addmarketingperson($data);*/

		$post = $this->input->post();
        
        $this->form_validation->set_rules('marketingperson', 'marketing person' , 'required|is_unique[marketingperson.marketingperson]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getMarketingperson();
				$this->load->view('header');
				$this->load->view('masters/marketingperson', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('marketingperson' => $post['marketingperson']);
			$this->db->insert('marketingperson' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Marketing person added successfully!.');
				return redirect(base_url().'masters/marketingperson');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/marketingperson');
			}
		}
		
	}	
	
	
	
	//productgrade
	public function productgrade($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getProductgrade();
			$this->load->view('header');
			$this->load->view('masters/productgrade', $data);
			$this->load->view('footer');
		}
	}
	
	
	public function productgrade_add() {
		
		$this->load->model('Datype_model');
		//  This will set the query data
		/*$data=array();
		 // productgrade 	
		$data = array(productgrade) ;
		$this->Datype_model->addproductgrade($data);*/

		$post = $this->input->post();
        
        $this->form_validation->set_rules('productgrade', 'product grade' , 'required|is_unique[productgrade.productgrade]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getProductgrade();
				$this->load->view('header');
				$this->load->view('masters/productgrade', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('productgrade' => $post['productgrade']);
			$this->db->insert('productgrade' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Product grade added successfully!.');
				return redirect(base_url().'masters/productgrade');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/productgrade');
			}
		}
		
	}	
	
	
	
	//paymentterms
	public function paymentterms($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getPaymentterms();
			$this->load->view('header');
			$this->load->view('masters/paymentterms', $data);
			$this->load->view('footer');
		}
	
	}
	
	
	public function paymentterms_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // deliveryterm 	
		$data = array("paymentterms" =>$_POST["paymentterms"]) ;
		$this->Datype_model->addpaymentterms($data);*/

		$post = $this->input->post();
        
        $this->form_validation->set_rules('paymentterms', 'payment term' , 'required|is_unique[paymentterms.paymentterms]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getPaymentterms();
				$this->load->view('header');
				$this->load->view('masters/paymentterms', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array ('paymentterms' => $post['paymentterms']);
			$this->db->insert('paymentterms' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Payment term added successfully!.');
				return redirect(base_url().'masters/paymentterms');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/paymentterms');
			}
		}
		
	}	
	
	
	
	
	// Country view 
	
	public function country($page=null, $adminid=0) {
		if ($this->Admin_model->verifyUser()) {
			$this->load->model('Datype_model');
			$data["admins"] = $this->Datype_model->getCountry();
			$this->load->view('header');
			$this->load->view('masters/country', $data);
			$this->load->view('footer');
		}
	}
	
	
	public function country_add() {
		
		/*$this->load->model('Datype_model');
		//  This will set the query data
		$data=array();
		 // country , territory
		$data = array("country" =>$_POST["country"], "territory" =>$_POST["territory"]) ;
		$this->Datype_model->addcountry($data);*/

        $post = $this->input->post();
        
        $this->form_validation->set_rules('country', 'country' , 'required|is_unique[country.country]');
        $this->form_validation->set_rules('territory', 'territory' , 'required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');

		if(!empty($post) && $this->form_validation->run() ==FALSE) {
			    
			    $this->session->set_flashdata('error', 'Validation error. Please check the form.');
			    $this->load->model('Datype_model');
				$data["admins"] = $this->Datype_model->getCountry();
				$this->load->view('header');
				$this->load->view('masters/country', $data);
				$this->load->view('footer');
           
		}  else {
            
			$table_array = array("country" =>$_POST["country"], "territory" =>$_POST["territory"]);
			$this->db->insert('country' , $table_array);
			$inserted = $this->db->insert_id();
			if(!empty($inserted)) {
				$this->session->set_flashdata('success', 'Country added successfully!.');
				return redirect(base_url().'masters/country');
			} else {
				$this->session->set_flashdata('error', 'Technical error!.');
				return redirect(base_url().'masters/country');
			}
		}




		
	}	
}
