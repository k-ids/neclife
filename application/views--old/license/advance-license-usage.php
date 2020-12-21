<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">License</li>
   <li class="breadcrumb-item active"><a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method() ?>">Manage Advance License</a></li>
</ol>
<div class="card mb-3">
   <div class="card-block">
      <div style="float:left;">
          <a href="<?= base_url().$this->router->fetch_class().'/advance_license' ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i>&nbsp;Go Back</a>
      </div>    
   </div>
</div>

<div class="card mb-3">
   <div class="card-block">
       <div class="row">
          <div class="col-md-4">
            <label>License No:&nbsp;</label><?= $license['lic_no'] ?>
          </div>
           <div class="col-md-4">
            <label>Date:&nbsp;</label><?= $license['qty'] ?> Kg
          </div>
           <div class="col-md-4">
            <label>Total Qty:&nbsp;</label><?= $license['lic_date'] ?>
          </div>
       </div><br>
       <div class="row">
          <div class="col-md-6">
            <label>File No:</label>
          </div>
           <div class="col-md-3">
            <label>Dated:</label><?= date('d.m.Y') ; ?>
          </div>
           <div class="col-md-3">
            <label>Exp:</label>
          </div>
       </div><br>
       <div class="row">
          <div class="col-md-8">
            <label>Product Name:&nbsp;</label><?= $license['product_name']?>
          </div>
       </div>
   </div>
</div>

<div class="card mb-3">
   <div class="card-block">

 <div class="table-responsive">

    <table class="table" style="width: 120% !important; max-width: 120% !important;">
        <thead class="thead-dark" style="background: yellowgreen;">
          <tr>
              <th scope="col">Sr.No</th>
              <th scope="col">Party Name</th>
              <th scope="col">DA No.</th>
              <th scope="col">QTY Planned</th>
              <th scope="col">QTY Despatched</th>
              <th scope="col">Balance QTY</th>
              <th scope="col">Common Inv. No</th>
              <th scope="col">Date</th>
              <th scope="col">Excise Inv. No.</th>
              <th scope="col">Date</th>
              <th scope="col">Month</th>
          </tr>
        </thead>
        <tbody>
             <?php 
              if(!empty($advance_license)) {
                      $counter = 0;
                      foreach ($advance_license as $value) { 
                        $percentage = (($value['eo_fulfilled']) / ($value['qty'])) * 100;
                      ?>
               <tr>
                  <td><?= ++$counter; ?></td>
                  <td><?= $value["lic_no"] ?></td>
                  <td><?= nice_date($value['lic_date'], 'd.m.y' ) ?></td>
                  <td><?= $value['product_name']?></td>
                  <td><?= $value['qty'] ?> Kgs</td>
                  <td><?= $value['eo_fulfilled'] ?></td>
                  <td><?= ( ($value['qty']) - ($value['eo_fulfilled'])) ?></td>
                  <td style="font-weight: bold;"><?= nice_date($value['expiry_date'], 'd.m.y' ) ?></td>
                  <td><?= $value['automatice_extended_eo'] ?></td>
                  <td><?= $value['remarks']?></td>
                  <td><?= number_format((float)$percentage, 2, '.', '') . '%';  ?></td>
                 
                  <td>
                    <a href="<?= base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/'.$value['id']?>"><i data-toggle="tooltip" data-placement="top" title="Edit Advance License" class="fa fa-pencil text-warning" aria-hidden="true"></i></a>&nbsp;&nbsp;
                    <a href=""><i data-toggle="tooltip" data-placement="top" title="Licesne Usage" class="fa fa-plug text-success" aria-hidden="true"></i></a>
                  </td> 
               
               </tr>
              <?php }  ?>
                 <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                 </tr>
              <?php } ?>
        </tbody>
       
      </table>
       <?php if(empty($advance_license)) { ?>
              <h5 class="text-center text-danger">No data available.</h5>
      <?php  } ?>
</div>


   </div>
</div>