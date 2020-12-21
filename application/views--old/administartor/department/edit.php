<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Administrator</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().'administrator/department' ?>">Department</a></li>
   <li class="breadcrumb-item">Edit Department</li>
</ol>
<!-- Example Tables Card -->

<div class="card mb-3">

   <div class="card-header">
      <i class="fa fa-keyboard-o" style="color: green;"></i>&nbsp;<b>Edit Department</b>
      <p class="text-danger pull-right">All fields are mandatory.</p>
   </div>

   <div class="card-block">
      <form method="POST"  action="<?=base_url().'administrator/edit_department/'.$department['id']?>">
      
         <div class="form-group">   
            <label for="email">Department:</label>
            <input type="text" name="department" class="form-control" placeholder="Enter department name" id="department" value="<?= set_value('department' , $department['department'])?>">  
            <?= form_error('department') ?>
         </div>

         <div class="form-group">   
            <label for="email">DA Type:</label>
            <select class="form-control" name="da_type" id="da_type">
               <option value="">Select one</option>
               <?php if(!empty($da_types)) {
                  foreach ($da_types as $key => $value) { ?>

                     <option value="<?= $value['id'] ?>" <?php if($department['da_type'] ==$value['id']) { echo "selected"; } ?>><?= $value['datype'] ?> </option>

               <?php  }
               } ?>
            </select>  
            <?= form_error('da_type') ?>
         </div>

         <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Submit</button>
            <?= anchor('administrator/department', 'Cancel', 'class="btn btn-warning"') ?>
        </div>
      </form>
   </div>
</div>