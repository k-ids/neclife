<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Production</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class().'/packing_list'?>">Packing List(New) - Plant</a></li>
   <li class="breadcrumb-item">Add</li>

   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>Packing List(New) - Plant</b>
   </div>
</div>

<div class="card mb-3">
    <div class="card-block">
          
          <div class="row">

            <div class="col-md-6">
              <label>DA Finanacial Year:</label>
              <?= $da_header['financial_year'] ?>
            </div>

            <div class="col-md-6">
              <label>DA No:</label>
              <?= $da_header['da_no'] ?>
            </div>

            <div class="col-md-6">
              <label>Party:</label>
              <?= $da_header['buyer_name'] ?>
            </div>
            
            <div class="col-md-6">
              <label>DA Type:</label>
              <?= $da_header['datype_name'] ?>
            </div>
            
          </div>

    </div>
</div>
<div class="alert alert-info">
  <strong>Info!</strong> DA Items listing of DA "<b><?= $da_header['da_no'] ?>" to add-edit packing list entry</b>
</div>
<div class="card mb-3">
   <div class="card-block">
      <div class="table-responsive">
         <table class="table table-bordered" width="150%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Product</th>
                  <th>Product Form</th>
                  <th>Grade</th>
                  <th>Packing Type</th>
                  <th>DA Qty</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Product</th>
                  <th>Product Form</th>
                  <th>Grade</th>
                  <th>Packing Type</th>
                  <th>DA Qty</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($da_items)) {
                      $counter = 0;
                      foreach ($da_items as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["product_name"] ?></td>
                  <td><?= $value["productform"] ?></td>
                  <td><?= $value["productgrade"] ?></td>
                  <td><?= $value['kindofpackages'] ?></td>
                   <td><?= $value['quantity'] ?></td>
                  <td>
                      <a href="<?= base_url().$this->router->fetch_class().'/add_packing_list_form/'.$da_header['id'].'/'.$value['id'] ?>" class="btn btn-info"><i class="fa fa-recycle"></i>&nbsp;Select</a>
                     
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>