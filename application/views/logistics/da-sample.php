<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Logistics</li>
   <li class="breadcrumb-item">DA Sample Listing</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>DA Sample Listing</b>
   </div>
       <div class="card-block">
            <a href="<?= base_url().'logistics/da_sample_add'?>" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;New</a>
            <a href="<?= base_url().'logistics/da_sample'?>" class="btn btn-warning"><i class="fa fa-search"></i>&nbsp;Find</a>
            
      </div>
</div>

<div class="card mb-3">
   <div class="card-block">

      <form method="POST" action="<?= base_url().'logistics/da_sample'?>">

         <div class="form-group">
            <label>Buyer:</label>
            <select name="buyer" class="form-control" id="buyer">
               <option value="">Select Buyer to show listing</option>
               <?php if(!empty($buyers)) {
                  foreach($buyers as $buyer) { ?>
                     <option value="<?= $buyer['id']?>"><?= $buyer['party'] ?></option>
                  <?php } } ?>
            </select>
         </div>
           
         <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>&nbsp;Search</button>
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
                  <th>Created At</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Buyer</th>
                  <th>DA No.</th>
                  <th>Created At</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($da_sample)) {
                      $counter = 0;
                      foreach ($da_sample as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["party"] ?></td>
                  <td><?= $value["da_no"] ?></td>
                  <td><?= nice_date($value['created_at'], 'Y-M-d') ?></td>
                  <td>
                     <a href="<?= base_url().'logistics/da_sample_edit/'.$value['id'] ?>" data-toggle="tooltip" data-placement="top" title="Edit DA"><i class="fa fa-pencil text-warning" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                     <a href="<?= base_url().'logistics/view_sample_da/'.$value['id'] ?>" data-toggle="tooltip" data-placement="top" title="View DA"><i class="fa fa-eye text-success" aria-hidden="true"></i></a>
                 
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>