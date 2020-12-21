<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>

<style type="text/css">
 @page {
      margin-left:5px!important;
       margin-right:5px!important;
       margin-top:5px!important;
       margin-bottom:5px!important;
     }        
     table{
    font-family:Arial, Helvetica, sans-serif;
    font-size: 9px;
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
            <td colspan="<?php if($invoice_datype == '1' && !empty($show_seal_no)) { echo "8"; } else if($invoice_datype == '3' || $invoice_datype == '5') { echo "9"; } else { echo "7"; } ?>" align="center" valign="middle"><strong style="font-size: 20px;">PACKING LIST</strong></td>
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
            <td colspan="<?php if($invoice_datype == '1' && !empty($show_seal_no)) { echo "5"; } else if($invoice_datype == '3' || $invoice_datype == '5') { echo "6"; } else { echo "4"; } ?>" valign="top" style="border-left: 0 !important;"><strong>Export Reference</strong> <br>
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
               <strong>Buyer (if other than Consignee):</strong> <br/>
               <?= $invoice_data['buyer'] ?> <br/>
               
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
            <td colspan="<?php if($invoice_datype == '1' && !empty($show_seal_no)) { echo "5"; } else if($invoice_datype == '3' || $invoice_datype == '5') { echo "6"; } else { echo "4"; } ?>" valign="top" style="border-left: 0 !important;">&nbsp;</td>
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
            <td colspan="<?php if($invoice_datype == '1' && !empty($show_seal_no)) { echo "5"; } else if($invoice_datype == '3' || $invoice_datype == '5') {echo "6"; } else { echo "4"; } ?>" align="left" valign="top"><strong>Country of Final Destination</strong> <br />
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
            <td colspan="<?php if($invoice_datype == '1' && !empty($show_seal_no)) { echo "6"; } else if($invoice_datype == '3' || $invoice_datype == '5') { echo "7"; } else { echo "5"; } ?>" rowspan="2" align="left" valign="top">
                <strong> Terms of Delivery &amp; Payment </strong><br />
                <br />
               <p>
                  <strong>PRICE TERMS</strong>:
                  <?= $invoice_data['term_of_delivery'] ?></p>
               <p>
                <strong>PAYMENT</strong>: <?= $invoice_data['payment_terms'] ?> 
               </p>

                <?php if(!empty($invoice_data['lic_no'])) { ?>
                       <?= $invoice_data['lic_no'] ?>
                       <?= $invoice_data['lic_date'] ?>
                           
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
         <td width="10%" align="center" valign="top"><strong>Marks &amp; Nos./<br />
            Drum no.</strong>
         </td>
         <td width="15%"  align="center" valign="top"><strong>No. &amp; Kind of<br />
            Packages</strong>
         </td>
         <td align="center" valign="top"><strong>Description of Goods and/or Services </strong></td>

         <?php if($invoice_datype =='3' || $invoice_datype =='5' ) { ?>
            <td width="10%" align="center" valign="top"><strong>Box <br />
              no.</strong>
           </td>
             <td width="10%" align="center" valign="top"><strong>Total Nos of Box <br />
              no.</strong>
           </td>
           <td width="10%" align="center" valign="top"><strong>Total Nos of Packs <br />
              no.</strong>
           </td>
        <?php }  else {?>
           <td width="10%" align="center" valign="top"><strong>Drum <br />
              no.</strong>
           </td>
        <?php } ?>

         <td width="10%" align="center" valign="top"><strong>Batch <br />
            Nos.</strong>
         </td>
         <td width="10%" align="center" valign="top"><strong>Net Wt.<br />
            in kgs</strong>
         </td>
         <td width="10%" align="center" valign="top"><strong>Gross Wt.<br />
            in kgs</strong>
         </td>
         <?php if($invoice_datype == '1' && !empty($show_seal_no)) { ?>
           <td width="10%" align="center" valign="top"><strong>Seal No</strong>
           </td>
         <?php } ?>

      </tr>
      <?php if(!empty($invoice_packing_list) && empty($import)) {
             $count = count($invoice_packing_list); 
             $total_net_wt = 0;
             $total_gross_wt = 0;
             foreach($invoice_packing_list as $outerKey => $value) {
                
              $total_net_wt+= $value['net_weight'];
              $total_gross_wt+= $value['outer_gross_weight'];
        ?>
      <tr>
         <td style="border-bottom:0; border-top: 0;" align="center" valign="top">
                <p><?= !empty($value['drum_nos']) ? $value['drum_nos'] : '' ?></p>
                                <?php if($outerKey == 0) { ?>
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
         <td style="border-bottom:0; border-top: 0;" align="center" valign="top">
            <?php if($outerKey == 0) { ?>
             <p><?= $value['packing_type'] ?>
            </p>

          <?php } ?>
          <br />
        
          
         </td>
         <td style="border-bottom:0; border-top: 0;" align="center" valign="top">
           <?php 
               if($outerKey == 0) { ?>
                  <p>
                    <b><?= $value['product'] ?></b>
                  </p>
                <?php   if(!empty($invoice_data['shipping_marks'])) { ?>
                  <p>
                      <?= $invoice_data['shipping_marks'] ?>
                  </p>
                   <?php } } ?>
            <br />
            
         </td>
          <?php if($invoice_datype == '3' || $invoice_datype =='5' ) { ?>
             <td style="border-bottom:0" align="center" valign="top">
                <blockquote>
                    <p><?= $value['box_no'] ?></p>
                </blockquote>
             </td>
               <td style="border-bottom:0" align="center" valign="top">
                <blockquote>
                    <p><?= $value['total_no_boxes'] ?></p>
                </blockquote>
             </td>
             <td style="border-bottom:0" align="center" valign="top">
                <blockquote>
                    <p><?= $value['total_no_packs'] ?></p>
                </blockquote>
             </td>
         <?php } else { ?>
             <td style="border-bottom:0" align="center" valign="top">
              <blockquote>
                  <p><?= $value['excise_sr_no'] ?></p>
              </blockquote>
           </td>
         <?php } ?>
         <td style="border-bottom:0" align="center" valign="top">
            <p><?= $value['batch_no'] ?></p>
         </td>
          <td style="border-bottom:0" align="center" valign="top">
            <p><?= $value['net_weight'] ?></p>
         </td>
         <td align="center" valign="top">
               <p><?= $value['outer_gross_weight'] ?></p>
         </td>
          <?php if($invoice_datype == '1' && !empty($show_seal_no)) { ?>
               <td align="center" valign="top">
                     <p><?= $value['seal_no'] ?></p>
               </td>
          <?php } ?>
        
        </tr>
        <?php }?>
        <tr>
           <td style="border-top:0;"></td>
           <td style="border-top:0;"></td>
           <td style="border-top:0;"></td>
           <td style="border-top:0;"></td>
           <td style="border-top:0;"></td>
           <?php if($invoice_datype == '3' || $invoice_datype =='5' ) { ?>
           <td style="border-top:0;"></td>
           <td style="border-top:0;"></td>
           <?php } ?>
           <td>
              <strong><?= !empty($invoice_packing_list) ? sprintf('%0.2f', $total_net_wt) : ''?></strong>
           </td>
           <td>
               <strong><?= !empty($invoice_packing_list) ? sprintf('%0.2f', $total_gross_wt)  : ''?></strong>
            </td>
            <?php if($invoice_datype == '1' && !empty($show_seal_no)) { ?>
                 <td style="border-top:0;"></td>
           <?php  }?>
        </tr>
      <?php } else {

            if(!empty($invoice_packing_list)) {
               $total_net_wt = 0;
               $total_gross_wt = 0;
               foreach($invoice_packing_list as $outerKey=> $value) { 

                $total_net_wt+= $value['net_weight'];
                $total_gross_wt+= $value['gross_weight'];
          ?>
        <tr>
         <td style="border-bottom:0" align="center" valign="top">
              <p><?= $value['marks_n_drums'] ?></p>
         </td>
         <td style="border-bottom:0" align="center" valign="top">
              <p><?= $value['packing_type'] ?></p>
         </td>
         <td style="border-bottom:0" align="center" valign="top">
              <p><?= $value['product'] ?></p>
         </td>
         <td style="border-bottom:0" align="center" valign="top">
            <blockquote>
                <p><?= $value['drum_nos'] ?></p>
            </blockquote>
         </td>
         <td style="border-bottom:0" align="center" valign="top">
             <p><?= $value['batch'] ?></p>
         </td>
         <td style="border-bottom:0" align="center" valign="top">
             <p><?= $value['net_weight'] ?></p>
         </td>
         <td align="center" valign="top">
            
               <p><?= $value['gross_weight'] ?></p>
            
         </td>
        </tr>
      <?php } ?>
        <tr>
           <td style="border-top:0;"></td>
           <td style="border-top:0;"></td>
           <td style="border-top:0;"></td>
           <td style="border-top:0;"></td>
           <td style="border-top:0;"></td>
           <td>
              <strong><?= !empty($invoice_packing_list) ? sprintf('%0.2f', $total_net_wt) : ''?></strong>
           </td>
           <td>
              <strong><?= !empty($invoice_packing_list) ? sprintf('%0.2f', $total_gross_wt) : ''?></strong>
            </td>
        </tr>

      <?php } } ?>
      <tr>
         <td style="border-right:0; border-top:0" colspan="4">
            <table class="outer" width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                  <?php if(!empty($invoice_data['declaretion_final'])) { ?>
                    <td width="51%" align="left" valign="top">
                       <b>Banker’s details / Payment Instructions are as under:</b><br />
                        <?= $invoice_data['declaretion_final'] ?>
                    </td>
                  <?php } ?>
               </tr>
            </table>
         </td>
         <td colspan="<?php if($invoice_datype == '1' && !empty($show_seal_no)) { echo "4"; } else if($invoice_datype == '3' || $invoice_datype == '5') { echo "5"; } else { echo "3"; } ?>" align="right" valign="bottom" style="border-left:0; border-top:0">
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
 

