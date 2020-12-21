<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">License</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method() ?>">Declaration</a></li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <i class=""></i>
      <b>Declaration</b>
   </div>
    <div class="card-block">
      <?php $id = !empty($findOne) ? '/'.$findOne['id'] : ''?>
    <form action="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().$id ?>" method="POST">

      <div class="row">

        <div class="col-md-6 form-group">
          <label>Declaration:</label>
           <textarea placeholder="Enter declaration" class="form-control" name="declaration" rows="4" cols="4" required><?= set_value('declaration', !empty($findOne['declaration']) ? $findOne['declaration']: '' ) ?></textarea>
           <?= form_error('declaration') ?>
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
      <i class="fa fa-table" style="color: green;"></i> <b>EPCG License Listing</b>
   </div>
   <div class="card-block">
  
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Declaration</th>
                  <th>Action</th>
                
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Declaration</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($declaration)) {
                      $counter = 0;
                      foreach ($declaration as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["declaration"] ?></td>
                  <td>
                    <a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$value['id']?>"><i data-toggle="tooltip" data-placement="top" title="Edit EPGC License" class="fa fa-pencil text-warning" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                  </td> 
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>


   </div>
</div>