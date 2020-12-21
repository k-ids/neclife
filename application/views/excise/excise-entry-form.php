<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item active">Logistics</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class()?>">DA Plant DA - Excise Invoice Entry</a></li>
</ol>
<!-- Example Tables Card -->

<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-dashcube" style="color: green;"></i>&nbsp;<b>DA - Excise Invoice Entry Form</b>
   </div>
      <div class="card-block">
  
            <a href="<?= base_url().$this->router->fetch_class()?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Go Back"><i class="fa fa-arrow-left"></i>&nbsp;Go Back</a>
      
      </div>
</div>
<div class="card mb-3">
 <div class="card-block">
   <p>Note:</p>
   <ul>
     <li class="text-success">The DA item prepared by: <b><?= $findone['prepared_by'] ?></b></li>
     <li class="text-info"> DA items for : <b><?= $findone['da_no'] ?></b></li>
   </ul>
 </div>
</div>


<div class="card mb-3">
  <div class="card-block">
     <div class="table-responsive">
         <table class="table table-bordered" width="150%" id="dataTable" cellspacing="0" style="table-layout: fixed;">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Product</th>
                  <th>HS Code</th>
                  <th>Product Form</th>
                  <th>Grade</th>
                  <th>Packing type</th>
                  <th>Quantity</th>
                  <th>Excise Invoice No</th>
                  <th>Are - I</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Product</th>
                  <th>HS Code</th>
                  <th>Product Form</th>
                  <th>Grade</th>
                  <th>Packing type</th>
                  <th>Quantity</th>
                  <th>Excise Invoice No</th>
                  <th>Are - I</th>
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
                  <td><?= $value['hscode'] ?></td>
                  <td><?= $value['productform'] ?></td>
                  <td><?= $value['productgrade'] ?></td>
                  <td><?= $value['kindofpackages'] ?></td>
                  <td><?= $value["quantity"] ?></td>
                  <form id="invoice-form">
                  <td>
                    <div class="form-group">
                      <input type="text" name="excise_invoice_no" class="form-control" id="excise_invoice_no-<?= $value['id'] ?>" value="<?= set_value('excise_invoice_no' ,isset($value['excise_invoice_no']) ? $value['excise_invoice_no'] : ''); ?>" >
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="areone" class="form-control" id="areone-<?= $value['id'] ?>" value="<?= set_value('areone', isset($value['areone']) ? $value['areone']: '') ?>" >
                    </div>
                  </td>
                  </form>
                  <td>
                      <button class="btn btn-success" id="invoice-form-<?= $value['id']?>" data-id="<?= $value['id']?>"><i class="fa fa-floppy-o"></i>&nbsp;Update</button>
                     
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
  </div>
</div>









