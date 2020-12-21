<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item active">Logistics</li>
   <li class="breadcrumb-item"><a href="<?= base_url().'logistics/da_plant_despatch_date'?>">DA Plant Despatch Date Entry Form</a></li>
</ol>
<!-- Example Tables Card -->

<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-dashcube" style="color: green;"></i>&nbsp;<b>DA Plant Despatch Date Entry Form</b>
   </div>
      <div class="card-block">
  
            <a href="<?= base_url().'logistics/da_plant_despatch_date'?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Go Back"><i class="fa fa-arrow-left"></i>&nbsp;Go Back</a>
      
      </div>
</div>
<div class="card mb-3">
 <div class="card-block">
   <p>Note:</p>
   <ul>
     <li class="text-success">The DA item prepared by: <b><?= getUserName($findone['prepared_by']) ?></b></li>
     <li class="text-info"> DA items for : <b><?= $findone['da_no'] ?></b></li>
   </ul>
 </div>
</div>


<div class="card mb-3">
  <div class="card-block">
     <div class="table-responsive">
         <table class="table table-bordered" width="150%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Product</th>
                  <th>HS Code</th>
                  <th>Product Form</th>
                  <th>Grade</th>
                  <th>Packing type</th>
                  <th>Quantity</th>
                  <th>Plant Despatch Date Tentative</th>
                  <th>Plant Despatch Date Actual</th>
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
                  <th>Plant Despatch Date Tentative</th>
                  <th>Plant Despatch Date Actual</th>
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
                  <form id="despatch-fomr">
                  <td>
                    <div class="form-group">
                      <input type="text" name="tentative_date" class="form-control tentative_date" id="tentative_date-<?= $value['id'] ?>" value="<?= isset($value['plant_despatched_date']) ? nice_date($value['plant_despatched_date'], 'd-M-Y') : '' ?>" >
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="actual_date" class="form-control actual_date" id="actual_date-<?= $value['id'] ?>" value="<?= isset($value['plant_despatched_date_actual']) ? nice_date($value['plant_despatched_date_actual'], 'd-M-Y'): '' ?>" >
                    </div>
                  </td>
                  </form>
                  <td>
                      <button class="btn btn-success" id="despatch-form-<?= $value['id']?>" data-id="<?= $value['id']?>"><i class="fa fa-floppy-o"></i>&nbsp;Update</button>
                     
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
  </div>
</div>









