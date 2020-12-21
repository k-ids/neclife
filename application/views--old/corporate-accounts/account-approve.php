<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Corporate Accounts</li>
   <li class="breadcrumb-item">DA Accounts Approve</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>DA Accounts Approve</b>
   </div>
</div>

<div class="alert alert-info">
  <strong>Info!</strong> Listing of all DA for Account Approve.
</div>

<div class="card mb-3">
   <div class="card-block">

      <form method="POST" action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method()?>">

         <div class="form-group">
            <label>Buyer:</label>
            <select name="buyer" class="form-control" id="buyer">
               <option value="">Select buyer to show listing</option>
               <?php if(!empty($buyers)) {
                  foreach($buyers as $buyer) { ?>
                     <option value="<?= $buyer['id']?>"><?= $buyer['party'] ?></option>
                  <?php } } ?>
            </select>
         </div>
           
         <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Search</button>
         <a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method()?>" class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp;Refresh</a>

      </form>
   </div>
</div>

<div class="card mb-3">
   <div class="card-block">
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>DA Date</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>DA Date</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($da_entry)) {
                      $counter = 0;
                      foreach ($da_entry as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["party"] ?></td>
                  <td><?= $value["da_no"] ?></td>
                  <td><?= nice_date($value['da_date'], 'Y-M-d') ?></td>
                  <td>
                     <?php if(empty($value['cancelled_by'])) { ?>
                        <a href="<?= base_url().'corporateaccount/da_account_approve_form/'.$value['id'] ?>" class="btn btn-info"><i class="fa fa-recycle"></i>&nbsp;Select</a>
                      <?php } else { ?>
                      <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Cancelled</button>
                     <?php } ?>
                     
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>