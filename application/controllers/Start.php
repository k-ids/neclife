<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Start extends CI_Controller {

	public function index()
	{ 
		if ($this->Admin_model->verifyUser()) {

			      $data['pageTitle'] = 'Neclife- Admin | Dashboard';
            $data['template']  = 'welcome_message';
            $this->load->view('template_admin',$data);
		} 
		
	}

	public function set_session() {
		$post  = $this->input->post();
          if(!empty($post)) {

          	$this->session->set_userdata('financial_year', $post['f_year']);
          	if($this->session->userdata('financial_year')) {
          		$this->session->set_flashdata('success', 'Financial year '.$this->session->userdata('financial_year').' set successfully!.');
          	} else {
          		$this->session->set_flashdata('error', 'Something went wrong. Please try again.');
          	}
          	return redirect($_SERVER['HTTP_REFERER']);
          }
	}
    

  public function save_download()
  { 
    //load mPDF library
    $this->load->library('mpdf');
    //load mPDF library


    //now pass the data//
     $this->data['title']="MY PDF TITLE 1.";
     $this->data['description']="";
     $this->data['description']= 'ada';
     //now pass the data //

    
    $html= $this->load->view('logistics/da-copy/account-copy', $this->data , true); //load the pdf_output.php by passing our data and get all data in $html varriable.
   
    //this the the PDF filename that user will get to download
    $pdfFilePath ="mypdfName-".time()."-download.pdf";

    
    //actually, you can pass mPDF parameter on this load() function
    $pdf = $this->mpdf->load();
    //generate the PDF!
    $pdf->WriteHTML($html,2);
    //offer it to user via browser download! (The PDF won't be saved on your server HDD)
    $pdf->Output($pdfFilePath, "D");
     
      
  }
  

}
