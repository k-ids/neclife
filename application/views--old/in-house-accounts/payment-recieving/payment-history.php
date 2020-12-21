<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
 <li class="breadcrumb-item">In House Account</li>
 <li class="breadcrumb-item">
   <a href="<?= base_url(). $this->router->fetch_class() . '/payment_receiving' ?>">DA Payment Received</a></li>
   <li class="breadcrumb-item">History</li>
 </ol>
 <!-- Example Tables Card -->

 <div class="card mb-3">
   <div class="card-block">

        <div style="background: chartreuse;padding: 2px 0 2px 0px;">
           <h5 class="text-center"><b>Invoice Payment</b></h5>
           <h5 class="text-center"><b>DA No.</b> <?= $invoice_payment['da_name'] ?></h5>
           <h5 class="text-center"><b>Invoice No.</b> <?= $invoice_payment['invoice_no'] ?></h5>
           <h5 class="text-center"><b>Total Amount:</b> <?= $invoice_payment['currency_name'].' '.$invoice_payment['total_amount'] ?></h5>

           <hr>
         
           <h5 class="text-center"><b>Billed Date:</b> <?= nice_date($invoice_payment['air_bill_date'], 'd-M-Y') ?></h5>
           <h5 class="text-center"><b>Due Date:</b> <?= nice_date($invoice_payment['due_date'], 'd-M-Y') ?></h5>
           <h5 class="text-center"><b>Status:</b> <?= !empty($invoice_payment['status'] == 1) ? 'Outstanding' : 'Paid' ?></h5>           
        </div>
        <br>
     
     <?php if($invoice_payment['status'] != '2') { ?>

       <form method="POST" action="<?= base_url() . $this->router->fetch_class(). '/'. $this->router->fetch_method(). '/'.$this->uri->segment(3).'/'.$this->uri->segment(4)?>">

         <div class="row">

          <div class="form-group col-md-4">
            <label>Air Billed Date:</label>
            <input class="form-control" type="text" name="air_billed_date" value="" required id="billed_date">
            <?= form_error('air_billed_date') ?>
          </div>

          <div class="form-group col-md-4">
            <label>Due Date upto:</label>
            <input type="number" id="days" name="days" placeholder="Days" class="form-control" required />
            <?= form_error('days') ?>
          </div>

          <div class="form-group col-md-4">
             <label>Due Date:</label>
              <input class="form-control" type="text" name="due_date" value="" required id="due_date" >
              <?= form_error('due_date') ?>
          </div>
          <input type="hidden" name="date_form" value="1">
         </div>

         <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Add Date</button>

         <button type="button" onclick="window.location.reload();" class="btn btn-warning"><i class="fa fa-floppy-o"></i>&nbsp;Cancel</button>

       </form>

     <?php } ?>



  </div>
</div>
<style>
 table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
 <div class="card mb-3">
   <div class="card-block">

     <div>
       <h5 class="text-center"><b>Transaction Records</b></h5>
     </div><br>
     
     <div class="">
        <?php if(!empty($invoice_payment_map)) { ?>
          <table>
            <tr>
              <th>S.NO</th>
              <th>Total Amount</th>
              <th>Amount Paid</th>
              <th>Balance Amount</th>
              <th>Payment Remarks</th>
              <th>Date</th>
            </tr>
            <?php 
              $counter = 0;
              foreach ($invoice_payment_map as $key => $value) { ?>
              <tr>
                <td><?= ++$counter ?></td>
                <td><?= $value['total_amount'] ?></td>
                <td><?= $value['amount_pay'] ?></td>
                <td><?= $value['balance_amount'] ?></td>
                <td><?= $value['payment_remarks'] ?></td>
                <td><?= nice_date($value['date'], 'd-M-Y') ?></td>
              </tr>
          <?php } ?>
        </table>
      <?php } else { ?>
        <h6 class="text-center text-danger">No Record available.</h6>
      <?php } ?>
     </div>

    </div>
</div>

 <div class="card mb-3">
   <div class="card-block">

    <div class="">
       <h5 class="text-center">Add Transaction Record</h5>
    </div> <br>

<?php if($invoice_payment['balance'] > 0) { ?>

   <form method="POST" action="<?= base_url() . $this->router->fetch_class(). '/'. $this->router->fetch_method(). '/'.$this->uri->segment(3).'/'.$this->uri->segment(4)?>">
      <div class="row">

        <div class="col-md-6 form-group">
          <label>Payment Recieved:</label>
          <input type="text" name="amount_pay" class="form-control" required>
          <?= form_error('amount_pay') ?>
        </div>

        <div class="col-md-6 form-group">
          <label>Payment Remarks:</label>
           <input type="text" name="payment_remarks" class="form-control" required>
           <?= form_error('payment_remarks') ?>
        </div>
         
         <input type="hidden" name="payment_form" value="1">
         <input type="hidden" name="total_amount" value="<?= $invoice_payment['total_amount'] ?>">
         <input type="hidden" name="bal_amount" value="<?= $invoice_payment['balance'] ?>">
      </div>
     

        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;Add Payment</button>

        <button type="button" onclick="window.location.reload();" class="btn btn-warning"><i class="fa fa-floppy-o"></i>&nbsp;Cancel</button>
    </form>

<?php } else {?>
         <h5 class=" text-center text-success">All Amount has been cleared for this invoice.</h4>
<?php } ?>
</div>
 
</div>