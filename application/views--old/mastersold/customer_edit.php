<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo validation_errors(); ?>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                <li class="breadcrumb-item">Masters</li>
                <li class="breadcrumb-item"><a href="<?=base_url()?>masters/customer">Customer</a></li>
                <li class="breadcrumb-item active">Edit Customer</li>
            </ol>

        <form method="POST" id="collapseExample" class="collapse" action="<?=base_url()?>masters/customer_add">
						<input type="hidden" name="action" value="add">
						<!--
						 // party 	address1 	address2 	address3 	phone 	fax 	bankdetails 	ecgcinr
						 -->
						<div class="form-group">
							<label for="email">Party:</label>
							<input type="text" name="party" class="form-control" placeholder="Enter Party Name" id="party">
						</div>
						<div class="form-group">	
							<label for="email">Address 1:</label>
							<input type="text" name="address1" class="form-control" placeholder="Add Address 1" id="address1">  
						</div>
						<div class="form-group">	
							<label for="email">Address 2:</label>
							<input type="text" name="address2" class="form-control" placeholder="Add Address 2" id="address2">  
						</div>
						<div class="form-group">	
							<label for="email">Address 3:</label>
							<input type="text" name="address3" class="form-control" placeholder="Add Address 3" id="address3">  
						</div>
						<div class="form-group">	
							<label for="email">Phone:</label>
							<input type="text" name="phone" class="form-control" placeholder="Add Phone" id="phone">  
						</div>
						<div class="form-group">	
							<label for="email">Fax:</label>
							<input type="text" name="fax" class="form-control" placeholder="Add Fax" id="fax">  
						</div>
						<div class="form-group">	
							<label for="email">Bank Details:</label>
							<input type="text" name="bankdetails" class="form-control" placeholder="Add Bank Details" id="bankdetails">  
						</div>
						<div class="form-group">	
							<label for="email">ECGC INR:</label>
							<input type="text" name="ecgcinr" class="form-control" placeholder="Add ECGC INR" id="ecgcinr">
						</div>
						
						<button type="submit" class="btn btn-primary">Submit</button>
					</form> 

 
