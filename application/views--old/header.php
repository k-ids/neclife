<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title><?= isset($pageTitle) ? $pageTitle : 'Neclife - Admin' ?></title>
      <link rel="shortcut icon" href="<?=base_url()?>resources/image/logo.jpg?>" />
      <!-- Bootstrap core CSS -->
      <link href="<?=base_url()?>resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom fonts for this template -->
      <link href="<?=base_url()?>resources/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <!-- Plugin CSS -->
      <link href="<?=base_url()?>resources/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
      <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
      <!-- Custom styles for this template -->
      <link href="<?=base_url()?>resources/css/sb-admin.css" rel="stylesheet">
     <!--  <link href="<?=base_url()?>resources/css/da-view.css" rel="stylesheet"> -->
      <link href="<?=base_url()?>resources/css/my-custom.css" rel="stylesheet">
      <script type="text/javascript">
         document.onreadystatechange = function () {
           var state = document.readyState
           if (state == 'interactive') {
            document.getElementById('contents').style.visibility="hidden";
          } else if (state == 'complete') {
           setTimeout(function(){
            document.getElementById('interactive');
            document.getElementById('load').style.visibility="hidden";
            document.getElementById('contents').style.visibility="visible";
          },1000);
         }
         }
          var baseUrl = "<?php echo base_url(); ?>";
      </script>
   </head>
   <body id="page-top" >
      <?php  
         $f_years = getFinancialYears('financialyear_model');  
         if(empty($f_years)) {
           $this->session->set_userdata('financial_year', date('Y')- date('Y')+1);
         }    
         ?>
      <!-- Modal -->
      <?php if(!empty($f_years) && empty($this->session->userdata('financial_year'))) {?>
      <div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" style="top:6pc !important;">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header" style="background: yellowgreen !important;">
                  <h4 class="modal-title text-center" style="width: 100%;">Choose Financial Year</h4>
               </div>
               <div class="modal-body">
                  <h5 class="text-center">Please select Financial year to proceed further.</h5>
                  <p class="text-center text-info">No Changes are possible on previous financial year.</p>
                  <form method="POST" action="<?= base_url().'start/set_session'?>">
                     <div class="form-group">
                        <label></label>
                        <select class="form-control" name="f_year" id="f_year">
                           <?php if(!empty($f_years)) {
                              foreach($f_years as $value) { ?>
                           <option value="<?= $value['financial_year']?>"><?= $value['financial_year']?></option>
                           <?php  
                              }
                              } ?>
                        </select>
                     </div>
               </div>
               <div class="modal-footer">
               <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Select</button>
               </form>
               <a  data-toggle="tooltip" data-placement="top" title="Won't proceed furhter? Click me" class="btn btn-danger" href="<?= base_url().'logout'?>"><i class="fa fa-fw fa-sign-out"></i>&nbsp;Logout</a>
               </div>
            </div>
         </div>
      </div>
      <?php } ?>
      <div id="load"></div>
      <!-- Navigation -->
      <nav id="mainNav" class="navbar static-top navbar-toggleable-md navbar-inverse bg-inverse">
         <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarExample" aria-controls="navbarExample" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <a class="navbar-brand" href="<?= base_url()?>"><span style="color:orange;">Nectar&nbsp;</span><span style="color:#9c2ef0; font-weight: 500;padding-left: 0px !important;">Lifesciences</span></a>
         <div class="collapse navbar-collapse" id="navbarExample">
            <?php $role = $this->session->userdata('role'); ?>
            <ul class="sidebar-nav navbar-nav">
               <li class="nav-item <?= !empty($this->router->fetch_class()=='start') ? 'active': '' ?>">
                  <a class="nav-link" href="<?=base_url()?>"><i style="color:orange;" class="fa fa-fw fa-dashboard"></i> Dashboard </a>
               </li>
               <?php 
                 if($role == 1 || $role ==2 || $role == 3 ) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='masters') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='masters') ? 'menu-class': '' ?>" data-toggle="collapse" href="#masters"><i style="color:gold;" class="fa fa-meetup" aria-hidden="true"></i> Masters</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='masters') ? 'show': '' ?>" id="masters">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='datype' || $this->router->fetch_method()=='add_da_type') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/datype"> DA Type</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='customer' || $this->router->fetch_method()=='customer_add' || $this->router->fetch_method() =='customer_edit') )? 'sub-menu-class' : ''?>" href="<?=base_url()?>masters/customer"> Customer</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='currency' || $this->router->fetch_method()=='currency_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/currency"> Currency</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='shipmentmode' || $this->router->fetch_method()=='shipmentmode_add')) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/shipmentmode"> Shipment Mode</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='documentsrequired' || $this->router->fetch_method()=='documentsrequired_add')) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/documentsrequired"> Documents Required</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='agent' || $this->router->fetch_method() =='agent_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/agent"> Agent</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='territory' || $this->router->fetch_method() =='territory_add') )? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/territory"> Territory</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='country' || $this->router->fetch_method() =='country_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/country"> Country</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='deliveryterm'|| $this->router->fetch_method()=='deliveryterm_add')) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/deliveryterm"> Delivery Term</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='paymentterms' || $this->router->fetch_method()=='paymentterms_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/paymentterms"> Payment Terms</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='label' || $this->router->fetch_method()=='label_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/label"> Label</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='despatchto' || $this->router->fetch_method()=='despatchto_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/despatchto"> Despatch To</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='transportmodetocha' || $this->router->fetch_method()=='transportmodetocha_add')  ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/transportmodetocha"> Transport Mode To CHA</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='kindofpackages' || $this->router->fetch_method()=='kindofpackages_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/kindofpackages"> Kind of Packages</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='product' || $this->router->fetch_method()=='product_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/product"> Products</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='productform' || $this->router->fetch_method()=='productform_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/productform"> Product Form</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='productgrade' || $this->router->fetch_method()=='productgrade_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/productgrade"> Product Grade</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='masters' && ($this->router->fetch_method()=='marketingperson' || $this->router->fetch_method()=='marketingperson_add') ) ? 'sub-menu-class' : ''?>"href="<?=base_url()?>masters/marketingperson"> Marketing Person</a>
                     </li>
                  </ul>
               </li>
            <?php } ?>
               <?php
                  if($role == 1 || $role ==2 || $role == 3 || $role==4 || $role ==5 || $role == 6 || $role == 9 || $role == 10 || $role == 11 || $role == 12 || $role == 13 || $role == 14 || $role ==15 || $role ==16  || $role ==17 || $role == 7 || $role == 8 ) {
                ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='logistics') ? 'menu-bg-class': '' ?>">
                 
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='logistics') ? 'menu-class': '' ?>" data-toggle="collapse" href="#logistics"><i style="color:green;" class="fa fa-tasks" aria-hidden="true"></i>&nbsp;Logistics</a>
                  
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='logistics') ? 'show': '' ?>" id="logistics">
                     <?php if($role == 1 || $role == 2 || $role == 3) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='index' || $this->router->fetch_method()=='da_entry' || $this->router->fetch_method()=='edit_da_entry' || $this->router->fetch_method()=='view_da' || $this->router->fetch_method()=='da_attachment') )? 'sub-menu-class' : ''?>" href="<?=base_url()?>logistics">&nbsp;DA Entry</a>
                     </li>
                     <?php } ?>
                     <?php if($role == 1 || $role == 2 || $role == 3) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' &&( $this->router->fetch_method()=='da_sample' || $this->router->fetch_method()=='da_sample_add' || $this->router->fetch_method()=='da_sample_edit' || $this->router->fetch_method()=='view_sample_da') )? 'sub-menu-class' : ''?>" href="<?=base_url() .'logistics/da_sample' ?>">&nbsp;DA Sample</a>
                     </li>
                  <?php } ?>
                     <?php if($role == 1 || $role == 3) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='da_check' ) || $this->router->fetch_method()=='da_check_form' )? 'sub-menu-class' : ''?>" href="<?=base_url() .'logistics/da_check' ?>">&nbsp;DA Check</a>
                     </li>
                    <?php } ?>
                    <?php if($role == 1 || $role ==4) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='da_approve' || $this->router->fetch_method()== 'da_approve_form') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/da_approve'?>">&nbsp;DA Approve</a>
                     </li>
                     <?php } ?>

                     <?php if($role == 1 || $role == 5) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='da_final_approve' || $this->router->fetch_method()=='da_final_approve_form') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/da_final_approve'?>">&nbsp;DA Final Approve</a>
                     </li>
                     <?php } ?>

                     <?php if($role == 1 || $role == 2 || $role == 3) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='da_revised' || $this->router->fetch_method()=='revised_da') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/da_revised'?>">&nbsp;DA Revised</a>
                     </li>
                     <?php } ?>
                     <?php if($role == 1 || $role == 2 || $role == 3) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='da_cancel' || $this->router->fetch_method() == 'da_cancel_form') )? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/da_cancel'?>">&nbsp;DA Cancel</a>
                     </li>
                     <?php } ?>
                     <?php if($role == 1 || $role == 2 || $role == 3) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='da_plant_despatch_date' || $this->router->fetch_method() == 'da_plant_despatch_date_form') )? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/da_plant_despatch_date'?>">&nbsp;Plant Despatch Date</a>
                     </li>
                     <?php } ?>
                     <?php if($role == 1 || $role == 2 || $role == 3) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && $this->router->fetch_method()=='da_register')? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/da_register'?>">&nbsp;DA Register</a>
                     </li>
                      <?php } ?>
                     <?php if($role == 1 || $role ==6) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='bussiness_manager_check_da' || $this->router->fetch_method()=='bussiness_manager_check_da_form' ) )? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/bussiness_manager_check_da'?>">&nbsp;Bussiness Manager Check DA</a>
                     </li>
                  <?php } ?>
                    <?php  if( $role ==1 || $role ==2 || $role ==3 || $role ==4 || $role==5 || $role == 6 || $role ==9 || $role == 10 || $role == 11 || $role == 12  || $role == 7 ) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='da_account' || $this->router->fetch_method()=='da_account_copy' ) )? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/da_account'?>">&nbsp;DA Account Copy</a>
                     </li>
                  <?php } ?>

                  <?php  if($role ==1 || $role ==2 || $role ==3 || $role ==4 || $role==5 || $role == 6 || $role == 14 || $role ==15 || $role ==16  || $role ==17 || $role == 8 || $role == 13) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='da_plant' || $this->router->fetch_method()=='da_plant_copy' ) )? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/da_plant'?>">&nbsp;DA Plant Copy</a>
                     </li>
                     <?php } ?>
                     <?php  if($role ==1 || $role ==2 || $role ==3 || $role ==4 || $role==5 || $role == 6 || $role == 13 || $role ==14 || $role ==15 || $role ==16  || $role ==17 || $role == 7 || $role == 8 ) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='packing_list' || $this->router->fetch_method() =='packing_list_view' )) ? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/packing_list'?>">&nbsp;Packing List</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='view_packing_list_raw' || $this->router->fetch_method()=='packing_list_view_raw' ))? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/view_packing_list_raw'?>">&nbsp;Packing List Raw Data</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='logistics' && ($this->router->fetch_method()=='gsk_packing_list' || $this->router->fetch_method()=='gsk_packing_list_view' ))? 'sub-menu-class' : ''?>" href="<?=base_url().'logistics/gsk_packing_list'?>">&nbsp;GSK Packing List</a>
                     </li>
                  <?php } ?>
                  </ul>
               </li>
               <?php } ?>
                
               <?php if($role == 1 || $role ==2 || $role ==3) { ?>

               <li class="nav-item <?= !empty($this->router->fetch_class()=='commercial_invoice') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='commercial_invoice') ? 'menu-class': '' ?>" data-toggle="collapse" href="#commercial_invoice"><i style="color:#fff;" class="fa fa-files-o" aria-hidden="true"></i>&nbsp;Invoice</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='commercial_invoice') ? 'show': '' ?>" id="commercial_invoice">
                     <li>
                         <a class="<?= !empty($this->router->fetch_class()=='commercial_invoice' && ($this->router->fetch_method()=='index' || $this->router->fetch_method()== 'generate_invoice' || $this->router->fetch_method()=='download_invoice'|| $this->router->fetch_method() =='update_invoice') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'commercial_invoice' ?>">&nbsp;Commercial Invoice</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='commercial_invoice' && ($this->router->fetch_method()=='packing_list_invoice' || $this->router->fetch_method()=='generate_packing_invoice' || $this->router->fetch_method()=='update_packing_invoice' || $this->router->fetch_method()== 'download_packing_invoice' || $this->router->fetch_method()=='update_packinglist_invoice') )? 'sub-menu-class' : ''?>" href="<?=base_url().'commercial_invoice/packing_list_invoice' ?>">&nbsp;Packing List</a>
                     </li>
                    
                   
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='commercial_invoice' && ($this->router->fetch_method()=='gsk_packing_invoice' || $this->router->fetch_method()=='generate_gsk_invoice' || $this->router->fetch_method() =='update_gsk_invoice'  || $this->router->fetch_method() =='download_gsk_invoice') )? 'sub-menu-class' : ''?>" href="<?=base_url().'commercial_invoice/gsk_packing_invoice' ?>">&nbsp;GSK Packing-Invoice</a>
                     </li>
                     

                  </ul>
               </li>

               <?php } ?>
               
               <?php if($role == 1 || $role == 9) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='license') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='license') ? 'menu-class': '' ?>" data-toggle="collapse" href="#license"><i style="color:#9c2ef0;" class="fa fa-id-card-o" aria-hidden="true"></i>&nbsp;License</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='license') ? 'show': '' ?>" id="license">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='license' && $this->router->fetch_method()=='advance_license' ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'license/advance_license' ?>">&nbsp;Advance License</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='license' && ($this->router->fetch_method()=='epgc' || $this->router->fetch_method()=='license_usage')) ? 'sub-menu-class' : ''?>" href="<?=base_url().'license/epgc' ?>">&nbsp;EPCG License</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='license' && $this->router->fetch_method()=='declaration' ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'license/declaration' ?>">&nbsp;Declaration</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='license' && ($this->router->fetch_method()=='da_license_check' || $this->router->fetch_method()=='da_license_check_form' ) ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'license/da_license_check' ?>">&nbsp;DA License Check</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='license' && $this->router->fetch_method()=='advance_license_consumption' ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'license/advance_license_consumption' ?>">&nbsp;Advance License <br>&nbsp;Consumption</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='license' && $this->router->fetch_method()=='epgc_license_consumption' ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'license/epgc_license_consumption' ?>">&nbsp;EPGC License Consumption</a>
                     </li>
                  </ul>
               </li>
               <?php } ?>

               <?php if($role == 1 || $role == 10) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='inhouseaccount') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='inhouseaccount') ? 'menu-class': '' ?>" data-toggle="collapse" href="#inhouseaccount"><i style="color:#03cffc;" class="fa fa-home" aria-hidden="true"></i>&nbsp;In House Accounts</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='inhouseaccount') ? 'show': '' ?>" id="inhouseaccount">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='inhouseaccount' && $this->router->fetch_method()=='ecgc' ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'inhouseaccount/ecgc' ?>">&nbsp;ECGC Options</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='inhouseaccount' && ($this->router->fetch_method()=='ecgc_check' || $this->router->fetch_method()=='ecgc_check_form') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'inhouseaccount/ecgc_check' ?>">&nbsp;ECGC Check</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='inhouseaccount' && ($this->router->fetch_method()=='payment_receiving' ||  $this->router->fetch_method() == 'history') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'inhouseaccount/payment_receiving' ?>">&nbsp;Payment Receiving</a>
                     </li>
                     <!-- <li>
                        <a class="<?= !empty($this->router->fetch_class()=='inhouseaccount' && $this->router->fetch_method()=='mis' ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'inhouseaccount/mis' ?>">&nbsp;MIS</a>
                     </li> -->
                  </ul>
               </li>
               <?php } ?> 

               <?php if($role == 1 || $role == 11 || $role == 12) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='corporateaccount') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='corporateaccount') ? 'menu-class': '' ?>" data-toggle="collapse" href="#corporateaccount"><i style="color:#32a87b;" class="fa fa-list" aria-hidden="true"></i>&nbsp;Corporate Accounts</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='corporateaccount') ? 'show': '' ?>" id="corporateaccount">
                     <?php if($role == 1 || $role == 11) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='corporateaccount' && ($this->router->fetch_method()=='da_outstanding_check' || $this->router->fetch_method()=='da_outstanding_check_form'))  ? 'sub-menu-class' : ''?>" href="<?=base_url().'corporateaccount/da_outstanding_check' ?>">&nbsp;Outstanding Check</a>
                     </li>
                     <?php }?>
                     <?php  if($role ==1 || $role == 12) { ?>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='corporateaccount' && ($this->router->fetch_method()=='da_account_approve' || $this->router->fetch_method()=='da_account_approve_form') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'corporateaccount/da_account_approve' ?>">&nbsp;Accounts Approve</a>
                     </li>
                  <?php } ?>
                  </ul>
               </li>
               <?php } ?>
                
               <?php if($role == 1 || $role == 14) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='production') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='production') ? 'menu-class': '' ?>" data-toggle="collapse" href="#production"><i style="color:#fff;" class="fa fa-product-hunt" aria-hidden="true"></i>&nbsp;Production</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='production') ? 'show': '' ?>" id="production">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='production' && ($this->router->fetch_method()=='packing_list' || $this->router->fetch_method()=='add_packing_list' || $this->router->fetch_method()=='add_packing_list_form') )  ? 'sub-menu-class' : ''?>" href="<?=base_url().'production/packing_list' ?>">&nbsp;Manage Packing List</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='production' && ($this->router->fetch_method()=='tare_weight_change' || $this->router->fetch_method()=='tare_weight_change_form' ) )? 'sub-menu-class' : ''?>" href="<?=base_url().'production/tare_weight_change' ?>">&nbsp;Tare Weight Change</a>
                     </li>

                    
                      <li>
                        <a class="<?= !empty($this->router->fetch_class()=='production' && ($this->router->fetch_method()=='gsk' || $this->router->fetch_method()=='manage_gsk_packing') )? 'sub-menu-class' : ''?>" href="<?=base_url().'production/gsk' ?>">&nbsp;Manage GSK Packing</a>
                     </li>
                  
                  </ul>
               </li>
               <?php } ?>

               <?php if($role == 1 || $role == 13) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='ppic') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='ppic') ? 'menu-class': '' ?>" data-toggle="collapse" href="#ppic"><i style="color:#e019ab;" class="fa fa-pied-piper-pp" aria-hidden="true"></i>&nbsp;PPIC</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='ppic') ? 'show': '' ?>" id="ppic">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='ppic' && $this->router->fetch_method()=='index' ) ? 'sub-menu-class' : ''?>" href="<?=base_url()?>ppic">&nbsp;Assign DA</a>
                     </li>

                      <li>
                        <a class="<?= !empty($this->router->fetch_class()=='ppic' && $this->router->fetch_method()=='reassign_da' ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'ppic/reassign_da' ?>">&nbsp;Re-Assign DA</a>
                     </li>
                  </ul>
               </li>
               <?php } ?>

               <?php if($role == 1 || $role == 15 ) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='qualityassurance') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='qualityassurance') ? 'menu-class': '' ?>" data-toggle="collapse" href="#qualityassurance"><i style="color:#32a6a8;" class="fa fa-thermometer-quarter" aria-hidden="true"></i>&nbsp;QA</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='qualityassurance') ? 'show': '' ?>" id="qualityassurance">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='qualityassurance' && ($this->router->fetch_method()=='packing_list_plant_check'  || $this->router->fetch_method() =='packing_list_plant_check_form' ) )? 'sub-menu-class' : ''?>" href="<?=base_url().'qualityassurance/packing_list_plant_check' ?>">&nbsp;Packing List<br>&nbsp;Check/Uncheck</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='qualityassurance' && ($this->router->fetch_method()=='packing_list_plant_qa_approve' || $this->router->fetch_method()=='packing_list_plant_qa_approve_form') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'qualityassurance/packing_list_plant_qa_approve' ?>">&nbsp;Packing List Approval</a>
                     </li>
                     
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='qualityassurance' && ($this->router->fetch_method()=='gsk_packing_list' || $this->router->fetch_method()== 'gsk_packing_check_uncheck') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'qualityassurance/gsk_packing_list' ?>">&nbsp;GSK Packing Check/Uncheck</a>
                     </li>

                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='qualityassurance' && ($this->router->fetch_method()=='gsk_packing_approval' || $this->router->fetch_method()== 'gsk_packing_approval_form') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'qualityassurance/gsk_packing_approval' ?>">&nbsp;GSK Packing Approval</a>
                     </li>
                     
                  </ul>
               </li>
               <?php } ?>
               
               <?php if($role == 1 || $role ==16) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='managerqa') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='managerqa') ? 'menu-class': '' ?>" data-toggle="collapse" href="#managerqa" ><i style="color:#fff;" class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Manager QA</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='managerqa') ? 'show': '' ?>" id="managerqa">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='managerqa' && ($this->router->fetch_method()=='packing_list_manager_qa_approve' || $this->router->fetch_method()=='packing_list_manager_qa_approve_form')   )? 'sub-menu-class' : ''?>" href="<?=base_url().'managerqa/packing_list_manager_qa_approve' ?>">&nbsp;QA Approved Packing List</a>
                     </li>
                     
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='managerqa' && ($this->router->fetch_method()=='gsk_packing_list' || $this->router->fetch_method()=='gsk_packing_approval')   )? 'sub-menu-class' : ''?>" href="<?=base_url().'managerqa/gsk_packing_list' ?>">&nbsp;QA Approved GSK</a>
                     </li>
                    

                  </ul>
               </li>
               <?php } ?>
                
               <?php if($role == 1 || $role ==17) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='excise') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='excise') ? 'menu-class': '' ?>" data-toggle="collapse" href="#excise"><i style="color:#fc5603;" class="fa fa-sort-numeric-asc" aria-hidden="true"></i>&nbsp;Excise</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='excise') ? 'show': '' ?>" id="excise">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='excise' && ($this->router->fetch_method()=='index' || $this->router->fetch_method()=='invoice_entry') )? 'sub-menu-class' : ''?>" href="<?=base_url().'excise'?>">&nbsp;Excise Invoice Entry</a>
                     </li>
                  </ul>
               </li>
               <?php } ?>


               <li class="nav-item <?= !empty($this->router->fetch_class()=='utilities') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='ppic') ? 'menu-class': '' ?>" data-toggle="collapse" href="#utilities"><i style="color:#e6252b;" class="fa fa-wrench" aria-hidden="true"></i>&nbsp;Utilities</a>
                  
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='utilities') ? 'show': '' ?>" id="utilities">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='utilities' && $this->router->fetch_method()=='change_password' ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'utilities/change_password' ?>">&nbsp;Change Password</a>
                     </li>
                      <li>
                        <a class="<?= !empty($this->router->fetch_class()=='utilities' && $this->router->fetch_method()=='contact_admin' ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'utilities/contact_admin' ?>">&nbsp;Support</a>
                     </li>
                  </ul>
               </li>

               <?php if($this->session->userdata('role') == 1) { ?>
               <li class="nav-item <?= !empty($this->router->fetch_class()=='administrator') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='administrator') ? 'menu-class': '' ?>" data-toggle="collapse" href="#administrator"><i style="color:#25e658;" class="fa fa-unlock" aria-hidden="true"></i>&nbsp;Administrator</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='administrator') ? 'show': '' ?>" id="administrator">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='administrator' && ($this->router->fetch_method()=='index' || $this->router->fetch_method()=='create_user' || $this->router->fetch_method()=='edit_user') ) ? 'sub-menu-class' : ''?>" href="<?=base_url()?>administrator">&nbsp;Users</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='administrator' && ($this->router->fetch_method()=='department' ||  $this->router->fetch_method()=='create_department' ||  $this->router->fetch_method()=='edit_department') ) ? 'sub-menu-class' : ''?>" href="<?=base_url().'administrator/department'?>">&nbsp;Department</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='administrator' && $this->router->fetch_method()=='audit_trial') ? 'sub-menu-class' : ''?>" href="<?=base_url().'administrator/audit_trial' ?>">&nbsp;Audit Trial</a>
                     </li>
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='administrator' && ($this->router->fetch_method()=='financial_year'|| $this->router->fetch_method() =='edit_financial_year' ) ) ? 'sub-menu-class' : ''?>" href="<?=base_url()?>administrator/financial_year">&nbsp;Financial Year</a>
                     </li>
                  </ul>
               </li>
               
               <li class="nav-item <?= !empty($this->router->fetch_class()=='siteconfig') ? 'menu-bg-class': '' ?>">
                  <a class="nav-link nav-link-collapse collapsed <?= !empty($this->router->fetch_class()=='siteconfig') ? 'menu-class': '' ?>" data-toggle="collapse" href="#siteconfig"><i style="color:#fff;" class="fa fa-cogs" aria-hidden="true"></i>&nbsp;Site Config</a>
                  <ul class="sidebar-second-level collapse <?= !empty($this->router->fetch_class()=='siteconfig') ? 'show': '' ?>" id="siteconfig">
                     <li>
                        <a class="<?= !empty($this->router->fetch_class()=='siteconfig' && $this->router->fetch_method()=='datype_address') ? 'sub-menu-class' : ''?>" href="<?=base_url()?>siteconfig">&nbsp;DA Address</a>
                     </li>
                  </ul>
               </li>
               <?php } ?>
            </ul>
            <ul class="navbar-nav ml-auto">
               <!--      <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="messagesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-fw fa-envelope"></i> <span class="hidden-lg-up">Messages <span class="badge badge-pill badge-primary">12 New</span></span>
                      <span class="new-indicator text-primary hidden-md-down"><i class="fa fa-fw fa-circle"></i><span class="number">12</span></span>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                      <h6 class="dropdown-header">New Messages:</h6>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">
                          <strong>David Miller</strong> <span class="small float-right text-muted">11:21 AM</span>
                          <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">
                          <strong>Jane Smith</strong> <span class="small float-right text-muted">11:21 AM</span>
                          <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">
                          <strong>John Doe</strong> <span class="small float-right text-muted">11:21 AM</span>
                          <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item small" href="#">
                          View all messages
                      </a>
                  </div>
                  </li>
                  <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle mr-lg-2" href="#" id="alertsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-fw fa-bell"></i> <span class="hidden-lg-up">Alerts <span class="badge badge-pill badge-warning">6 New</span></span>
                      <span class="new-indicator text-warning hidden-md-down"><i class="fa fa-fw fa-circle"></i><span class="number">6</span></span>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                  </li> -->
               <!--    <li class="nav-item">
                  <form class="form-inline my-2 my-lg-0 mr-lg-2">
                      <div class="input-group">
                          <select class="form-control">
                            <option></option>
                          </select>
                          <span class="input-group-btn">
                      <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                  </span>
                      </div>
                  </form>
                  </li> -->
               <li class="nav-item">
                  <a class="nav-link" href="javascript::void(0)" data-toggle="modal" data-target="#exampleModalLong"><i data-toggle="tooltip" data-placement="bottom" title="Basic information" class="fa fa-user-secret text-success" aria-hidden="true"></i></a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>logout"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
               </li>
            </ul>
         </div>
      </nav>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Basic Information</h5>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <img src="<?=base_url()?>resources/image/index.png" alt="logo image" style="display: block; margin: auto;">
                  </div>
                  <div class="row">
                     <p style="display: block; margin: auto; margin-top: 2pc;"><b>Financial year:</b>&nbsp; <?= !empty($this->session->userdata('financial_year')) ? $this->session->userdata('financial_year') : '' ?></p>
                     <p style="display: block; margin: auto; margin-top: 2pc;"><b>Username:</b>&nbsp; <?= !empty($this->session->userdata('username')) ? $this->session->userdata('username') : '' ?></p>

                     
                     
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <div class="content-wrapper py-3" style="min-height: 100vh !important;">
      <div class="container-fluid">