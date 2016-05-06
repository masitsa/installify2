          
          <section class="panel">
                <header class="panel-heading">
                   
            
                    <h2 class="panel-title"><?php echo $title;?></h2>
                     <a href="<?php echo site_url();?>users/customers" class="btn btn-info btn-sm pull-right" style="margin-top:-25px;">Back to customers</a>
                </header>
                <div class="panel-body">
                        
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			$customer_first_name = $customer[0]->customer_first_name;
			$customer_surname = $customer[0]->customer_surname;
			$customer_email = $customer[0]->customer_email;
			$customer_id = $customer[0]->customer_id;
			$customer_phone = $customer[0]->customer_phone;
			$customer_discount = $customer[0]->customer_discount;
			
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
				$customer_first_name = set_value('customer_first_name');
				$customer_surname = set_value('customer_surname');
				$customer_email = set_value('customer_email');
				$customer_id = set_value('customer_id');
				$customer_phone = set_value('customer_phone');
				$customer_discount = set_value('customer_discount');
            }
            
            $success = $this->session->userdata('success_message');
            
            if(!empty($success))
            {
                echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
				$this->session->unset_userdata('success_message');
            }
            
            $error = $this->session->userdata('error_message');
            
            if(!empty($error))
            {
                echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
				$this->session->unset_userdata('error_message');
            }
            ?>
            
            <?php echo form_open('users/user-account/'.$customer_id, array("class" => "form-horizontal", "role" => "form"));?>
            <div class="row">
            	<div class="col-md-12">
            		<div class="col-md-6">
            			  <!-- First Name -->
				            <div class="form-group">
				                <label class="col-lg-4 control-label">First Name</label>
				                <div class="col-lg-8">
				                	<input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php echo $customer_first_name;?>">
				                </div>
				            </div>
				            <!-- Other Names -->
				            <div class="form-group">
				                <label class="col-lg-4 control-label">Other Names</label>
				                <div class="col-lg-8">
				                	<input type="text" class="form-control" name="other_names" placeholder="Other Names" value="<?php echo $customer_surname;?>">
				                </div>
				            </div>
            		</div>
            		<div class="col-md-6">
            			<!-- Email -->
			            <div class="form-group">
			                <label class="col-lg-4 control-label">Email</label>
			                <div class="col-lg-8">
			                	<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $customer_email;?>">
			                </div>
			            </div>
			            
			            <!-- customer_phone -->
			            <div class="form-group">
			                <label class="col-lg-4 control-label">Phone</label>
			                <div class="col-lg-8">
			                	<input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo $customer_phone;?>">
			                </div>
			            </div>

            		</div>
            	</div>
            	
            </div>
             <br />
          	<div class="row">
          		<div class="form-actions center-align">
			            <!-- customer_phone -->
			            <div class="form-group">
			                <label class="col-lg-4 control-label">Customer Discount %</label>
			                <div class="col-lg-6">
			                	<input type="text" class="form-control" name="customer_discount" placeholder="Discount 5" value="<?php echo $customer_discount;?>">
			                </div>
			            </div>	            
			    </div>
          		
          	</div>
              <br />

          	<div class="row">
          		<div class="form-actions center-align">
	                <button class="submit btn btn-primary" type="submit">
	                    Edit Administrator
	                </button>
	            </div>
          		
          	</div>
            
           
            
          
            <?php echo form_close();?>
                </div>
            </section>