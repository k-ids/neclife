<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Site Config</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method() ?>">Manage Address</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <i class=""></i>
      <b>Add Address</b>
   </div>
    <div class="card-block">
      <?php $id = !empty($findOne) ? '/'.$findOne['id'] : ''?>
    <form action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().$id ?>" method="POST">

      <div class="row">
        
        <div class="col-md-6 form-group">
          <label>DA Type:</label>
           <select class="form-control" name="da_type" id="da_type" required <?= !empty($findOne) ? 'readonly ': ''?>>
             <option value="">Select one</option>
             <?php if(!empty($da_types)) {
                    foreach($da_types as $key => $value) { 
                          if(!empty($findOne)) { 
                            if($findOne['da_type'] == $value['id']) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                          } else {
                                $selected = "";
                          }
                      ?>
                     <option value="<?= $value['id'] ?>" <?= $selected ?> > <?= $value['datype'] ?></option>
                <?php } } ?>
           </select>
           <?= form_error('da_type') ?>
        </div>

        <div class="col-md-6 form-group">
          <label>PAN Number:</label>
          <input type="text" name="pan_number" value="<?= set_value('pan_number', !empty($findOne['pan_no']) ? $findOne['pan_no']: '') ?>" class="form-control" required>
          <?= form_error('pan_number') ?>

        </div>
      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>I.E Code Number:</label>
          <input type="text" name="ie_code_no" value="<?= set_value('ie_code_no', !empty($findOne['ie_code_no']) ? $findOne['ie_code_no']: '') ?>" class="form-control" required>
           <?= form_error('ie_code_no') ?>
        </div>

        <div class="col-md-6 form-group">
           <label>CIN Number:</label>
          <input type="text" name="cin_number" value="<?= set_value('cin_number', !empty($findOne['cin_no']) ? $findOne['cin_no']: '') ?>" class="form-control" required>
           <?= form_error('cin_number') ?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>GST IN:</label>
          <input type="text" name="gstin" value="<?= set_value('gstin', !empty($findOne['gstin']) ? $findOne['gstin']: '') ?>" class="form-control" required>
           <?= form_error('gstin') ?>
        </div>
         
        <div class="col-md-6 form-group">
           <label>TIN Number:</label>
          <input type="text" name="tin_number" value="<?= set_value('tin_number', !empty($findOne['tin_number']) ? $findOne['tin_number']: '') ?>" class="form-control" required>
           <?= form_error('tin_number') ?>
        </div>
       
      </div>

      <div class="row">
           <div class="col-md-5 form-group">
             <label>State:</label>
            <input type="text" name="state" value="<?= set_value('state' , !empty($findOne['state']) ? $findOne['state']: '') ?>"  class="form-control" required>
             <?= form_error('state') ?>
          </div>
          <div class="col-md-2 form-group">
            <label>State Code:</label>
            <input type="text" name="state_code" value="<?= set_value('state_code', !empty($findOne['state_code']) ? $findOne['state_code']: '') ?>" class="form-control" required>
             <?= form_error('state_code') ?>
          </div>

          <div class="col-md-5 form-group">
             <label>State of origin:</label>
            <input type="text" name="state_of_origin" value="<?= set_value('state_of_origin' , !empty($findOne['state_of_origin']) ? $findOne['state_of_origin']: '') ?>" class="form-control" required>
             <?= form_error('state_of_origin') ?>
          </div>
      </div>

      <div class="row">
         <div class="col-md-6 form-group">
            <label>District Code:</label>
            <input type="text" name="district_code" value="<?= set_value('district_code' , !empty($findOne['district_code']) ? $findOne['district_code']: '') ?>"  class="form-control" required>
             <?= form_error('district_code') ?>
          </div>

          <div class="col-md-6 form-group">
             <label>District of origin:</label>
            <input type="text" name="district_of_origin" value="<?= set_value('district_of_origin', !empty($findOne['district_of_origin']) ? $findOne['district_of_origin']: '') ?>" class="form-control" required>
             <?= form_error('district_of_origin') ?>
          </div>
      </div>

      <div class="row">
        <div class="col-md-12 form-group">
          <label>Address&nbsp;<small class="text-danger">(Exporter/Manufacturer/Beneficiary - Name & Address:)</small></label>
          <textarea name="address" cols="5" rows="5" required><?= set_value('address' , !empty($findOne['address']) ? $findOne['address']: '') ?></textarea>
           <?= form_error('address') ?>
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
      <i class="fa fa-table" style="color: green;"></i> <b>Address Listing</b>
   </div>
   <div class="card-block">
  
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>DA Type</th>
                  <th>Address</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>DA Type</th>
                  <th>Address</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($address)) {
                      $counter = 0;
                      foreach ($address as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value['datype'] ?></td>
                  <td><?= $value['address'] ?></td>
                  <td>
                    <a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$value['id']?>"><i data-toggle="tooltip" data-placement="top" title="Update Address" class="fa fa-pencil text-warning" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  </td> 
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>