<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
   <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
   <li class="breadcrumb-item">Utilities</li>
   <li class="breadcrumb-item">Contact Admin</li>

   </li>
</ol>


<div class="card mb-3">
   <div class="card-header">
      <i class="fa fa-table" style="color: green;"></i> <b>Contact Admin</b>
   </div>
  <div class="card-block">
     <?php echo form_open($this->router->fetch_class().'/contact_admin');?>

        <div class="row">
          <div class="col-md-12 form-group">
            <label>Write a message to admin for support.</label>
              <textarea name="message" rows="10" cols="5" required class="form-control"><?= set_value('message') ?></textarea>
          </div>
        </div>

       <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i>&nbsp;Send Message</button>

      <?php echo form_close();?>
    </div>
</div>

