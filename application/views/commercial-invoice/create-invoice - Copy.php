<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Commercial Invoice</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class()?>">Generate Invoice</a></li>
   </li>
</ol>
<div class="card mb-3">
   <div class="card-block">
      <div class="row">
         <div class="col-md-8">
            <p class="text-danger">Important information:</p>
            <ul>
               <li>The whole content is editable. Make the changes as per need and click on generate button to Generate the inovice.</li>
            </ul>
         </div>
         <div class="col-md-4">
            <button type="button" class="btn btn-primary" id="submit_data"><i class="fa fa-floppy-o"></i>&nbsp;Generate Invoice</button>
         </div>
      </div>
   </div>
</div>
<input type="hidden" id="url" value="<?= base_url().$this->router->fetch_class().'/generate_invoice/'.$da_header['id'] ?>">
<style type="text/css">
   #invoice {
   padding: 30px;
   }
   .invoice-details .date .spaceequal {
   float: left;
   padding-left: 151px;
   font-weight: bold;
   }
   .invoice {
   position: relative;
   background-color: #FFF;
   min-height: 680px;
   padding: 15px
   }
   .invoice header {
   padding: 10px 0;
   margin-bottom: 20px;
   border-bottom: 1px solid #3989c6
   }
   .invoice .company-details {
   text-align: right
   }
   .invoice .company-details .name {
   margin-top: 0;
   margin-bottom: 0
   }
   .invoice .contacts {
   margin-bottom: 20px
   }
   .invoice .invoice-to {
   text-align: left
   }
   .invoice .invoice-to .to {
   margin-top: 0;
   margin-bottom: 0
   }
   .invoice .invoice-details {
   text-align: left;
   }
   .invoice .invoice-details .invoice-id {
   margin-top: 0;
   color: #3989c6
   }
   .invoice main {
   padding-bottom: 50px
   }
   .invoice main .thanks {
   margin-top: -100px;
   font-size: 2em;
   margin-bottom: 50px
   }
   .invoice main .notices {
   padding-left: 6px;
   border-left: 6px solid #3989c6
   }
   .invoice main .notices .notice {
   font-size: 1.2em
   }
   .invoice table {
   width: 100%;
   border-collapse: collapse;
   border-spacing: 0;
   margin-bottom: 20px
   }
   .invoice table td,.invoice table th {
   padding: 15px;
   background: #eee;
   border-bottom: 1px solid #fff
   }
   .invoice table th {
   white-space: nowrap;
   font-weight: 400;
   font-size: 16px
   }
   .invoice table td h3 {
   margin: 0;
   font-weight: 400;
   color: #3989c6;
   font-size: 1.2em
   }
   .invoice table .qty,.invoice table .total,.invoice table .unit {
   text-align: right;
   font-size: 1.2em
   }
   .invoice table .no {
   color: #fff;
   font-size: 1.6em;
   background: #3989c6
   }
   .invoice table .unit {
   background: #ddd
   }
   .invoice table .total {
   background: #3989c6;
   color: #fff
   }
   .invoice table tbody tr:last-child td {
   border: none
   }
   .invoice table tfoot td {
   background: 0 0;
   border-bottom: none;
   white-space: nowrap;
   text-align: right;
   padding: 10px 20px;
   font-size: 1.2em;
   border-top: 1px solid #aaa
   }
   .invoice table tfoot tr:first-child td {
   border-top: none
   }
   .invoice table tfoot tr:last-child td {
   color: #3989c6;
   font-size: 1.4em;
   border-top: 1px solid #3989c6
   }
   .invoice table tfoot tr td:first-child {
   border: none
   }
   .invoice footer {
   width: 100%;
   text-align: center;
   color: #777;
   border-top: 1px solid #aaa;
   padding: 8px 0
   }
   @media print {
   .invoice {
   font-size: 11px!important;
   overflow: hidden!important
   }
   .invoice footer {
   position: absolute;
   bottom: 10px;
   page-break-after: always
   }
   .invoice>div:last-child {
   page-break-before: always
   }
   }
   #invoice{
   padding: 30px;
   }
   .invoice {
   position: relative;
   background-color: #FFF;
   min-height: 680px;
   padding: 15px
   }
   .invoice header {
   padding: 10px 0;
   margin-bottom: 20px;
   border-bottom: 1px solid #3989c6
   }
   .invoice .company-details {
   text-align: right
   }
   .invoice .company-details .name {
   margin-top: 0;
   margin-bottom: 0
   }
   .invoice .contacts {
   margin-bottom: 20px
   }
   .invoice .invoice-to {
   text-align: left
   }
   .invoice .invoice-to .to {
   margin-top: 0;
   margin-bottom: 0
   }
   .invoice .invoice-details {
   text-align: left;
   }
   .invoice .invoice-details .invoice-id {
   margin-top: 0;
   color: #3989c6
   }
   .invoice main {
   padding-bottom: 50px
   }
   .invoice main .thanks {
   margin-top: -100px;
   font-size: 2em;
   margin-bottom: 50px
   }
   .invoice main .notices {
   padding-left: 6px;
   border-left: 6px solid #3989c6
   }
   .invoice main .notices .notice {
   font-size: 1.2em
   }
   .invoice table {
   width: 100%;
   border-collapse: collapse;
   border-spacing: 0;
   margin-bottom: 20px
   }
   .invoice table td,.invoice table th {
   padding: 15px;
   background: #eee;
   border-bottom: 1px solid #fff
   }
   .invoice table th {
   white-space: nowrap;
   font-weight: 400;
   font-size: 16px
   }
   .invoice table td h3 {
   margin: 0;
   font-weight: 400;
   color: #3989c6;
   font-size: 1.2em
   }
   .invoice table .qty,.invoice table .total,.invoice table .unit {
   text-align: right;
   font-size: 1.2em
   }
   .invoice table .no {
   color: #fff;
   font-size: 1.6em;
   background: #3989c6
   }
   .invoice table .unit {
   background: #ddd
   }
   .invoice table .total {
   background: #3989c6;
   color: #fff
   }
   .invoice table tbody tr:last-child td {
   border: none
   }
   .invoice table tfoot td {
   background: 0 0;
   border-bottom: none;
   white-space: nowrap;
   text-align: right;
   padding: 10px 20px;
   font-size: 1.2em;
   border-top: 1px solid #aaa
   }
   .invoice table tfoot tr:first-child td {
   border-top: none
   }
   .invoice table tfoot tr:last-child td {
   color: #3989c6;
   font-size: 1.4em;
   border-top: 1px solid #3989c6
   }
   .invoice table tfoot tr td:first-child {
   border: none
   }
   .invoice footer {
   width: 100%;
   text-align: center;
   color: #777;
   border-top: 1px solid #aaa;
   padding: 8px 0
   }
   @media print {
   .invoice {
   font-size: 11px!important;
   overflow: hidden!important
   }
   .invoice footer {
   position: absolute;
   bottom: 10px;
   page-break-after: always
   }
   .invoice>div:last-child {
   page-break-before: always
   }
   }
</style>
<div class="card mb-3">
   <div class="card-block">
      <div id="invoice1">
         <div id="invoice">
            <div class="toolbar hidden-print">
            </div>
            <div class="invoice overflow-auto">
               <div style="min-width: 600px">
                  <header>
                     <div class="row">
                        <div class="col">
                           <?php   
                              $path = base_url().'resources/image/index.png'; 
                              $type = pathinfo($path, PATHINFO_EXTENSION);
                              $data = file_get_contents($path);
                              $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                              ?>
                           <img src="<?= $base64 ?>" data-holder-rendered="true" />
                        </div>
                        <div class="col company-details">
                           <!-- <p>Exporter/Manufacturer/Beneficiary - Name & Address  </p> -->
                           <h4 class="name">
                              NECTAR LIFESCIENCS LTD.
                           </h4>
                           <div> CORPORATE OFFICE/ HEAD OFFICE</div>
                           <div> SCO 38-39, Sector 9d,</div>
                           <div> Chandigarh 160009,</div>
                           <div> India </div>
                        </div>
                     </div>
                  </header>
                  <main>
                     <div class="row contacts">
                        <div class="col invoice-to col-md-5">
                           <p contenteditable="true">Exporter/Manufacturer/Beneficiary - Name & Address  </p>
                           <h5 class="name" contenteditable="true">
                              NECTAR LIFESCIENCS LTD.
                           </h5>
                           <div contenteditable="true"><b>WORKS:</b> VILLAGE SAIDPURA,</div>
                           <div contenteditable="true">TEH. DERABASSI, DISTT. MOHALI</div>
                           <div contenteditable="true">PUNJAB, INDIA</div>
                           <div contenteditable="true">SCO 38-39, SECTOR 9-D,</div>
                           <div contenteditable="true">CHANDIGARH-160009, INDIA.</div>
                           <div contenteditable="true"><b>INDIA</b></div>
                           <!-- <h5 class="to">Buyer (if other than Consignee):</h5>
                              <?php $party =  getName( $da_header['buyer'] ) ?> 
                              <p><?= $party['party']?></p>
                              <p><span><?= $party['address1']?></span></p> -->
                        </div>
                        <div class="col invoice-details col-md-5">
                           <p contenteditable="true">Invoice No. & Date</p>
                           <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true">INVOICE NO:</div>
                           <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true">Dated:&nbsp; </div>
                           <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true">Buyer's Order No. & Date</div>
                           <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true">CONTRACT NO.:&nbsp;</div>
                           <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true" >DATED :&nbsp; </div>
                           <p contenteditable="true">Other reference(s):</p>
                           <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true" >DA NO.&nbsp; <?= $da_header['da_no'] .'/'.$da_header['financial_year']?> <br>DATED <?= nice_date($da_header['da_date'], 'dd.mm.yyy')?></div>
                        </div>
                        <div class="col invoice-details col-md-2" contenteditable="true" >
                           <p>Export Reference</p>
                        </div>
                     </div>
                     <hr>
                     <div class="row contacts">
                        <div class="col invoice-to col-md-5">
                           <h5 class="to" contenteditable="true">Consignee:</h5>
                           <?php $party =  getName( $da_header['consignee'] ) ?> 
                           <p contenteditable="true"><?= $party['party']?></p>
                           <p contenteditable="true"><?= $party['address1']?><br>
                              FAX: <?= $party['fax']?> / TEL: <?= $party['phone'] ?>
                           </p>
                        </div>
                        <div class="col invoice-details col-md-5">
                           <h5 class="to" contenteditable="true">Buyer (if other than Consignee):</h5>
                           <?php $party =  getName( $da_header['buyer'] ) ?> 
                           <p contenteditable="true"><?= $party['party']?></p>
                           <p contenteditable="true" ><?= $party['address1']?><br>FAX: <?= $party['fax']?> / TEL: <?= $party['phone'] ?></p>
                        </div>
                     </div>
                     <hr>
                     <div class="row contacts">
                        <div class="col invoice-to col-md-5">
                           <h5 class="to" contenteditable="true">Notify 1:</h5>
                           <?php $party =  getName( $da_header['notify'] ) ?> 
                           <p contenteditable="true"><?= $party['party']?></p>
                           <p contenteditable="true">
                              <?= $party['address1']?> <br>
                              FAX: <?= $party['fax']?> / TEL: <?= $party['phone'] ?>
                           </p>
                        </div>
                        <div class="col invoice-details col-md-5">
                           <h5 class="to" contenteditable="true">Notify 2:</h5>
                           <?php $party =  getName( $da_header['notify_1'] ) ?> 
                           <p contenteditable="true"><?= $party['party']?></p>
                           <p contenteditable="true">
                              <?= $party['address1']?><br>
                              FAX: <?= $party['fax']?> / TEL: <?= $party['phone'] ?>
                           </p>
                        </div>
                     </div>
                     <hr>
                     <div class="row contacts">
                        <div class="col invoice-to col-md-3">
                           <h6 class="to" contenteditable="true">Pre-carriage by</h6>
                           <p contenteditable="true"></p>
                        </div>
                        <div class="col invoice-details col-md-3">
                           <h6 class="to" contenteditable="true">Place of Receipt</h6>
                           <p contenteditable="true">by Pre-Carrier</p>
                        </div>
                        <div class="col invoice-details col-md-3">
                           <h6 contenteditable="true">Country of Origin</h6>
                           <p style="font-weight:500; text-transform: uppercase;" contenteditable="true"><b>INDIA</b></p>
                        </div>
                        <div class="col invoice-details col-md-3">
                           <h6 contenteditable="true">Country of Final Destination</h6>
                           <p style="font-weight:500; text-transform: uppercase;" contenteditable="true"><?= $da_header['county_name']?> </p>
                        </div>
                     </div>
                     <hr>
                     <div class="row contacts">
                        <div class="col invoice-to col-md-3">
                           <h6 class="to">Vessel/Flight no.</h6>
                           <p style="font-weight:500; text-transform: uppercase;" contenteditable="true"></p>
                        </div>
                        <div class="col invoice-details col-md-3">
                           <h6 class="to">Airport of Loading</h6>
                           <p style="font-weight:500; text-transform: uppercase;" contenteditable="true"></p>
                        </div>
                        <div class="col invoice-details col-md-3">
                           <h6>Terms of Delivery & Payment</h6>
                           <p style="font-weight:500; text-transform: uppercase;" contenteditable="true"><?= $da_header['deliveryterm'] ?>, <?= $da_header['paymentterms']?></p>
                        </div>
                     </div>
                     <hr>
                     <div class="row contacts">
                        <div class="col invoice-to col-md-3">
                           <h6 class="to">Airport of Discharge</h6>
                           <p style="font-weight:500; text-transform: uppercase;" contenteditable="true"></p>
                        </div>
                        <div class="col invoice-details col-md-3">
                           <h6 class="to">Final Destination</h6>
                           <p style="font-weight:500; text-transform: uppercase;" contenteditable="true"><?= $da_header['despatchto']?></p>
                        </div>
                        <div class="col invoice-details col-md-3">
                           <h6>PAYMENT</h6>
                           <p style="height:20px;font-weight:500; text-transform: uppercase;" contenteditable="true"></p>
                        </div>
                     </div>
                     <hr>
                     <div class="row contacts">
                        <div class="col invoice-to col-md-3">
                           <h6 class="to">Batch No.:</h6>
                           <p style="font-weight:500; text-transform: uppercase;" contenteditable="true"><?= $batch_no ?></p>
                        </div>
                        <div class="col invoice-details col-md-3">
                           <h6 style="font-weight:500; text-transform: uppercase;" contenteditable="true"class="to">Manufacturing Date: FEB-2020</h6>
                           <h6 style="font-weight:500; text-transform: uppercase;" contenteditable="true"class="to">Expiry Date: JAN-2023</h6>
                        </div>
                        <div class="col invoice-details col-md-3">
                           <h6>SHIPPING MARKS:</h6>
                           <p style="font-weight:500; text-transform: uppercase;" contenteditable="true"><?= $da_header['shipping_marks']?></p>
                        </div>
                     </div>


                     <table style="width:100%;border-collapse: collapse;background: #ccc;">
                        <tbody>
                           <tr>
                              <th>#</th>
                              <th contenteditable="true" style="width: 20%;">Marks &amp; Nos./</th>
                              <th contenteditable="true" style="width: 20%;">No. &amp; Kind of Packages</th>
                              <th contenteditable="true" style="width: 20%;">Description of Goods<br>
                                 and/or Services 
                              </th>
                              <th contenteditable="true" style="width: 20%;">Quantity<br>
                                 (KGS)
                              </th>
                              <th contenteditable="true" style="width: 20%;">Rate<br>
                                 (USD/KGS)
                              </th>
                              <th contenteditable="true" style="width: 20%;">Amount
                                 (USD)
                              </th>
                           </tr>
                            <?php if(!empty($da_items) ) {
                                     $counter = 0;
                                     $sum = 0;
                                     foreach($da_items as $daitems) {
                                     $sum+= $daitems['amount'];
                            ?>
                           <tr>
                              <td contenteditable="true" style="text-align:left;"><?= ++$counter; ?></td>
                              <td contenteditable="true" style="width: 20%;">&nbsp;</td>
                              <td contenteditable="true" style="width: 20%; text-align:left;"><?= $daitems['kindofpackages'] ?></td>
                              <td  contenteditable="true"style="width: 20%; text-align:left;"><?= $daitems['product_name'].' HS CODE: '.$daitems['hscode'] ?></td>
                              <td contenteditable="true" style="width: 20%; text-align:left;"><?= $daitems['quantity'] ?></td>
                              <td contenteditable="true" style="width: 20%; text-align:left;"><?= $daitems['rate'] ?></td>
                              <td contenteditable="true" style="width: 20%; text-align:left;"><?= $daitems['amount'] ?></td>
                           </tr>
                           <?php } } ?>
                        </tbody>
                     </table>
                     <table style="width:100%;border-collapse: collapse;background: #ccc;">
                        <tbody>
                           <tr>
                              <th contenteditable="true" style="width: 20%; text-align:center;" >TOTAL</th>
                              <th contenteditable="true" style="width: 20%; text-align:center;"><?=  !empty($da_items) ? number_format((float) $sum , 2, '.', '') : '' ?></th>
                           </tr>
                           <tr>
                              <td contenteditable="true" style="text-align:left; text-align:center;">Amount Chargeable (in words) USD </td>
                              <td contenteditable="true" style="width: 20%; text-align:left; text-align:center;"><?= convert_number(!empty($sum) ? $sum: 0)?> Only</td>
                           </tr>
                        </tbody>
                     </table>


                     <div class="row contacts">
                        <div class="col invoice-details col-md-6">
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">PAN NO.</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="text-transform: uppercase;" contenteditable="true">ENTER PAN NUMBER HERE</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">I.E. CODE NO.</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="text-transform: uppercase;" contenteditable="true">ENTER I.E. CODE NO HERE</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">ADV.LIC. NO</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true">ENTER ADV.LIC. NO HERE</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">CIN NO.</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true">ENTER CIN NO HERE</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">GSTIN.</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true">ENTER GSTIN HERE</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">STATE</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true">ENTER STATE HERE</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">STATE CODE.</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true">ENTER STATE CODE HERE</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12" contenteditable="true" style="padding:20px 15px 20px 15px;">
                                 "<?= $da_header['declaration1']?>"
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">NET WEIGHT</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true"><?= number_format((float) $net_weight , 2, '.', '') ?> KGS</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">TARE WEIGHT</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true"><?= number_format((float) $tare_weight , 2, '.', '') ?> KGS</div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <h6 contenteditable="true">GROSS WEIGHT</h6>
                              </div>
                              <div class="col-md-6">
                                 <div class="date" style="font-weight:500; text-transform: uppercase;" contenteditable="true"><?= number_format((float) $gross_weight , 2, '.', '') ?> KGS</div>
                              </div>
                           </div>
                        </div>
                        <div class="col my-left-col invoice-details col-md-6">
                           <div class="row">
                              <div class="col-md-6" contenteditable="true">
                                 Exchange Rate (USD)
                              </div>
                              <div class="col-md-6" style="font-weight:500; text-transform: uppercase;" contenteditable="true">
                                 <?= $da_header['exchange_rate']?>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6" contenteditable="true">
                                 Taxable Value (INR)
                              </div>
                              <div class="col-md-6" style="font-weight:500; text-transform: uppercase;" contenteditable="true">
                                 0.00
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6" contenteditable="true">
                                 EUNDER LUT
                              </div>
                              <div class="col-md-6" style="font-weight:500; text-transform: uppercase;" contenteditable="true">
                                 0.00
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6" contenteditable="true">
                                 Total Amount (INR)
                              </div>
                              <div class="col-md-6" style="font-weight:500; text-transform: uppercase;" contenteditable="true">
                                 0.00
                              </div>
                           </div>
                        </div>
                     </div>
               </div>
               <div class="row contacts">
               <div class="col invoice-details col-md-8">
               <div class="notices">
               <div><h5 contenteditable="true">Declaration:</h5></div>
               <div class="notice" >
               <p contenteditable="true">1. We declare that this Invoice shows actual price of the goods described & that all the particulars are true and correct.  </p>      
               <p contenteditable="true">2. Cetified that the Country of Origin of these goods is India.  </p>     
               <p contenteditable="true">3. In case of any Quality issue please intimate in writing along with the Test Report within 21 days for Oral products and 30 days for Sterile products from the date of shipment. Any claims received after the above mentioned period shall not be entertained and the buyer will be liable to pay the Full Invoice on due date. </p>
               <p contenteditable="true">4. For any delay in receipt after due date, a penal interest @ 21 % for the delayed period will be payable by the buyer to the seller. </p> 
               </div>
               </div>
               </div>
               <div class="col invoice-details col-md-4" style="vertical-align: bottom;position: absolute;bottom: 48px;right: 0;text-align: right;padding: 40px;">
               <h6 contenteditable="true">For NECTAR LIFESCIENCES LTD.</h6>
               <p>&nbsp;</p>
               <p>&nbsp;</p>
               <h6 contenteditable="true">MANAGER EXPORTS</h6>
               </div>
               </div>
               </main>
            </div>
            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
            <div></div>
         </div>
      </div>
   </div>
</div>
</div>