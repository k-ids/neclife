<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Production</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class().'/gsk'?>">GSK Packing List</a></li>
   <li class="breadcrumb-item">Manage</li>

   </li>
</ol>
<!-- Example Tables Card -->

<div class="card mb-3">
    <div class="card-block">
        <div style="float: right;">
            <a class="btn btn-success" href="<?= base_url(). $this->router->fetch_class(). '/generate_excel/'. $da_header['id'] ?>"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;Export Excel</a>
        </div>
    </div>
</div>

<form action="<?= base_url(). $this->router->fetch_class(). '/manage_gsk_packing/'.$da_header['id'] ?>" method="POST">
  <div class="card mb-3">
      <div class="card-block">
        
         <div style="background: chartreuse;padding: 2px 0 2px 0px;">
           <h5 class="text-center">(Oral Section)</h5>
           <h5 class="text-center">Finished Goods Packing List (Export)</h5>
           <h5 class="text-center">DA No. <?= $da_header['da_no'] ?></h5>
        </div>
        <br>
      
          <div class="row">

            <div class="form-group col-md-6">
              <label>Party Name</label>
               <input type="text" class="form-control" name="buyer_name" value="<?= $da_header['buyer_name'] ?>" required readonly>
            </div>
            <div class="form-group col-md-6">
              <label>Product Name:</label>
              <input type="text" class="form-control" name="product" value="<?= $product ?>" required readonly>
            </div>

            <div class="form-group col-md-6">
              <label>Qauntity</label>
               <input type="text" class="form-control" name="qauntity" value="<?= number_format($total_quantity, 2).' Kg' ?>" required readonly>
            </div>
            <div class="form-group col-md-6">
              <label>Purchase Order No.</label>
              <input type="text" class="form-control" name="po_no" value="<?= $da_header['po_no'] ?>" required readonly>
            </div>

            <div class="form-group col-md-6">
              <label>Invoice No</label>
               <input type="text" class="form-control" name="invoice_no" value="<?= !empty($gsk_packing) ? $gsk_packing['invoice_no'] : 'NLLA/16'  ?>">
            </div>
            <div class="form-group col-md-6">
              <label>Despatch Date.</label>
              <input type="text" class="form-control" name="despatch_date" value="<?= !empty($gsk_packing) ? $gsk_packing['despatch_date'] : ''  ?>" >
            </div>
         </div>   
      </div>
  </div>

  <div class="card mb-3">
      <div class="card-block">

             <div class="table-responsive">
              <table class="table table-bordered" width="100%" id="table-gsk-packing-list" cellspacing="0">
              <thead>
                 <tr>
                     <th>S.No.</th>
                     <th>Excise S.No. <small class="text-info">(Box) </small></th>
                     <th>Bag No. <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Add the Bag No to 1-6 format."></i></th>
                     <th>Batch No.</th>
                     <th>Mfg Date</th>
                     <th>Retest Date</th>
                     <th>Tare Wt.(Polybag)</th>
                     <th>Net Wt.</th>
                     <th>Gross Wt.(Bag)  <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="CALCULATION:  (Tare wt (polybag) + Net Wt ) = Gross Wt.(Bag)"></i></th>
                     <th>Tare Wt.(Corrugated Box)</th>
                     <th>Gross Wt.(Corrugated Box) <i class="fa fa-question-circle text-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="CALCULATION:  (Gross Wt.(Bag)*6) + Tare Wt.(Corrugated Box) = Gross Wt.(Corrugated Box)"></i></th>
                     <th>Gross Wt.(Pallet)</th>
                     <th>Action</th>
                 </tr>
              </thead>
              <tbody id="table-gsk-packing-list-row">
               <?php if(!empty($packing_list)) {
                foreach($packing_list as $key => $value) { ?>
    
                <tr class="db-data" id="gsk-packing-<?= $key + 1000 ?>" style="background: aliceblue;">
                  <td>
                    <div class="form-group">
                      <input type="text" name="serial_no[]" class="form-control" value="<?= $value['serial_no'] ?>" id="serial_no-<?= $key + 1000 ?>" readonly>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="excise_serial_no[]" class="form-control" value="<?= $value['excise_serial_no'] ?>" id="excise_serial_no-<?= $key + 1000 ?>" >
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="bag_no[]" class="form-control" value="<?= $value['bag_no'] ?>" id="bag_no-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="batch_no[]" class="form-control" value="<?= $value['batch_no'] ?>" id="batch_no-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="mfg_date[]" class="form-control mfg_date" value="<?= $value['mfg_date'] ?>" id="mfg_date-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="retest_date[]" class="form-control retest_date" value="<?= $value['retest_date'] ?>" id="retest_date-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="tare_wt[]" class="form-control" value="<?= $value['tare_wt'] ?>" id="tare_wt-<?= $key + 1000 ?>" onchange="grossWtBag(<?= $key + 1000 ?>)">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="net_wt[]" class="form-control" value="<?= $value['net_wt'] ?>" id="net_wt-<?= $key + 1000 ?>" onchange="grossWtBag(<?= $key + 1000 ?>)">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="gross_wt[]" class="form-control" value="<?= $value['gross_wt'] ?>" id="gross_wt-<?= $key + 1000 ?>" onchange="grossWeightCalculation(<?= $key + 1000 ?>)" readonly>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="tare_wt_corrugated[]" class="form-control" value="<?= $value['tare_wt_corrugated'] ?>" id="tare_wt_corrugated-<?= $key + 1000 ?>" onchange="grossWeightCalculation(<?= $key + 1000 ?>)">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="gross_wt_corrugated[]" class="form-control" value="<?= $value['gross_wt_corrugated'] ?>" id="gross_wt_corrugated-<?= $key + 1000 ?>" >
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="gross_wt_pallet[]" class="form-control" value="<?= !empty($value['gross_wt_pallet']) ? $value['gross_wt_pallet'] : '0.00' ?>" id="gross_wt_pallet-<?= $key + 1000 ?>">
                    </div>
                  </td>
                  
                   <td>
                     <input type="button" value="Delete" id="delete-<?= $value['id'] ?>" class="btn btn-danger" data-id="<?= $value['id'] ?>"  data-url="<?= base_url().$this->router->fetch_class().'/delete_gsk_packing_map/'.$value['id'] ?>" data-toggle="tooltip" data-placement="top" title="Delete record permanetly"/>
                   </td>

                 </tr>
              <?php } } ?>
              <?php if(empty($packing_list)) { ?>
                <tr>
                  <td>
                    <div class="form-group">
                      <input type="text" name="serial_no[]" class="form-control" value="1" id="serial_no-0" readonly>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="excise_serial_no[]" class="form-control" value="" id="excise_serial_no-0" >
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="bag_no[]" class="form-control" value="" id="bag_no-0">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="batch_no[]" class="form-control" value="" id="batch_no-0">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="mfg_date[]" class="form-control mfg_date" value="" id="mfg_date-0">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="retest_date[]" class="form-control retest_date" value="" id="retest_date-0">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="tare_wt[]" class="form-control" value="" id="tare_wt-0" onchange="grossWtBag(0)">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="net_wt[]" class="form-control" value="" id="net_wt-0" onchange="grossWtBag(0)">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="gross_wt[]" class="form-control" value="" id="gross_wt-0" onchange="grossWeightCalculation(0)" readonly>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="tare_wt_corrugated[]" class="form-control" value="" id="tare_wt_corrugated-0" onchange="grossWeightCalculation(0)">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="gross_wt_corrugated[]" class="form-control"  id="gross_wt_corrugated-0">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="gross_wt_pallet[]" class="form-control" value="0.00" id="gross_wt_pallet-0">
                    </div>
                  </td>
                  <td></td>
                 </tr>
              <?php } ?>
              </tbody>
           
              </table>


                 <button type="button"  id="add-more-gsk-packing-list" class="btn btn-success" title="Please select da type above to proceed."><i class="fa fa-plus"></i>&nbsp;Add Row</button>
              </div>
              <br><br>
              <div class="row">
                <div class="form-group col-md-12">
                   <label>Travel Sample:</label>
                 </div>
                 
                 <div class="form-group col-md-2">
                   <input type="text" name="travel_sample1" value="<?= !empty($gsk_packing) ? $gsk_packing['travel_sample1'] : ''  ?>" class="form-control">
                 </div>

                  <div class="form-group col-md-2">
                   <input type="text" name="travel_sample2" value="<?= !empty($gsk_packing) ? $gsk_packing['travel_sample2'] : ''  ?>" class="form-control">
                 </div>

                  <div class="form-group col-md-2">
                   <input type="text" name="travel_sample3" value="<?= !empty($gsk_packing) ? $gsk_packing['travel_sample3'] : ''  ?>" class="form-control">
                 </div>
              </div>
              
              <hr>
              <div class="row">
                <div class="form-group col-md-12">
                   <button type="button" class="btn btn-success" onclick="grandCalculationgsk()">Click to Auto Caluclate the Grand Total Summary</button> <br><br>
                   <label>Grand Total:</label>
                 </div>
                 
                 <div class="form-group col-md-2">
                   <label>Tare Wt.(Polybag):</label>
                   <input type="text" id="grand_tare" name="grand_tare" value="<?= !empty($gsk_packing) ? $gsk_packing['grand_tare'] : ''  ?>" class="form-control" >
                 </div>

                  <div class="form-group col-md-2">
                    <label>Net Wt.</label>
                   <input type="text" id="grand_net" name="grand_net" value="<?= !empty($gsk_packing) ? $gsk_packing['grand_net'] : ''  ?>" class="form-control">
                 </div>

                  <div class="form-group col-md-2">
                    <label>Gross Wt.(Bag):</label>
                   <input type="text" id="grand_gross" name="grand_gross" value="<?= !empty($gsk_packing) ? $gsk_packing['grand_gross'] : ''  ?>" class="form-control">
                 </div>

                 <div class="form-group col-md-2">
                   <label>Tare Wt.(Corr. Box):</label>
                   <input type="text" id="grand_tare_coggurated" name="grand_tare_coggurated" value="<?= !empty($gsk_packing) ? $gsk_packing['grand_tare_coggurated'] : ''  ?>" class="form-control">
                 </div>

                  <div class="form-group col-md-2">
                  <label>Gross Wt.(Corr. Box):</label>
                   <input type="text" id="grand_gross_coggurated" name="grand_gross_coggurated" value="<?= !empty($gsk_packing) ? $gsk_packing['grand_gross_coggurated'] : ''  ?>" class="form-control">
                 </div>

                  <div class="form-group col-md-2">
                    <label>Gross Wt(Pallet):</label>
                   <input type="text" id="grand_gross_pallet" name="grand_gross_pallet" value="<?= !empty($gsk_packing) ? $gsk_packing['grand_gross_pallet'] : ''  ?>" class="form-control">
                 </div>
              </div>

          </div>
      
  </div>


  <div class="card mb-3">
      <div class="card-block">
        
         <div class="row">

             <div class="form-group col-md-12">
                 <label>GSK Packing Additional Information:</label>
                 <textarea class="form-control" rows="10" cols="5" name="gsk_info"><?= !empty($gsk_packing) ? $gsk_packing['gsk_info'] : ''?></textarea>
            </div>
            
            <div class="form-group col-md-12">
                 <label>Pallet Dimensions:</label>
                 <textarea class="form-control" rows="2" cols="2" name="pallet_dimensions"><?= !empty($gsk_packing) ? $gsk_packing['pallet_dimensions'] : ''?></textarea> 
          </div>

      </div>

       <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
      <a href="<?= base_url().$this->router->fetch_class().'/add_packing_list/'.$da_header['id'] ?>" class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;Cancel</a>

    </div>
 </div>

</form>