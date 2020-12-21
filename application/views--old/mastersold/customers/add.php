<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?>
 <ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Masters</li>
   <li class="breadcrumb-item"><a href="<?=base_url()?>masters/customer">Customer</a></li>
   <li class="breadcrumb-item active">Add Customer</li>
</ol>

 <div class="card mb-3">
				
    <div class="card-header">
		<form method="POST"  action="<?=base_url()?>masters/customer_add">
		  
		   <!--
		      // party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr
		      -->
		   <div class="form-group">
		      <label for="email">Party:</label>
		      <input type="text" name="party" class="form-control" placeholder="Add Party Name" id="party" value="<?= set_value('party') ?>">
		      <?= form_error('party') ?>
		   </div>
		   <div class="form-group">	
		      <label for="email">Address 1:</label>
		      <input type="text" name="address1" class="form-control" placeholder="Add Address 1" id="address1" value="<?= set_value('address1')?>">  
		      <?= form_error('address1') ?>
		   </div>
		   <div class="form-group">	
		      <label for="email">Address 2:</label>
		      <input type="text" name="address2" class="form-control" placeholder="Add Address 2" id="address2" value="<?= set_value('address2' )?>"> 
		      <?= form_error('address2') ?> 
		   </div>
		   <div class="form-group">	
		      <label for="email">Address 3:</label>
		      <input type="text" name="address3" class="form-control" placeholder="Add Address 3" id="address3" value="<?= set_value('address3' ) ?>">  
		      <?= form_error('address3') ?>
		   </div>
		   <div class="form-group">	
		      <label for="email">Phone:</label>
		      <input type="text" name="phone" class="form-control" placeholder="Add Phone" id="phone" value="<?= set_value('phone') ?>">  
		      <?= form_error('phone') ?>
		   </div>
		   <div class="form-group">	
		      <label for="email">Fax:</label>
		      <input type="text" name="fax" class="form-control" placeholder="Add Fax" id="fax" value="<?= set_value('fax' ) ?>">  
		      <?= form_error('fax') ?>
		   </div>
		   <div class="form-group">	
		      <label for="email">Bank Details:</label>
		      <input type="text" name="bankdetails" class="form-control" placeholder="Add Bank Details" id="bankdetails" value="<?= set_value('bankdetails') ?>">  
		       <?= form_error('bankdetails') ?>
		   </div>
		   <div class="form-group">	
		      <label for="email">ECGC INR:</label>
		      <input type="text" name="ecgcinr" class="form-control" placeholder="Add ECGC INR" id="ecgcinr" value="<?= set_value('ecgcinr') ?>">
		      <?= form_error('ecgcinr') ?>
		   </div>
		   <button type="submit" class="btn btn-primary">Submit</button>
		   <?= anchor('masters/customer', 'Cancel', 'class="btn btn-primary"') ?>
		</form>
	</div>
</div>