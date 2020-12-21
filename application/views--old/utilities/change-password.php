<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Utilities</li>
   <li class="breadcrumb-item">Change Password</li>

   </li>
</ol>


<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>Change Password</b>
   </div>
  <div class="card-block">
     <?php echo form_open($this->router->fetch_class().'/change_password');?>

         <div class="row">
          <div class="col-md-6 form-group">
              <?= form_label('Current password:', 'currentpassword') ?>
              <?= form_password(['name'=>'currentpassword','id'=>'password','class'=>'form-control','value'=>set_value('currentpassword')]) ?>
              <?= form_error('currentpassword') ?>
          </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
               <?= form_label('New password:', 'password') ?>
               <?= form_password(['name'=>'password','id'=>'password','class'=>'form-control','value'=>set_value('password')]) ?>
               <?= form_error('password') ?>
            </div>
        </div>

        <div class="row">
          <div class="col-md-6 form-group">
              <?= form_label('Confirm password:', 'confirmpassword') ?>
              <?= form_password(['name'=>'confirmpassword','id'=>'confirmpassword','class'=>'form-control','value'=>set_value('confirmpassword')]) ?>
              <?= form_error('confirmpassword') ?>
          </div>
        </div>

       <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>

      <?php echo form_close();?>
    </div>
</div>

