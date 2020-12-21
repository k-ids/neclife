<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>


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
/*    ul{
    margin-left:15px;
    padding:0px;
    }
    li{
    list-style-type:decimal;
    }*/
</style>

   <table class="outer" width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
            <td colspan="7" align="center" valign="middle"><strong style="font-size: 20px;">PACKING LIST INVOICE</strong></td>
         </tr>
         <tr>
            <td colspan="2" valign="top"><strong>Exporter/Manufacturer/Beneficiary - Name & Address </strong><br/>      <?= $invoice_data['address'] ?>
            </td>
            <td width="34%" valign="top">
                             <table class="noBorder" width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td>
                           <span style="padding:0;"><strong>Invoice No.</strong><br>
                              <?= $invoice_data['invoice_no'] ?>                              <br>
                              <strong>Buyer's Order No.</strong><br> 
                              <?= $invoice_data['buyer_order_number'] ?> 
                              <br>
                             <strong>CONTRACT NO.: </strong><br><?= $invoice_data['contract_number'] ?>
                             <br>
                              <strong>DA NO.</strong> <br><?= $invoice_data['da_no_name'] ?>
                              <br>
                              <strong>LIC NO.</strong>  <br><?= $invoice_data['lic_no'] ?>
                           <br></span>
                        </td>
                           
                        <td>
                             <span style="padding:0;"><strong>Invoice Date</strong><br>

                                <?= $invoice_data['invoice_date'] ?><br>

                                <strong>Buyer's Order Date </strong> <br>
                                <?= $invoice_data['buyer_order_date'] ?>
                                <br> 
                                 <strong>CONTRACT DATE.</strong> <br> <?= $invoice_data['contract_date'] ?><br>

                             <strong>DA Date. </strong><br><?= $invoice_data['da_date'] ?><br>
                              <strong>LIC Date. </strong><br> <?= $invoice_data['lic_date'] ?><br>

                           </span>
                             
                        </td>

                       </tr>
                  </table>
                  <strong>Other reference(s): </strong><br><?= $invoice_data['other_reference'] ?><br />
            </td>
            <td colspan="4" valign="top"><strong>Export Reference</strong> <br>
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
            <td valign="top">
               <strong>Buyer (if other than Consignee):</strong> <br/>
               <?= $invoice_data['buyer'] ?> <br/>
               <strong>NOTIFY</strong>:
               <p><?= $invoice_data['notify'] ?></p>
               <p><strong>NOTIFY</strong>:<br />
                  <?= $invoice_data['notify_1'] ?>
               </p>
            </td>
            <td colspan="4" valign="top">&nbsp;</td>
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
            <td colspan="4" align="left" valign="top"><strong>Country of Final Destination</strong> <br />
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
            <td colspan="5" rowspan="2" align="left" valign="top">
                <strong> Terms of Delivery &amp; Payment </strong><br />
               <p>
                  <strong>PRICE TERMS</strong>:
                  <?= $invoice_data['term_of_delivery'] ?></p>
               <p><strong>PAYMENT</strong>: <?= $invoice_data['payment_terms'] ?>
                  
               </p>
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
         <td width="10%" align="center" valign="top"><strong>Marks &amp; Nos./<br />
            Drum no.</strong>
         </td>
         <td width="15%"  align="center" valign="top"><strong>No. &amp; Kind of<br />
            Packages</strong>
         </td>
         <td align="center" valign="top"><strong>Description of Goods and/or Services </strong></td>
         <td width="10%" align="center" valign="top"><strong>Drum <br />
            no.</strong>
         </td>
         <td width="10%" align="center" valign="top"><strong>Batch <br />
            Nos.</strong>
         </td>
         <td width="10%" align="center" valign="top"><strong>Net Wt.<br />
            in kgs</strong>
         </td>
         <td width="10%" align="center" valign="top"><strong>Gross Wt.<br />
            in kgs</strong>
         </td>
      </tr>
      <?php if(!empty($invoice_packing_list)) {
                   
                   $count = count($invoice_packing_list); 
                   $total_net_wt = 0;
                   $total_gross_wt = 0;
                   foreach($invoice_packing_list as $outerKey => $value) {
                   $total_net_wt+= $value['net_weight'];
                   $total_gross_wt+= $value['outer_gross_weight'];
        ?>
      <tr>
         <td style="border-bottom:0" align="center" valign="top">
            
                <p><?= $value['drum_nos'] ?></p>
            
            <p>&nbsp;</p>
            <?php if($outerKey == ($count -1)) { ?>
                <p>Batch No.: <br/>
                      <?php 
                          $explode = explode(',', $invoice_data['batch_no']);
                          foreach ($explode as $key => $_value) {
                              echo $_value.'<br>';
                          }
                      ?>
                </p>
            <?php } ?>
         </td>
         <td style="border-bottom:0" align="center" valign="top">
            <p><?= $value['packing_type'] ?>
            </p>
             <?php if($outerKey == ($count -1)) { ?>
                <p>Manufacturing Date: <?= $invoice_data['mfg_date'] ?><br />
                   Expiry Date: <?= $invoice_data['exp_date'] ?>
                </p>
            <?php } ?>
         </td>
         <td style="border-bottom:0" align="center" valign="top">
            <p><?= $value['product'] ?></p>
            <br />
            <?php if($outerKey == ($count -1)) { ?>
                <p>
                      <?= $invoice_data['shipping_marks'] ?>
                      
                 </p>
           <?php } ?>
         </td>
         <td style="border-bottom:0" align="center" valign="top">
            <blockquote>
                <p><?= $value['excise_sr_no'] ?></p>
            </blockquote>
         </td>
         <td style="border-bottom:0" align="center" valign="top">
            <p><?= $value['batch_no'] ?></p>
         </td>
          <td style="border-bottom:0" align="center" valign="top">
            <p><?= $value['net_weight'] ?></p>
         </td>
         <td align="center" valign="top">
            
               <p><?= $value['outer_gross_weight'] ?></p>
            
         </td>
      </tr>
        <?php } } ?>
      <tr>
         <td style="border-top:0;"></td>
         <td style="border-top:0;"></td>
         <td style="border-top:0;"></td>
         <td style="border-top:0;"></td>
         <td style="border-top:0;"></td>
         <td style="border-top:0;"><strong><?= !empty($invoice_packing_list) ? $total_net_wt : ''?></strong></td>
         <td><strong><?= !empty($invoice_packing_list) ? $total_gross_wt : ''?></strong></td>
      </tr>

      <tr>
         <td style="border-right:0; border-top:0" colspan="4">
            <table class="outer" width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                  <td width="51%" align="left" valign="top">
                     <b>Banker’s details / Payment Instructions are as under:</b><br />
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
