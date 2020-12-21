<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Logistics</li>
   <li class="breadcrumb-item">GSK Packing List - View</li>

   </li>
</ol>

<style>

table {
    font-weight: none !important;
}

</style>

<div class="card mb-3">
   <div class="card-block">
         
         <a style="float:right;" class="btn btn-danger" href="<?= base_url().'logistics/gsk_packing_list_raw_pdf/'. $this->uri->segment(3)?>"><i class="fa fa-files-o"></i>&nbsp;Download as PDF</a>

    </div>
</div>

<div class="card mb-3">
   <div class="card-block">

      
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="noBorder">
              <tr>
                <td colspan="2" align="center"><strong>GSK PACKING LIST DATA</strong></td>

              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Party Name:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['party_name'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">DA No:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['da_name'] .' '.$da_info['financial_year'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Product:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['product_name'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Production Block:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['dept_name'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">DA Qty:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['qauntity'] ?></td>
              </tr>

              <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Production Remarks:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['gsk_info'] .' '.$da_info['pallet_dimensions'] ?></td>
              </tr>

               <tr>
                <td width="34%" style="padding: 5px 5px 5px 5px !important;">Created By:</td>
                <td width="66%" style="padding: 5px 5px 5px 5px !important;"><?= $da_info['created_by'] ?></td>
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
            

             <table  width="100%" border="0" cellpadding="5" cellspacing="5" class="noBorder">
                <thead>
                   <tr>
                      <th>S.No</th>
                      <th>Excise Sr.No</th>
                      <th>Bag No.</th>
                      <th>Batch No.</th>
                      <th>Mfg Date</th>
                      <th>Retest Date</th>
                      
                      <th>Tare Wt.(Polybag)</th>
                      <th>Net Wt.</th>
                      <th>Gross Wt.(Bag) </th>
                      <th>Tare Wt.(Corrugated Box)</th>
                      <th>Gross Wt.(Corrugated Box) </th>
                     <th>Gross Wt.(Pallet)</th>
              
                   </tr>
                </thead>
          
                <tbody>
                  
                   <?php if(!empty($packing_list_map)) { 
                       foreach($packing_list_map as $key => $value) { 
                          
                            if($value['bag_no1'] == '1') {
                                  $serial_no = $value['data']['serial_no'];
                                  $excise_serial_no = $value['data']['excise_serial_no'];
                                  $tare_wt_corrugated = $value['data']['tare_wt_corrugated'];
                                  $gross_wt_corrugated = $value['data']['gross_wt_corrugated'];
                                  $gross_wt_pallet = $value['data']['gross_wt_pallet'];

                            } else {

                                 $serial_no = '';
                                 $excise_serial_no = '';
                                 $tare_wt_corrugated = '';
                                 $gross_wt_corrugated  = '';
                                 $gross_wt_pallet = '';

                            }

                        ?>
                          <tr>
                             <td><?=  $serial_no ?></td>
                             <td><?= $excise_serial_no ?></td>
                             <td><?= $value['bag_no1'] ?></td>
                             <td><?= $value['data']['batch_no'] ?></td>
                             <td><?= $value['data']['mfg_date'] ?></td>
                             <td><?= $value['data']['retest_date'] ?></td>
                             <td><?= $value['data']['tare_wt'] ?></td>
                             <td><?= $value['data']['net_wt'] ?></td>
                             <td><?= $value['data']['gross_wt']?></td>
                             <td><?= $tare_wt_corrugated ?></td>
                             <td><?= $gross_wt_corrugated ?></td>
                             <td><?= $gross_wt_pallet ?></td>
                           
                          </tr>
                        
                   <?php } ?>

                   <?php } ?>
                    <tr>
                      <th colspan="2">Travel Sample</th>
                      <td><?= $da_info['travel_sample1'] ?></td>
                      <td><?= $da_info['travel_sample2'] ?></td>
                      <td><?= $da_info['travel_sample3'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                     
                   </tr>
                   <tr>
                      <th colspan="2">Grand Total</th>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><?= $da_info['grand_tare'] .' KGS'?></td>
                      <td><?= $da_info['grand_net'] .' KGS' ?></td>
                      <td><?= $da_info['grand_gross'] .' KGS'?></td>
                      <td><?= $da_info['grand_tare_coggurated'] .' KGS'?></td>
                      <td><?= $da_info['grand_gross_coggurated'].' KGS' ?></td>
                      <td><?= $da_info['grand_gross_pallet'] .' KGS'?></td>
                      
                   </tr>
                </tbody>
             </table>
            
      </div>
</div>
