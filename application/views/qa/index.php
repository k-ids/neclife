<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class() ?>">QA</a></li>
   <li class="breadcrumb-item">Packing List Check/ Uncheck</li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>Packing List Check/ Uncheck

</b>
   </div>
</div>

<div class="alert alert-info">
  <strong>Info!</strong> Listing of all packing list for Check/ Uncheck.
</div>

<div class="card mb-3">
   <div class="card-block">

      <form method="POST" action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method()?>">
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
           
         <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Search</button>
         <a href="" class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp;Refresh</a>

      </form>
   </div>
</div>

<div class="card mb-3">
   <div class="card-block">
      <div class="table-responsive">
         <table class="table table-bordered packing-list-table" width="250%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>DA Financial Year</th>
                  <th>DA No.</th>
                  <th>Buyer</th>
                  <th>Department</th>
                  <th>Product</th>
                  <th>Product Form</th>
                  <th>Grade</th>
                  <th>DA Qty</th>
                  <th>Packing List Date</th>
                  <th>Packing List Time</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>DA Financial Year</th>
                  <th>DA No.</th>
                  <th>Buyer</th>
                  <th>Department</th>
                  <th>Product</th>
                  <th>Product Form</th>
                  <th>Grade</th>
                  <th>DA Qty</th>
                  <th>Packing List Date</th>
                  <th>Packing List Time</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($packing_list)) {
                      $counter = 0;
                      foreach ($packing_list as $value) { ?>
                        <tr>
                           <td><?= ++$counter; ?></td>
                           <td><?= $value["da_financial_year"] ?></td>
                           <td><?= $value['daname']?></td>
                           <td><?= $value["party"] ?></td>
                           <td><?= $value['department_name'] ?></td>
                           <td><?= $value["product_name"] ?></td>
                           <td><?= $value["productform"] ?></td>
                           <td><?= $value["productgrade"] ?></td>
                           <td><?= $value["total_qty_in_list"] ?></td>
                           <td><?= nice_date($value["packing_list_date"], 'd-M-Y' )?></td>
                           <td><?= $value["packing_list_time"] ?></td>
                           <td><a class="btn btn-primary" href="<?= base_url().$this->router->fetch_class().'/packing_list_plant_check_form/'.$value['da_no'].'/'.$value['product_form']?>"><i class="fa fa-refresh"></i>&nbsp;Select</td>
                        </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>
