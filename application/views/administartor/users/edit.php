<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Administrator</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().'administrator' ?>">Users</a></li>
   <li class="breadcrumb-item">Edit user</li>
</ol>
<!-- Example Tables Card -->

<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-user" style="color: green;"></i>&nbsp;<b>Add User</b>
   </div>
   <div class="card-block">
        <?= anchor('administrator/create_user', '<i class="fa fa-plus"></i> Edit User', 'class="btn btn-success"') ?>
        <?= anchor('administrator', '<i class="fa fa-search"></i> Find', 'class="btn btn-warning"') ?>
         <p class="text-danger pull-right">All fields are mandatory except signature.</p>
   </div>
</div>

<div class="card mb-3">
   <div class="card-block">
     
      <form method="POST"  action="<?=base_url().'administrator/edit_user/'.$user['id'] ?>" enctype="multipart/form-data">
        
      <div class="row">
         <div class="form-group col-md-6">
            <label for="email">Employee Code:</label>
            <input type="text" name="emp_code" class="form-control" placeholder="Employee Code" id="emp_code" value="<?= set_value('emp_code' , $user['emp_code']) ?>">
            <?= form_error('emp_code') ?>
         </div>

         <div class="form-group col-md-6">   
            <label for="email">Email: <small class="text-danger">(Email must be unique.)</small></label>
            <input type="email" name="email" class="form-control" placeholder="Enter valid email address" id="email" value="<?= set_value('email', $user['email'])?>">  
            <?= form_error('email') ?>
         </div>
      </div>

      <div class="row">
         <div class="form-group col-md-6">
            <label for="email">First name:</label>
            <input type="text" name="first_name" class="form-control" placeholder="Enter First name" id="first_name" value="<?= set_value('first_name', $user['first_name']) ?>">
            <?= form_error('first_name') ?>
         </div>

         <div class="form-group col-md-6">   
            <label for="email">Last name:</label>
            <input type="text" name="last_name" class="form-control" placeholder="Enter Last name" id="last_name" value="<?= set_value('last_name' , $user['last_name'])?>">  
            <?= form_error('last_name') ?>
         </div>

      </div>

      <div class="row">
         <div class="form-group col-md-6">   
            <label for="email">Userame:</label>
            <input type="text" name="name" class="form-control" placeholder="Enter name" id="name" value="<?= set_value('name', $user['username'])?>">  
            <?= form_error('name') ?>
         </div>
         <div class="form-group col-md-6">   
            <label for="email">Role:</label>
            <select class="form-control" name="role" id="role">
               <option value="">Select one</option>
               <?php  if(!empty($roles)) {
                         foreach($roles as $value) { ?>
                           <option value="<?= $value['id'] ?>" <?php if($user['admin_group'] == $value['id']) { echo "selected"; } ?>><?= $value['role'] ?></option>
                         <?php }
                     }
               ?>
            </select>  
            <?= form_error('role') ?>
         </div>
      </div>
       
      <div class="row">
         <div class="form-group col-md-6">   
            <label for="email">DA Type:</label>
            <select class="form-control" name="da_type" id="da_type">
               <option value="">Select one</option>
               <?php if(!empty($da_types)) {
                  foreach ($da_types as $key => $value) { ?>

                     <option value="<?= $value['id'] .'-' .$value['datype'] ?>" <?php if($user['da_type'] == $value['id']) {echo "selected"; } ?>><?= $value['datype'] ?> </option>

               <?php  }
               } ?>
            </select>  
            <?= form_error('da_type') ?>
         </div>

         <div class="form-group col-md-6">   
            <label for="email">Department:</label>
            <select class="form-control" name="department" id="department">
               <option value="">Select one</option>
            </select>  
            <?= form_error('department') ?>
         </div>
      </div>
      <input type="hidden" name="db_department" id="db_department" value="<?= $user['department'] ?>">

      <div class="row">

         <div class="form-group col-md-6">   
            <label for="email">Upload Signature: <small class="text-danger">(<b>JPG | JPEG | PNG</b> are allowed mime types. <b>200 * 100</b> file dimension)</small></label>
             <input type="file" name="signature" class="form-control" id="employee-signature">
               <?php if($this->session->userdata('validation-error')) { ?>
                  <span class="text-danger"><?= $this->session->userdata('validation-error') ?></span>
               <?php  } ?>
               <img src="<?= !empty($user['signature']) ? base_url().'resources/employee-signature/'.$user['signature'] : base_url().'resources/employee-signature/dummy/Not_available_icon.jpg' ?>" alt="signature" style="width: 200px; height: 100px;">
              <div class="gallery"></div>

            <?//= form_error('signature') ?>
            <input type="hidden" name="db-image-name" value="<?= $user['signature'] ?>">
         </div>

      </div>


         <button type="submit" class="btn btn-primary">Submit</button>
         <?= anchor('administrator', 'Cancel', 'class="btn btn-warning"') ?>
      </form>
   </div>
</div>

