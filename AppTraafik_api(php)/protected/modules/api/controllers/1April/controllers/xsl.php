
<?php $this->load->view ('header');?>
<!--form end-->

<section class="form-section">
  <div class="container">
    <div class="row text-center">
     
    
     </div>
     <div class="row">
      <div class="booking-form">
             <?php echo form_open_multipart('home/xsl_upload');?>
           
			<div class="form-group col-sm-6 npr">
			
            <label class="control-label">Passport or Identity Card</label>
           <input type='file' class='form-control' name='userfile[0]' size='20' />"; 
           </div>
       
          
               
             <div class="submit-btn">
          <button type="submit" class="btn btn-default submited-btn">Submit</button>
        </div>
        </form> 
        
        
				
      </div>
    </div>
     </div>
  </section>

<!--form end-->
<?php $this->load->view ('footer');?>
  