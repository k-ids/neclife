<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Packing List Invoice</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class().'/packing_list_invoice'?>">Generate Invoice</a></li>
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
<input type="hidden" id="url" value="<?= base_url().$this->router->fetch_class().'/generate_packing_invoice/'.$da_header['id'] ?>">
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
                                    FAX: <?= $party['fax']?> / TEL: <?= $party['phone'] ?></p>
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
                          

                        <table border="0" cellspacing="0" cellpadding="0" width="80%">
                            <thead>
                                <tr>
                                    <th contenteditable="true">#</th>
                                    <th contenteditable="true" class="text-left">Marks & Nos./</th>
                                    <th contenteditable="true" class="text-left">No. & Kind of Packages</th>
                                    <th contenteditable="true" class="text-left">Description of Goods <br>and/or Services  </th>
                                    <th contenteditable="true" class="text-left">Drum<br>No.</th>
                                    <th contenteditable="true" class="text-left">Batch <br>Nos.</th>
                                    <th contenteditable="true" class="text-left">Net Wt.<br>(IN KGS)</th>
                                    <th contenteditable="true" class="text-left">Gross Wt..<br>(IN KGS)</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($packing_list) ) {
                                     $counter = 0;
                                     
                                     foreach($packing_list as $value) {
                                       
                                ?>
                                <tr> 

                                    <td contenteditable="true" class="no"><?= ++$counter; ?></td>
                                    <td contenteditable="true" style="font-weight:500; text-transform: uppercase;" contenteditable="true">
                                        <?= $value['excise_sr_no'] ?>
                                    </td>
                                    <td contenteditable="true" class="text-left"><?= $value['kindofpackages'] ?>
                                        
                                    </td>

                                    <td contenteditable="true" class="text-left"><?= $value['product_name'].' HS CODE: '.$value['product_hscode'] ?></td>

                                    <td contenteditable="true" class="text-left"><?= $value['excise_sr_no'] ?></td>

                                    <td contenteditable="true" class="text-left"><?= $value['batch_no'] ?></td>

                                    <td contenteditable="true" class="text-left"><?= $value['net_weight'] ?></td>

                                    <td contenteditable="true" class="text-left"><?= $value['outer_gross_weight'] ?></td>
                                </tr>
                            <?php } ?>

                             <td contenteditable="true" class="no"><?= ++$counter; ?></td>
                                    <td contenteditable="true" style="font-weight:500; text-transform: uppercase;" contenteditable="true">
                                        
                                    </td>
                                    <td contenteditable="true" class="text-left">
                                        
                                    </td>

                                    <td contenteditable="true" class="text-left"></td>

                                    <td contenteditable="true" class="text-left"></td>

                                    <td contenteditable="true" class="text-left"></td>

                                    <td contenteditable="true" class="text-left"></td>

                                    <td contenteditable="true" class="text-left"> </td>

                             <?php } ?>

                              

                            </tbody>
                            
                         
                        </table>
                         <br>
                         <br>

                         <hr>
                         <br>
                         <br>

                          <div class="row contacts">
                                <div class="col invoice-details col-md-8">
                            
                                <div class="noticesfff">
                                    <div><h6 contenteditable="true">Banker’s details / Payment Instructions are as under</h6></div>
                                    <div class="noticeb" contenteditable="true">

                                        Beneficiary : Nectar Lifesciences Limited  <br>     
                                        S.C.O. 38-39, Sector 9-D <br>       
                                        Chandigarh-160 009 (India)   <br>   
                                        Beneficiary Account No. : 0575008700004684 <br>     
                                        Beneficiary Bank :  Punjab National Bank, <br>      
                                        Large Corporate Branch,Bank Square  <br>        
                                        1st Floor, Sector 17-B, Chandigarh  <br>    
                                        SWIFT CODE: PUNBINBBCMC     <br>
                                        Intermediary Bank Detail.   <br>    
                                        Account No. 36003588 of Punjab National Bank  <br>      
                                        FEO NEW DELHI SWIFT CODE : PUNBINBBDIB WITH  <br>   
                                        Citi Bank N.A.- New York, USA Swift Code: CITIUS33      
                                         
                                    </div>
                                </div>
                                   
                               
                          
                               </div>
                                <div class="col invoice-details col-md-4">
                                  <h6 contenteditable="true">For NECTAR LIFESCIENCES LTD.</h6>
                                   <p>&nbsp;</p>
                                   <p>&nbsp;</p>
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
