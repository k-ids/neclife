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
      <b>Edit Financial year</b>
   </div>
    <div class="card-block">
    <form action="<?= base_url().'administrator/edit_financial_year/'.$f_year['id'] ?>" method="POST">
      <div class="row">
        
        <div class="col-md-4 form-group">
          <label>Financial Year:</label>
          <input type="text" name="financial_year" id="financial_year" class="form-control" placeholder="Enter Financial year" value="<?= set_value('financial_year', $f_year['financial_year'] ) ?>">
          <?= form_error('financial_year') ?>
        </div>

        <div class="col-md-4 form-group">
          <label>Start Date:</label>
          <input type="text" name="from_date" id="from_date_1" class="form-control"  placeholder="From date" value="<?= set_value('from_date', nice_date($f_year['financial_year_start'], 'd-M-Y')) ?>">
          <?= form_error('from_date') ?>
        </div>

        <div class="col-md-4 form-group">
          <label>End Date:</label>
          <input type="text" name="upto_date" id="upto_date_1" class="form-control" placeholder="Upto date" value="<?= set_value('upto_date', nice_date($f_year['financial_year_end'],'d-M-Y') ) ?>">
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

