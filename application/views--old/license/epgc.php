<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">License</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method() ?>">Manage EPCG License</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <i class=""></i>
      <b>EPCG License Form</b>
   </div>
    <div class="card-block">
      <?php $id = !empty($findOne) ? '/'.$findOne['id'] : ''?>
    <form action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().$id ?>" method="POST">

      <div class="row">

        <div class="col-md-6 form-group">
          <label>EPCG License No:</label>
          <input type="text" name="license_no" id="license_no" class="form-control" placeholder="Enter license number" value="<?= set_value('license_no', !empty($findOne['lic_no']) ? $findOne['lic_no']: '' ) ?>" >
           <?= form_error('license_no') ?>
        </div>

        <div class="col-md-6 form-group">
          <label>Dated:</label>
          <input type="text" name="license_date" id="<?= !empty($findOne) ? 'license_date-1' :'license_date' ?>" class="form-control" placeholder="" value="<?= set_value('license_date', !empty($findOne['lic_date']) ? nice_date($findOne['lic_date'], 'd-M-Y' ) : '') ?>" >
           <?= form_error('license_date') ?>
        </div>

      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>EO Fixed: <small class="text-danger">(In USD)</small></label>
          <input type="text" name="qty" id="ecgc" class="form-control" placeholder="Enter amount" value="<?= set_value('qty' , !empty($findOne['qty']) ? $findOne['qty']: '') ?>" >
           <?= form_error('qty') ?>
        </div>
        <div class="col-md-6 form-group">
          <label>EO Valid Upto:</label>
          <input type="text" name="expiry_date" id="<?= !empty($findOne) ? 'expiry_date-1' :'expiry_date' ?>" class="form-control" placeholder="" value="<?= set_value('expiry_date' , !empty($findOne['expiry_date']) ? nice_date($findOne['expiry_date'], 'd-M-Y' ) : '') ?>" >
           <?= form_error('expiry_date') ?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-5">
         <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;<?= !empty($findOne) ? 'Update' : 'Submit' ?></button>
          <?php if(!empty($findOne)) { 
             echo anchor($this->router->fetch_class().'/'.$this->router->fetch_method(), '<i class="fa fa-refresh"></i>&nbsp;Refresh', 'class="btn btn-warning"');
           } ?>
        </div>
      </div>
  
    </form>

   </div>
</div>

<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>EPCG License Listing</b>
   </div>
   <div class="card-block">
  
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable1" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>EPCG License No</th>
                  <th>Dated</th>
                  <th>EO Fixed IN USD</th>
                  <th>EO Valid Upto</th>
                  <th>EO Balance</th>
                  <th>Commercial Inv. No.</th>
                  <th>Date</th>
                  <th>Action</th>
                
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>EPCG License No</th>
                  <th>Dated</th>
                  <th>EO Fixed IN USD</th>
                  <th>EO Valid Upto</th>
                  <th>EO Balance</th>
                  <th>Commercial Inv. No.</th>
                  <th>Date</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($epgc)) {
                      $counter = 0;
                      foreach ($epgc as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["lic_no"] ?></td>
                  <td><?= nice_date($value["lic_date"], 'Y-M-d' ) ?></td>
                  <td><?= $value["qty"] ?></td>
                  <td><?= nice_date($value["expiry_date"], 'Y-M-d' ) ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$value['id']?>"><i data-toggle="tooltip" data-placement="top" title="Edit EPGC License" class="fa fa-pencil text-warning" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    
                  </td> 
               
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>


   </div>
</div>