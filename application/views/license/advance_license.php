<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">License</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method() ?>">Manage Advance License</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <i class=""></i>
      <b>Advance License Form</b>
   </div>
    <div class="card-block">
      <?php $id = !empty($findOne) ? '/'.$findOne['id'] : ''?>
    <form action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().$id ?>" method="POST">

      <div class="row">
      
        <div class="col-md-6 form-group">
          <label>Advance License No:</label>
          <input type="text" name="license_no" id="license_no" class="form-control" placeholder="Enter license number" value="<?= set_value('license_no', !empty($findOne['lic_no']) ? $findOne['lic_no']: '' ) ?>" required>
           <?= form_error('license_no') ?>
        </div>
        <div class="col-md-6 form-group">
          <label>Qty:</label>
          <input type="text" name="qty" id="ecgc" class="form-control" placeholder="Enter quantity" value="<?= set_value('qty' , !empty($findOne['qty']) ? $findOne['qty']: '') ?>" required>
           <?= form_error('qty') ?>
        </div>
      </div>

      <div class="row">
         <div class="col-md-6 form-group">
          <label>DA Type:</label>
          <select class="form-control" name="da_type_lic" id="datype" required>
              <option value="">Select one</option>
              <?php if(!empty($da_types)) {
                     foreach ($da_types as  $value) { ?>
                      <option value="<?= $value['id'] ?>" <?php if(!empty($findOne) && $findOne['da_type'] == $value['id']) { echo "selected"; }?>><?= $value['datype'] ?></option>
                   <?php     
                     }
                  }
              ?>
          </select>
          <?= form_error('da_type_lic') ?>
         </div>

         <div class="col-md-6 form-group">
            <label>Product:</label>
            <select class="form-control lic-product" name="product" required>
               <option></option>
              <?php if(!empty($products)) { 
                foreach ($products as $value) { ?>
                   <option value="<?= $value['id'] ?>" <?php if($value['id']== $findOne['product']) { echo "selected"; } ?> ><?= $value['product'] ?></option>
              <?php   }
               }
               ?>
            </select>
            <?= form_error('product') ?>
         </div>

      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>License Date:</label>
          <input type="text" name="license_date" id="<?= !empty($findOne) ? 'license_date-1' :'license_date' ?>" class="form-control" placeholder="" value="<?= set_value('license_date', !empty($findOne['lic_date']) ? nice_date($findOne['lic_date'], 'd-M-Y' ) : '') ?>" required>
           <?= form_error('license_date') ?>
        </div>
        <div class="col-md-6 form-group">
          <label>Expiry Date:</label>
          <input type="text" name="expiry_date" id="<?= !empty($findOne) ? 'expiry_date-1' :'expiry_date' ?>" class="form-control" placeholder="" value="<?= set_value('expiry_date' , !empty($findOne['expiry_date']) ? nice_date($findOne['expiry_date'], 'd-M-Y' ) : '') ?>" required>
           <?= form_error('expiry_date') ?>
        </div>
      </div>

      <div class="row">
         <div class="col-md-6 form-group">
             <label>Remark:</label>
             <textarea class="form-control" name="remarks" cols="4" rows="4" required><?= !empty($findOne['remarks']) ? $findOne['remarks'] : ''?></textarea>
             <?= form_error('remarks') ?>
         </div>

          <div class="col-md-6 form-group">
             <label>EO Extended Date:<small>(Optional)</small></label>
             <input type="text" name="automatice_extended_eo" class="form-control eo_extend_date">
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
      <i class="fa fa-table" style="color: green;"></i> <b>Advance License Listing</b>
   </div>
   <div class="card-block">
  
      <div class="table-responsive">
         <table class="table table-bordered" width="150%" id="dataTable1" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Advance License No</th>
                  <th>Date</th>
                  <th>Product</th>
                  <th>Total Obligations</th>
                  <th>EO Fulfilled</th>
                  <th>Balance EO</th>
                  <th>Validity EO</th>
                  <th>EO Extended</th>
                  <th>Remarks</th>
                  <th>%</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Advance License No</th>
                  <th>Date</th>
                  <th>Product</th>
                  <th>Total Obligations</th>
                  <th>EO Fulfilled</th>
                  <th>Balance EO</th>
                  <th>Validity EO</th>
                  <th>EO Extended</th>
                  <th>Remarks</th>
                  <th>%</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($advance_license)) {
                      $counter = 0;
                      foreach ($advance_license as $value) { 
                        $percentage = (($value['eo_fulfilled']) / ($value['qty'])) * 100;
                      ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["lic_no"] ?></td>
                  <td><?= nice_date($value['lic_date'], 'd.m.y' ) ?></td>
                  <td><?= $value['product_name']?></td>
                  <td><?= $value['qty'] ?> Kgs</td>
                  <td><?= $value['eo_fulfilled'] ?></td>
                  <td><?= ( ($value['qty']) - ($value['eo_fulfilled'])) ?></td>
                  <td style="font-weight: bold;"><?= nice_date($value['expiry_date'], 'd.m.y' ) ?></td>
                  <td><?= $value['automatice_extended_eo'] ?></td>
                  <td><?= $value['remarks']?></td>
                  <td><?= number_format((float)$percentage, 2, '.', '') . '%';  ?></td>
                 
                  <td>
                    <a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$value['id']?>"><i data-toggle="tooltip" data-placement="top" title="Edit Advance License" class="fa fa-pencil text-warning" aria-hidden="true"></i></a>&nbsp;&nbsp;
                    <a href="<?= base_url().$this->router->fetch_class().'/license_usage/'.$value['id'] ?>"><i data-toggle="tooltip" data-placement="top" title="Licesne Usage" class="fa fa-plug text-success" aria-hidden="true"></i></a>
                  </td> 
               
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>


   </div>
</div>