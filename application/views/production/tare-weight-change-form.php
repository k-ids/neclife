<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class() ?>">Production</a></li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class().'/tare_weight_change' ?>">Packing List Tare Weight Change</a> </li>
    <li class="breadcrumb-item">Form</li>


   </li>
</ol>
<!-- Example Tables Card -->

<div class="alert alert-info">
  <strong>Info!</strong>&nbsp;Packing list to change tare weight.
</div>

<div class="card mb-3">
  <div class="card-block">
        <div class="row">
            <div class="col-md-6">
              <label>DA Finanacial Year:</label>
              <?= $da_header['financial_year'] ?>
            </div>
            <div class="col-md-6">
              <label>DA No:</label>
              <?= $da_header['da_no'] ?>
            </div>
            <div class="col-md-6">
              <label>Buyer:</label>
              <?= $da_header['buyer_name'] ?>
            </div>
            <div class="col-md-6">
              <label>DA Type:</label>
              <?= $da_header['datype_name'] ?>
            </div>

            <div class="col-md-6">
              <label>Created By:</label>
              <?= !empty($packing_list[0]['created_by']) ? $packing_list[0]['created_by'] :'---' ?>
            </div>
            
            <div class="col-md-6">
              <label>Product Form:</label>
              <?= $packing_list[0]['productform'] ?>
            </div>
            <div class="col-md-12">
              <label>Production Remarks:</label>
              <?= $packing_list[0]['production_remarks'] ?>
            </div>

        </div>
  </div>
</div>
<div class="card mb-3">
   <div class="card-block">
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
               <tr>
                  <th>S.No</th>
                  <th>Packing Type</th>
                  <th>Excise Sr No</th>
                  <th>Batch No</th>
                  <th>Container No</th>
                  <th>Seal No</th>
                  <th>Inner Tare Weight</th>
                  <th>Outer Tare Weight</th>
                  <th>Net Weight</th>
                  <th>Inner Gross Weight</th>
                  <th>Outer Gross Weight</th>
                  <th>Mfg Date</th>
                  <th>Exp Date</th>
                  <th>ReTest Date</th>
                  <th>Dimensions</th>
                  <th>Pallet Dimensions</th>
                  <th>Pallet Gross Weight </th>
                  <th>Pallet No</th>
                  <th>New Inner Tare Weight</th>
                  <th>New Outer Tare Weight</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>S.No</th>
                  <th>Packing Type</th>
                  <th>Excise Sr No</th>
                  <th>Batch No</th>
                  <th>Container No</th>
                  <th>Seal No</th>
                  <th>Inner Tare Weight</th>
                  <th>Outer Tare Weight</th>
                  <th>Net Weight</th>
                  <th>Inner Gross Weight</th>
                  <th>Outer Gross Weight</th>
                  <th>Mfg Date</th>
                  <th>Exp Date</th>
                  <th>ReTest Date</th>
                  <th>Dimensions</th>
                  <th>Pallet Dimensions</th>
                  <th>Pallet Gross Weight </th>
                  <th>Pallet No</th>
                  <th>New Inner Tare Weight</th>
                  <th>New Outer Tare Weight</th>
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
                  <td><?= $value["kindofpackages"] ?></td>
                  <td><?= $value['excise_sr_no']?></td>
                  <td><?= $value["batch_no"] ?></td>
                  <td><?= $value['container_no'] ?></td>
                  <td><?= $value["seal_no"] ?></td>
                  <td style="background: #d6e7b0;"><?= $value["inner_tare_weight"] ?></td>
                  <td style="background: #d6e7b0;"><?= $value["outer_tare_weight"] ?></td>
                  <td><?= $value["net_weight"] ?></td>
                  <td><?= $value["inner_gross_weight"] ?></td>
                  <td><?= $value["outer_gross_weight"] ?></td>
                  <td><?= $value["mfg_date"] ?></td>
                  <td><?= $value["exp_date"] ?></td>
                  <td><?= $value["rate_st_date"] ?></td>
                  <td><?= $value["dimensions"] ?></td>
                  <td><?= $value["pallet_dimensions"] ?></td>
                  <td><?= $value["pallet_gross_weight"] ?></td>
                  <td><?= $value["pallet_no"] ?></td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="new_inner_tare_weight" class="form-control" id="new-inner-weight-<?= $value['id'] ?>" value="" >
                    </div>
                        
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="new_outer_tare_weight" class="form-control" id="new-outer-weight-<?= $value['id'] ?>" value="">
                    </div>
                  </td>
                    <td>
                      <button class="btn btn-success" id="tare-weight-form-<?= $value['id']?>" data-id="<?= $value['id']?>"><i class="fa fa-floppy-o"></i>&nbsp;Update</button>
                     
                  </td>
                  <input type="hidden" name="net_weight" value="<?= $value['net_weight'] ?>" id="net-weight-<?= $value['id']?>">
               </tr>
                 <?php }  } ?> 
            </tbody>
         </table>
      </div>
   </div>
</div>
