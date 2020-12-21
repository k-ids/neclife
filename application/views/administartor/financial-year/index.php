<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Administrator</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().'administrator/financial_year' ?>">Financial year</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <i class=""></i>
      <b>Add Financial year</b>
   </div>
    <div class="card-block">
    <form action="<?= base_url().'administrator/financial_year' ?>" method="POST">
      <div class="row">
        
        <div class="col-md-4 form-group">
          <label>Financial Year:</label>
          <input type="text" name="financial_year" id="financial_year" class="form-control" placeholder="Enter Financial year" value="<?= set_value('financial_year') ?>">
          <?= form_error('financial_year') ?>
        </div>

        <div class="col-md-4 form-group">
          <label>Start Date:</label>
          <input type="text" name="from_date" id="from_date" class="form-control"  placeholder="From date" value="<?= set_value('from_date') ?>">
          <?= form_error('from_date') ?>
        </div>

        <div class="col-md-4 form-group">
          <label>End Date:</label>
          <input type="text" name="upto_date" id="upto_date" class="form-control" placeholder="Upto date" value="<?= set_value('upto_date') ?>">
          <?= form_error('upto_date') ?>
        </div>

      </div>

      <div class="row">
        <div class="col-md-5">
         <button type="submit" class="btn btn-success">Submit</button>
         <?= anchor('administrator/financial_year', 'Cancel' , 'class="btn btn-warning"') ?>
       </div>
      </div>
  
    </form>

   </div>
</div>

<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>Financial years listing</b>
   </div>
   <div class="card-block">
  
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Financial Year</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Action</th>
                
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Financial Year</th>
                  <th>Start Date</th>
                  <th>End Date</th>
				   <th>Action</th>
                  
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($result)) {
                      $counter = 0;
                      foreach ($result as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["financial_year"] ?></td>
                  <td><?= $value["financial_year_start"] ?></td>
                  <td><?= $value["financial_year_end"] ?></td>
                  <td>
                    <a class="text-center" href="<?= base_url().'administrator/edit_financial_year/'.$value['id'] ?>" data-toggle="tooltip" data-placement="top" title="Edit financial year" alt=edit-financial-year>
                      <i class="fa fa-pencil text-warning"></i>
                    </a>
                   
                  </td> 
               
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>


   </div>
</div>