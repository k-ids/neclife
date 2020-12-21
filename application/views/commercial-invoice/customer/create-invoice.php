<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class()?>">Commercial Invoice</a></li>
   <li class="breadcrumb-item">Customer Invoice</a></li>
   </li>
</ol>
<div class="card mb-3">
   <div class="card-block">
      <div style="float: right;">
         <a href="<?= base_url().$this->router->fetch_class().'/commercial_invoice_pdf/customer/'.$invoice_data['invoice_id']?>" class="btn btn-danger"><i class="fa fa-files-o"></i>&nbsp;Download Customer Invoice</a>
         <a href="<?= base_url().'/commercial_invoice/update_invoice/'.$invoice_data['invoice_id']?>" class="btn btn-warning"><i class="fa fa-pencil"></i>&nbsp;Edit Invoice</a>
      </div>
   </div>
</div>
<div class="card mb-3">
   <div class="card-block">
      <style type="text/css">
         table{
         font-family:Arial, Helvetica, sans-serif;
         font-size: 14px;
         }
         span{
         padding-left:20px;
         }
         table.border
         {
         border: 1px solid #000;
         border-collapse:collapse;
         }
         table.border td{
         border-bottom: 1px solid #000 !important;
         }
         table.outer
         {
         border: 1px solid #000;
         border-collapse:collapse;
         }
         table.outer td
         {
         border: 1px solid #000;
         border-collapse:collapse;
         padding: 5px;
         }
         table.noOuterBorder
         {
         border: 0px solid #000;
         border-collapse:collapse;
         }
         table.noOuterBorder tr:first-child td
         {
         border-top: 0px solid #F00;
         border-collapse:collapse;
         }
         table.noOuterBorder tr:last-child td
         {
         border-bottom: 0px solid #F00;
         border-collapse:collapse;
         }
         table.noOuterBorder tr td:first-child 
         {
         border-left: 0px solid #F00;
         border-collapse:collapse;
         }
         table.noOuterBorder tr td:last-child 
         {
         border-right: 0px solid #F00;
         border-collapse:collapse;
         }
         table.invoice
         {
         border: 0px solid #000;
         border-collapse:collapse;
         }
         table.invoice th{
         border-right:1px solid #000;
         border-bottom:1px solid #000;
         border-collapse:collapse;
         padding:5px;
         font-weight:normal;
         }
         table.invoice td{
         border-bottom: none !important;
         border-right: 1px solid #000;
         border-left: none;
         border-top: none;
         }
         table.invoice th:last-child{
         border-right:0px solid #000;
         border-collapse:collapse;
         }
         table.noBorder td{
         border: none;
         border-collapse:collapse;
         }
         .noPadding{
         padding:0px !important;
         }
         table.noOuterBorder tr td.bottomBorderNone{
         border-bottom:none !important;
         border-collapse:collapse;
         }
         /* ul{
         margin-left:15px;
         padding:0px;
         }
         li{
         list-style-type:decimal;
         }*/
      </style>
      <table class="outer" width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
            <td colspan="6" align="center" valign="middle"><strong style="font-size: 20px;">COMMERCIAL INVOICE</strong></td>
         </tr>
         <tr>
            <td colspan="2" valign="top"><strong>Exporter/Manufacturer/Beneficiary - Name & Address </strong><br/>      <?= $invoice_data['address'] ?>
            </td>
            
            <td width="34%" valign="top" style="border-right: 0 !important;">Invoice No. &amp; Date<br />
                  <strong><?= $invoice_data['invoice_no'] ?></strong><br />
                  <strong>DATED : <?= $invoice_data['invoice_date'] ?></strong><br />
                  
                    Buyer's Order No.  &amp; Date<br />
                 <b> <?= $invoice_data['buyer_order_number'] ?> <br><?= $invoice_data['buyer_order_date'] ?><br /></b>
                  
                  
                  Other reference(s): <?= $invoice_data['other_reference'] ?><br />
                <strong>DA NO. <?= $invoice_data['da_no_name'] ?> DATED <?= $invoice_data['da_date'] ?></strong> <br />

                 <?php if(!empty($invoice_data['contract_number'])) { ?>
                     <?= $invoice_data['contract_number'] ?>
                       <?= $invoice_data['contract_date'] ?><br />
                 <?php } ?>

                   
            </td>
            <td colspan="3" valign="top" style="border-left: 0 !important;"><strong>Export Reference </strong><br>
               <?= $invoice_data['export_reference'] ?>
            </td>
         </tr>
         <tr>
            <td colspan="2" valign="top">
               <strong>Consignee: </strong>
               <p>
                  <?= $invoice_data['consignee'] ?>
               </p>
            </td>
            <td valign="top" style="border-right: 0 !important;">
               <strong>Buyer (if other than Consignee): </strong><br/>
               <p>  <?= $invoice_data['buyer'] ?></p>
               
               <?php if(!empty($invoice_data['notify'])) { ?>
                  <strong>NOTIFY 1</strong>:
                  <p>
                     <?= $invoice_data['notify'] ?>
                  </p>
               <?php } ?>
               
               <?php if(!empty($invoice_data['notify_1'])) { ?>
                  <strong>NOTIFY 2</strong>:
                    <p>  
                     <?= $invoice_data['notify_1'] ?>
                   </p>
               <?php } ?>

            </td>
            <td colspan="3" valign="top" style="border-left: 0 !important;">&nbsp;</td>
         </tr>
         <tr>
            <td width="20%" align="center" valign="top"><strong>Pre-carriage by</strong><br />
               <?= $invoice_data['pre_carriage_by'] ?>
            </td>
            <td width="25%" align="center" valign="top"><strong>Place of Receipt</strong><br />
               <?= $invoice_data['Place_of_reciept'] ?><br />
            </td>
            <td align="left" valign="top"><strong>Country of Origin</strong><br />
               <?= $invoice_data['country'] ?>
            </td>
            <td colspan="3" align="left" valign="top"><strong>Country of Final Destination </strong><br />
               <?= $invoice_data['final_destination'] ?>
            </td>
         </tr>
         <tr>
            <td align="center" valign="top"><strong>Vessel/Flight no.</strong><br />
               <?= $invoice_data['vessel_flight_no'] ?>
            </td>
            <td align="center" valign="top"><strong>Port of Loading</strong><br />
               <?= $invoice_data['port_of_loading'] ?>
            </td>
            <td colspan="4" rowspan="2" align="left" valign="top">
               <strong>Terms of Delivery &amp; Payment </strong><br />
               <br />
               <p>
                  <strong>PRICE TERMS</strong>:
                  <?= $invoice_data['term_of_delivery'] ?>
               </p>
               <p>
                  <strong>PAYMENT</strong>: <?= $invoice_data['payment_terms'] ?>
               </p>
                   <?php if(!empty($invoice_data['lic_no'])) { ?>
                       <?= $invoice_data['lic_no'] ?> <?= $invoice_data['lic_date'] ?>
                           
                  <?php } ?> 
            </td>
         </tr>
         <tr>
            <td align="center" valign="top"><strong>Port of Discharge</strong><br />
               <?= $invoice_data['port_of_discharge'] ?>
            </td>
            <td align="center" valign="top"><strong>Final Destination</strong><br />
               <?= $invoice_data['final_destination'] ?>
            </td>
         </tr>
         <tr>
            <td width="20%" align="center" valign="top"><strong>Marks &amp; Nos./<br />
               Drum no.</strong>
            </td>
            <td width="25%"  align="center" valign="top"><strong>No. &amp; Kind of<br />
               Packages</strong>
            </td>
            <td align="center" valign="top"><strong>Description of Goods and/or Services </strong></td>
            <td width="7%" align="center" valign="top"><strong>Quantity<br />
               KGS</strong>
            </td>
            <td width="7%" align="center" valign="top"><strong>Rate<br />
               <?= $invoice_data['currency_name'] ?>/KGS</strong>
            </td>
            <td width="10%" align="center" valign="top"><strong>Amount<br />
               <?= $invoice_data['currency_name'] ?></strong>
            </td>
         </tr>
         <?php if(!empty($invoice_da_items)) { 
            $count = count($invoice_da_items);
            $total_quantity = 0;
            foreach($invoice_da_items as $outerKey => $value) {
               $total_quantity+= $value['qty'];
            ?>
         <tr>
            <td style="border-bottom:0" align="center" valign="top">
               <p><?= $value['drum_nos'] ?></p>
                          <?php if($outerKey == ($count -1)) { ?>
                   <p>&nbsp;</p>

            <?php if(!empty($combined_data)) { 
                     foreach($combined_data as $cKey =>  $loopValue){ 
                     $exp_mfg = explode('/', $cKey);
                  ?>
                   <p>
                     <b>Batch No:</b> </br>
                       
                     <?php foreach($loopValue as $loop) {
                            echo $loop .'<br>';
                      } ?>

                   </p>
                  <?php if(!empty($exp_mfg[1])) { ?>
                   <p>
                     <b>Mfg date:</b> 
                        <?= $exp_mfg[1] ?>
                   </p>
                   <?php } if(!empty($exp_mfg[0])) {?>  
                   <p> 
                     <b>Exp date:</b>                          
                         <?= $exp_mfg[0] ?>
                  </p> 
               <?php }  }  }?>

               <?php } ?>
            </td>
            <td style="border-bottom:0" align="center" valign="top">
               <p><?= $value['packing_type'] ?> </p>
            </td>
            <td style="border-bottom:0" align="center" valign="top">
               <p> <?= $value['product'] ?> 
               <p> <br />
                  <?php if($outerKey == ($count -1)) {
                     if(!empty($invoice_data['shipping_marks'])) { ?>
               <p><br />
                  <?= $invoice_data['shipping_marks'] ?>
               </p>
               <?php } } ?>
            </td>
            <td style="border-bottom:0" align="center" valign="top">
               <p><?= $value['qty'] ?></p>
            </td>
            <td style="border-bottom:0" align="center" valign="top">
               <p><?= $value['rate']?> </p>
            </td>
            <td align="center" valign="top">
               <blockquote>
                  <p><?= $value['amount'] ?></p>
               </blockquote>
            </td>
         </tr>
         <?php } } ?>
         <tr>
            <td style="border-top:0;"></td>
            <td style="border-top:0;"></td>
            <td style="border-top:0;"></td>
            <td>
               <strong><?= number_format((float)$total_quantity, 2, '.', '') ?></strong>
            </td>
            <td></td>
            <td><strong><?= $invoice_data['total'] ?></td>
         </tr>
         <tr>
            <td colspan="6"><strong>Amount Chargeable (in words) <?= $invoice_data['currency_name'] ?> ======></strong>&nbsp;&nbsp;&nbsp;&nbsp;<?= $invoice_data['total_amount_words'] ?></td>
         </tr>
         <tr>
            <td style="border-right:0; border-bottom:0" colspan="3">
               <table width="100%" border="0" cellpadding="0" cellspacing="0" class="noBorder">
                  <tr>
                     <td width="15%"><strong>PAN NO.</strong></td>
                     <td width="2%">:</td>
                     <td width="40%"><?= $invoice_data['pan_number'] ?></td>
                  </tr>
                  <tr>
                     <td><strong>I.E. CODE NO.</strong></td>
                     <td>:</td>
                     <td><?= $invoice_data['ie_code_no'] ?></td>
                  </tr>
                  <tr>
                   <?php if(!empty($advance_lic_no)) { ?>
                     <td><strong>ADV.LIC. NO</strong></td>
                     <td>:</td>
                     <td><strong><?= $advance_lic_no ?></strong></td>
                   <?php } else { ?>
                     <td><strong>UNDER DBK 2941B</strong></td>
                   <?php  } ?>
                  </tr>
                  <tr>
                     <td colspan="3"><strong>&quot;<?= $invoice_data['declaration'] ?></strong></td>
                  </tr>
                  <tr>
                     <td><strong>NET WEIGHT</strong></td>
                     <td>:</td>
                     <td><strong><?= $invoice_data['net_weight'] . ' KGS'?></strong></td>
                  </tr>
                  <tr>
                     <td><strong>TARE WEIGHT</strong></td>
                     <td>:</td>
                     <td><strong><?= $invoice_data['tare_weight']. ' KGS' ?></strong></td>
                  </tr>
                  <tr>
                     <td><strong>GROSS WEIGHT</strong></td>
                     <td>:</td>
                     <td><strong><?= $invoice_data['gross_weight']. ' KGS' ?></strong></td>
                  </tr>
               </table>
            </td>
            <td style="border-left:0; border-bottom:0" colspan="3">

            </td>
         </tr>

         <tr>
            <td style="border-right:0; border-top:0" colspan="3">
               <table class="outer" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                     <td width="51%" align="left" valign="top"><strong>Declaration:</strong><br />
                        <?= $invoice_data['declaretion_final'] ?>
                     </td>
                  </tr>
               </table>
            </td>
            <td colspan="3" align="right" valign="bottom" style="border-left:0; border-top:0">
               <table class="outer" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                     <td width="51%">For <strong>NECTAR LIFESCIENCES LTD.</strong><br />
                        <?php if(!empty($user_info['signature'])) { ?>
                        <img style="height: 100px;width: 200px;" src="<?=  base_url().'resources/employee-signature/'.$user_info['signature'] ?>" alt="signature">
                        <?php } else {  ?>
                        <br />
                        <br />
                        <br />
                        <?php } ?>
                        <span style="text-align:right;"><strong>MANAGER EXPORTS</strong></span>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </div>
</div>