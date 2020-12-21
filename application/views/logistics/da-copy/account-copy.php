
<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Logistics</li>
   <li class="breadcrumb-item"><a href="<?= base_url().$this->router->fetch_class().'/da_account'?>">DA Account Copy</a></li>
   </li>
</ol>

<div class="card mb-3">
    <div class="card-block" style="background: aquamarine;">
    	<div style="text-align:center;">
    		<h5>DA ACCOUNT COPY</h5>
    	</div>
   </div>

</div>

<div class="card mb-3">
    <div class="card-block">
        <div style="float: right;">
            
            <?php if(isset($findOne['cancelled']) && $findOne['cancelled'] =='0' ) {?>
                <button class="btn btn-success" type="button" onclick="PrintElem('elem')"><i class="fa fa-print"></i>&nbsp;Print</button>
             
               <!--  <button class="btn btn-danger" type="button" onclick="pdf('DA-Account-<?= $da_header['da_no'] ?>')"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</button> -->

                <a class="btn btn-danger" href="<?= base_url().'logistics/account_pdf/'.$da_header['id']?>"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</a>

                <a class="btn btn-warning" href="<?= base_url().'logistics/download/'.$da_header['id']?>"><i class="fa fa-download"></i>&nbsp;Download Attachment</a>
            
            <?php } else { ?>
                    <h5 class="text-danger text-right">This DA Entry "<?= $da_header['da_no'] ?>" has been cancelled.</h5>
            <?php } ?>
            
            
        </div>
    </div>
</div>

<div class="card mb-3">
	<div class="card-block" id="elem">
		<style type="text/css">
			table{
				font-family:Arial, Helvetica, sans-serif;
				font-size: 14px;
			}
			span{
				padding-left:20px;
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
		</style>

		<table class="outer" width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="noBorder">
					<tr>
						<td colspan="2" align="center"><strong>NECTAR LIFESCIENCS LTD.</strong></td>
					</tr>
					<tr>
						<td width="66%">DISPATCH ADVICE - EXPORTS</td>
						<td width="34%">THIS COPY TO: <span>ACCOUNT</span></td>
					</tr>
					<tr>
						<td>From: <span>Export</span></td>
						<td>To: <span><?= $da_header['datype_name'] ?></span></td>
					</tr>
				</table></td>
			</tr>
			<tr>
				<td>Please arrange to dispatch the below mentioned goods for our customer as per the confirmed writter order as per below mentioned details</td>
			</tr>
			<tr>
				<td class="noPadding"><table class="noOuterBorder" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td rowspan="4" valign="top"><strong>Buyer (if other than Consignee):</strong><br />
							<?php $party =  getName( $da_header['buyer'] ) ?>
								<?= !empty($party['party']) ? $party['party']: '' ?> <br>
							<?= !empty($party['address1']) ? $party['address1'] : '' ?><br>
							<?= !empty($party['address2']) ? $party['address2'] : ''?><br>
							<?= !empty($party['address3']) ? $party['address3'] : '' ?><br>
							<?= !empty($party['fax']) ? $party['fax'] : '' ?> <?= !empty($party['phone']) ? $party['phone'] : '' ?>
						</td>
						<td width="54%" class="noPadding"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="noBorder">
							<tr>
								<td width="63%">LC No: <?= $da_header['lc_no'] ?></td>
								<td width="37%">Dated: <?= !empty($da_header['lc_no']) ? nice_date( $da_header['lc_date'],'Y-M-d' ) : '' ?></td>
							</tr>
							<tr>
								<td>DA No: <span><?= $da_header['financial_year'] ?></span> <span> <?= $da_header['da_no'] ?></span></td>
								<td>Dated: <?= nice_date( $da_header['da_date'], 'Y-M-d' ) ?></td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td class="noPadding"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="noBorder">
							<tr>
								<td width="62%">PO No: <span><?= $da_header['po_no'] ?></span></td>
								<td width="38%" style="padding: 0 0 0 10px;">Dated: <?= nice_date( $da_header['po_date'] , 'Y-M-d' )?></td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td>Country to be Exported: <span><?= $da_header['county_name'] ?></span></td>
					</tr>
					<tr>
						<td>Term of Delivery <span><?= $da_header['deliveryterm'] ?></span></td>
					</tr>
					<tr>
						<td rowspan="3" valign="top"><strong>Consignee</strong><br />
							<?php $party =  getName( $da_header['consignee'] ) ?> 
								<?= !empty($party['party']) ? $party['party']: '' ?> <br>
							<?= !empty($party['address1']) ? $party['address1'] : '' ?><br>
							<?= !empty($party['address2']) ? $party['address2'] : ''?><br>
							<?= !empty($party['address3']) ? $party['address3'] : '' ?><br>
							<?= !empty($party['fax']) ? $party['fax'] : '' ?> <?= !empty($party['phone']) ? $party['phone'] : '' ?>
						</td>
						<td>Payment Terms: <span><?= $da_header['paymentterms'] ?></span></td>
					</tr>
					<tr>
						<td>Preshipment Sample Approved:  <span><?= !empty($da_header['pre_shipment_sample'] =='1') ? 'YES' : 'NO'; ?></span> <span>Qty: <?= !empty($da_header['sample_quantity']) ? $da_header['sample_quantity'] : ''; ?></span></td>
					</tr>
					<tr>
						<td >Instructions: <?= $da_header['instructions'] ?></td> 
					</tr>
					<tr>
						<td rowspan="3" valign="top">
							<p><strong>Notify 1 </strong><br/> 
								<?php $party =  getName( $da_header['notify'] ) ?> 
								<?= !empty($party['party']) ? $party['party']: '' ?> <br>
							<?= !empty($party['address1']) ? $party['address1'] : '' ?><br>
							<?= !empty($party['address2']) ? $party['address2'] : ''?><br>
							<?= !empty($party['address3']) ? $party['address3'] : '' ?><br>
							<?= !empty($party['fax']) ? $party['fax'] : '' ?> <?= !empty($party['phone']) ? $party['phone'] : '' ?>

							</p>
							<p>&nbsp;</p><p><strong>Notify 2</strong><br>
								<?php $party =  getName( $da_header['notify_1'] ) ?> 
									<?= !empty($party['party']) ? $party['party']: '' ?> <br>
							<?= !empty($party['address1']) ? $party['address1'] : '' ?><br>
							<?= !empty($party['address2']) ? $party['address2'] : ''?><br>
							<?= !empty($party['address3']) ? $party['address3'] : '' ?><br>
							<?= !empty($party['fax']) ? $party['fax'] : '' ?> <?= !empty($party['phone']) ? $party['phone'] : '' ?>

							</p>
						</td>
						<td>Despatch Instruction: <span><?= $da_header['despatching_instructions'] ?></span></td>
					</tr>
					<tr>
						<td>Month Of Sale <span><?= $da_header['month_of_sale'] ?></span></td>
					</tr>
					<tr>
						<td>Specification (if any):<br/>
							<?= $da_header['specifications'] ?></td>
						</tr>
						<tr>
							<td rowspan="2" valign="top">Special Instructions:<br/>
								<?= $da_header['special_instructions'] ?>
							</td>

							<td>Shipping Marks:<br/>
								<?= $da_header['shipping_marks'] ?>
							</td>
						</tr>
						<tr>
							<td>Labels: <?= $da_header['label_name'] ?> <p>&nbsp;</p></td>
						</tr>
						<tr>
							<td valign="top">Mode of Shipment:<span><?= $da_header['shippingmode'] ?></span> <br/> Documents Required:<span><?php if(!empty($da_document)) { 
								foreach($da_document as $document) { 
									echo $document['documents_required'].', ' ;

								}  } ?></span></td>
								<td class="bottomBorderNone" valign="top">Despatch to <span><?= $da_header['despatchto'] ?></span> </td>
							</tr>
							<tr>
								<td><p>Agent <span><?= $da_header['agent_name'] ?></span></p></td><td><p>Transport Mode to CHA <span><?= $da_header['transportmodetocha'] ?></span></p></td>
							</tr>



						</table></td>
					</tr>
					<tr>
						<td class="noPadding"><table class="invoice" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<th width="20%" align="left" style="vertical-align:top;">No. &amp; Kind of Packages</th>
								<th width="26%" align="center" style="vertical-align:top;">Description of Goods</th>
								<th width="14%" style="text-align: right; vertical-align:top;">Quantity</th>
								<th width="20%" style="text-align: right; vertical-align:top;">Rate <br/>
								<?= $da_header['currency_name'] ?></th>
								<th width="20%" style="text-align: right; vertical-align:top;">Amount<br/>
								<?= $da_header['currency_name'] ?></th>
							</tr>
							<?php if(!empty($da_items) ) {
                                     $counter = 0;
                                     $sum = 0;
                                     foreach($da_items as $daitems) {
                                     $sum+= $daitems['amount'];
                            ?>
							<tr>
								<td align="left"><?= $daitems['kindofpackages'] ?></td>
								<td align="left"><?= $daitems['product_name'].' '. $daitems['productform'].' HS CODE: '.$daitems['hscode']?></td>
								<td align="right"><?= $daitems['quantity'] ?></td>
								<td align="right"><?= $daitems['rate'] ?></td>
								<td align="right" style="border:none;"><?= $daitems['amount'] ?></td>
							</tr>
						    <?php } } ?>
						</table></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Amount Chargeable(in words)):
							 <span> <?= $da_header['currency_name'] ?></span> 
							 <span style="padding: 0 0 0 10px; width: 54% !important; display: inline-flex;"><?= convert_number(!empty($sum) ? $sum: 0)?> Only 
							 </span>
						
						    <span style="float:right">
						    	<strong><?=  !empty($da_items) ? number_format((float) $sum , 2, '.', '') : '' ?></strong>
						    </span>
						</td>
					</tr>
					<tr>
						<td class="noPadding"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="noBorder">
							<tr>
								<td width="66%" valign="top">Advance Lic. No <?= $da_header['advance_lic_no'] ?> <br/>
									Exchange Rate <span><?= $da_header['exchange_rate'] ?></span><br/>
									GST Amount <span><?= $da_header['gst_amt'] ?></span><br/>
								   Bank Details  <?= $da_header['bank_details'] ?></td>
								<td width="34%" valign="top">ECGC <?= $da_header['ecgc'] ?></td>
							</tr>
						</table></td>
					</tr>
					<tr>
						<td class="noPadding"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="invoice">
							<tr style="border-bottom: 1px solid #000;">
								<th align="right" style="text-align: right;">Freight</th>
								<th align="right" style="text-align: right;">Logistic Charges</th>
								<th align="right" style="text-align: right;">FOB Rate</th>
								<th align="right" style="text-align: right;">Comm.%</th>
								<th align="right" style="text-align: right;">Comm. Amount</th>
								<th align="right" style="text-align: right;">Qty Discount</th>
								<th align="right" style="text-align: right;">Net Price per Kg.</th>
							</tr>
							<?php if(!empty($da_items) ) {
                                $counter = 0;
                                foreach($da_items as $daitems) {
                            ?>
							<tr>
							    <td align="right"><?= $daitems['freight'] ?></td>
                                <td align="right"><?= $daitems['logistic'] ?></td>
                                <td align="right"><?= $daitems['fob_rate'] ?></td>
                                <td align="right"><?= $daitems['commission_per'] ?></td>
                                <td align="right"><?= $daitems['commission_amount'] ?></td>
                                <td align="right"><?= $daitems['quantity_discount'] ?></td>
                                <td align="right" style="border:none;"><?= $daitems['net_price'] ?></td>
							</tr>
						     <?php } }   else {?> 
                             <tr>
		                         
		                         <td align="right">&nbsp;</td>
		                         <td align="right">&nbsp;</td>
		                         <td align="right">&nbsp;</td>
		                         <td align="right">&nbsp;</td>
		                         <td align="right">&nbsp;</td>
		                         <td align="right">&nbsp;</td>
		                         <td align="right" style="border:none;">>&nbsp;</td>
		                        </tr>
                            <?php } ?>
						</table></td>
					</tr>
					<?php if(!empty($da_header['declaration1'])) { ?>
						<tr>
							<td><?= $da_header['declaration1'] ?></td>
						</tr>
					<?php } ?>
					
					<tr>
						<td class="noPadding"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="noBorder">
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td> 
							</tr>  
							<tr>
                              <td>
                                <span class="text-primary" style="padding-left: 0; color:#000080 !important;"><?= !empty($da_header['license_check_by']) ?  'CHECKED': '' ?> </span>
                                   <br/>  Licensed Checked By </br>
                                    <?php $signature= getSignature($da_header['license_check_by']); ?>
                                     <?= !empty($signature) ? $signature['username'] : '' ?><br>
                                    <div style="height: 50px; width: 150px;">
                        
                                  	 <?php if(!empty($da_header['license_check_by']) && !empty($signature['signature']) ) { ?>
                                        <img style="height: 48px; width: 148px;" src="<?=  base_url().'resources/employee-signature/'.$signature['signature'] ?>" alt="signature">
                                     <?php } ?>
                                  </div>
                                </td>
                                <td>
                                    <span class="text-primary" style="padding-left: 0; color:#000080 !important;"><?= !empty($da_header['prepared_by']) ?  'CHECKED': '' ?> </span> 
                                    <br/>Prepared By</br>
                                    <?php $signature= getSignature($da_header['prepared_by']); ?>
                                     <?= !empty($signature) ? $signature['username'] : '' ?><br>
                                    <div style="height: 50px; width: 152px;">
                                    <?php if(!empty($da_header['prepared_by']) && !empty($signature['signature']) ) { ?>
                                      <img style="height: 48px; width: 148px;" src="<?=  base_url().'resources/employee-signature/'.$signature['signature'] ?>" alt="signature">
                                     <?php } ?>
                                     </div>
                                </td>
                                <td>
                                 <?php if(!empty($da_header['checked_by'])) { ?>
                                    <span class="text-primary" style="padding-left: 0; color:#000080 !important;"><?= !empty($da_header['checked_by']) ?  'CHECKED': '' ?></span> <?php } ?>
                                     <br/>Checked By </br> 
                                     <?php $signature= getSignature($da_header['checked_by']); ?>
                                     <?= !empty($signature) ? $signature['username'] : '' ?><br>
                                      <div style="height: 50px; width: 150px;">
                                       <?php if(!empty($da_header['checked_by']) && !empty($signature['signature']) ) { ?>
                                        <img style="height: 48px; width: 148px;" src="<?=  base_url().'resources/employee-signature/'.$signature['signature'] ?>" alt="signature">
                                      <?php } ?>
                                     </div>
                                       
                                </td>
                                <td>
                                    <span class="text-primary" style="padding-left: 0; color:#000080 !important;"><?= !empty($da_header['ecgc_checked_by']) ?  'CHECKED': '' ?> </span><br/> ECGC Checked By  </br> 
                                    <?php $signature = getSignature($da_header['ecgc_checked_by']); ?>
                                     <?= !empty($signature) ? $signature['username'] : '' ?><br>
                                    <div style="height: 50px; width: 150px;">
                                    <?php if(!empty($da_header['ecgc_checked_by']) && !empty($signature['signature']) ) { ?>
                                        <img style="height: 48px; width: 148px;" src="<?=  base_url().'resources/employee-signature/'.$signature['signature'] ?>" alt="signature">
                                      <?php } ?>
                                    </div>

                                </td>
                                <td>
                                  <span class="text-primary" style="padding-left: 0; color:#000080 !important;"></span><br/>
                                       Ordered By</br>
                                      <?php $signature = getSignature($da_header['ordered_by']); ?>
                                     <?= !empty($signature) ? $signature['username'] : '' ?><br>
                                     <div style="height: 50px; width: 150px;">
                                      <?php if(!empty($da_header['ordered_by']) && !empty($signature['signature']) ) { ?>
                                        <img style="height: 48px; width: 148px;" src="<?=  base_url().'resources/employee-signature/'.$signature['signature'] ?>" alt="signature">
                                      <?php } ?>
                                     </div>
                              
                                </td>
                                <td>
                                    <span class="text-primary" style="padding-left: 0; color:#000080 !important;"><?= !empty($da_header['approved_by']) ?  'APPROVED': '' ?>
                                    </span> 
                                    <br/> Approved By </br>
                                    <?php $signature= getSignature($da_header['approved_by']); ?>
                                     <?= !empty($signature) ? $signature['username'] : '' ?><br>
                                     <div style="height: 50px; width: 150px;">
                                      <?php if(!empty($da_header['approved_by']) && !empty($signature['signature']) ) { ?>
                                        <img style="height: 48px; width: 148px;" src="<?=  base_url().'resources/employee-signature/'.$signature['signature'] ?>" alt="signature">
                                      <?php } ?>
                                     </div>
                               </td>
                            </tr>
						</table></td>
					</tr><tr>
						<td class="noPadding"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="noBorder">
							<tr>
								<td colspan="4">A.D. Code Suggested by Finance &amp; Accounts Deptt.   <label style="border:1px solid #000; margin-left:50px; display:inline-block; width:250px; height:30px;" > &nbsp;</label></td>
							</tr>
							<td colspan="4">&nbsp;</td>
						</tr>
						<tr>
							<td>O/S Payment Review <br/>Devinder Singh Rana</td>
							<td>Approved By<br/>R. K. Aggarwal</td>
							<td>Final Approval Given By<br/>Amit Chadah (President)</td>
							<!-- <td align="right" valign="bottom">ARYAN GOYAL(ED)</td> -->
						</tr>
					</table></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>

			</table>
		</div>
	</div>