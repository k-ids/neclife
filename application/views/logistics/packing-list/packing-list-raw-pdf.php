<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>

<style>

table {
    font-weight: none !important;
}

</style>


<div class="card mb-3">
   <div class="card-block">

      
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="noBorder">
              <tr>
                <td colspan="2" align="center"><strong>PACKING LIST DATA</strong></td>

              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Party Name:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['party'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">DA No:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['daname'] .' '.$da_info['financial_year'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Product:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['product_name'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Product Type:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['datype_name'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Production Block:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['department_name'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">DA Qty:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['qty'] ?></td>
              </tr>

               <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Grade:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['productgrade'] ?></td>
              </tr>

               <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Created By:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['created_by'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Production Remarks:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['production_remarks'] ?></td>
              </tr>


              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">QA Approved By:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['approved_by']?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">QA Remarks:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['qa_remarks']?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">QA Manger Approved By:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['manager_qa']?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">QA Manger Remarks:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['manager_remarks']?></td>
              </tr>
            </table>
              
            </br></br></br>
          
             <table  width="100%" border="0" cellpadding="5" cellspacing="5" class="noBorder">
                <thead>
                   <tr>
                      <th>S.No</th>
                      <th>Batch No.</th>
                      <th>Excise Sr.No</th>
                      <th>QC Seal No.</th>
                      <th>Mfg Date</th>
                      <th>Exp Date</th>
                      <th>Retest Date</th>
                      <th>Packing Type</th>
                      <th>Inner Tare Wt</th>
                      <th>Outer <br>Tare Wt.</th>
                      <th>Net Wt.</th>
                      <th>Inner Gross Wt.</th>
                      <th>Outer Gross Wt.</th>
                      <th>Dimession</th>
                      <th>Pallet Dimessions</th>
                      <th>Pallet Gross Wt.</th>
                      <th>Pallet No.</th>
                      
                   </tr>
                </thead>
          
                <tbody>

                   <?php if(!empty($packing_list)) { 
                       foreach($packing_list as $key => $value) { ?>
                          
                          <tr>
                             <td><?= $value['seal_no'] ?></td>
                             <td><?= $value['batch_no'] ?></td>
                             <td><?= $value['excise_sr_no'] ?></td>
                             <td><?= '' ?></td>
                             <td><?= $value['mfg_date'] ?></td>
                             <td><?= $value['exp_date'] ?></td>
                             <td><?= $value['rate_st_date'] ?></td>
                             <td><?= $value['packing_type'] ?></td>
                             <td><?= $value['inner_tare_weight'] ?></td>
                             <td><?= $value['outer_tare_weight'] ?></td>
                             <td><?= $value['net_weight'] ?></td>
                             <td><?= $value['inner_gross_weight'] ?></td>
                             <td><?= $value['outer_gross_weight'] ?></td>
                             <td><?= $value['dimensions'] ?></td>
                             <td><?= $value['pallet_dimensions'] ?></td>
                             <td><?= $value['pallet_gross_weight'] ?></td>
                             <td><?= $value['pallet_no'] ?></td>
                            
                          </tr>
                        
                   <?php } ?>

                   <?php } ?>
                </tbody>
             </table>

      </div>
</div>
