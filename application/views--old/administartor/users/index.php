<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item active"><a href="<?= base_url().'administrator' ?>">Administrator</a>
   <li class="breadcrumb-item">Users</li>
   </li>
</ol>
<!-- Example Tables Card -->
<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>USERS LISTING </b>
   </div>
   <div class="card-block">
      <?= anchor('administrator/create_user', '<i class="fa fa-plus"></i> Add User', 'class="btn btn-success"') ?>
   </div>
</div>


<div class="card mb-3">
  
   <div class="card-block">
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Emp Code</th>
                  <th>Name</th>
                  <th>DA Type</th>
                  <th>Department</th>
                  <th>Role</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                   <th>S.No</th>
                  <th>Emp Code</th>
                  <th>Name</th>
                  <th>DA Type</th>
                  <th>Department</th>
                  <th>Role</th>
                  <th>Action</th>
               </tr>
            </tfoot>
            <tbody>
               <?php 
                  if(!empty($users)) {
                      $counter = 0;
                      foreach ($users as $value) { ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["emp_code"] ?></td>
                  <td><?= $value["username"] ?></td>
                  <td><?= !empty($value["datype_name"]) ? $value["datype_name"]: '---N/A---' ?></td>
                  <td><?= !empty($value["dept_name"]) ? $value["dept_name"] : '---N/A---' ?></td>
                  <td><?= $value["role"] ?></td>
                  <td>
                     <a href="<?= base_url().'administrator/edit_user/'.$value["id"] ?>"  data-toggle="tooltip" data-placement="top" title="Edit user">
                        <i class="fa fa-pencil text-warning"></i>
                        
                     </a>&nbsp;|&nbsp; 
                     <a href="javascript:void(0)" id="delete-<?= $value["id"]?>" data-url="<?=base_url().'administrator/delete_user/'.$value["id"] ?>"  data-toggle="tooltip" data-placement="top" title="Delete user">
                        <i class="fa fa-trash text-danger"></i>
                    </a>
                  </td>
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>