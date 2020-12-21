<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Administrator</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().'administrator/audit_trial' ?>">Audit Trial</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <b>Audit Trial</b>
   </div>
    <div class="card-block">
    <form action="<?= base_url().'administrator/audit_trial' ?>" method="POST">
      <div class="row">

        <div class="col-md-5 form-group">
          <label>From Date:</label>
          <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From date" value="<?= set_value('from_date') ?>">
          <?= form_error('from_date') ?>
        </div>

        <div class="col-md-5 form-group">
          <label>Upto Date:</label>
          <input type="text" name="upto_date" id="upto_date" class="form-control" placeholder="Upto date" value="<?= set_value('upto_date') ?>">
          <?= form_error('upto_date') ?>
        </div>

      </div>

      <div class="row">
        <div class="col-md-5">
         <button type="submit" class="btn btn-success"><i class="fa fa-eye"></i> View</button>
       </div>
      </div>
  
    </form>

   </div>
</div>

<?php if(!empty($result)) { ?>
<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>Audit Trial Data</b>
   </div>
   <div class="card-block">
    
   
        <p>
          <b>Search Criteria:</b> 
          From:&nbsp;<?= $search['from'] ?> To:&nbsp;<?= $search['upto'] ?> 
        </p>
     

      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable1" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>User</th>
                  <th>Activity</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>User</th>
                  <th>Activity</th>
                  
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($result)) {
                      $counter = 0;
                      foreach ($result as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["transaction_date"] ?></td>
                  <td><?= $value["transaction_time"] ?></td>
                  <td><?= $value["username"] ?></td>
                  <td><?= $value["action"] ?></td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>


   </div>
</div>

 <?php } ?>