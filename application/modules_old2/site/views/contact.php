
			<div role="main" class="main shop">

				<section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<?php echo $this->site_model->get_breadcrumbs();?>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1><?php echo $title;?></h1>
							</div>
						</div>
					</div>
				</section>

				
				<div class="container">
					
					<div class="row">
						<div class="col-md-6">

							<?php
							$success_message = $this->session->userdata('success_message');
							$this->session->unset_userdata('success_message');
							
							if(!empty($success_message))
							{
								echo '<div class="alert alert-success">'.$success_message.'</div>';
							}
							
							$error_message = $this->session->userdata('error_message');
							$this->session->unset_userdata('error_message');
							if(!empty($error_message))
							{
								echo '<div class="alert alert-danger">'.$error_message.'</div>';
							}
							?>

							<h2 class="mb-sm mt-sm"><strong>Contact</strong> Us</h2>
                             <?php
								$attributes = array(
												'class' => 'form-horizontal',
												'role' => 'form',
											);
								echo form_open($this->uri->uri_string(), $attributes);
							?>
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<label>Your name *</label>
                                            <?php
												//case of an input error
												if(!empty($sender_name_error))
												{
													?>
													<input type="text" value="<?php echo $sender_name;?>"  maxlength="100" class="form-control alert-danger" name="sender_name" id="sender_name" placeholder="<?php echo $sender_name_error;?>" onFocus="this.value = '<?php echo $sender_name;?>';">
													<?php
												}
												
												else
												{
													?>
													<input type="text" value="<?php echo $sender_name;?>"  maxlength="100" class="form-control" name="sender_name" id="sender_name" placeholder="Name">
													<?php
												}
											?>
										</div>
										<div class="col-md-6">
											<label>Your email address *</label>
                                            <?php
												//case of an input error
												if(!empty($sender_email_error))
												{
													?>
													<input type="text" class="form-control alert-danger" name="sender_email" placeholder="<?php echo $sender_email_error;?>" onFocus="this.value = '<?php echo $sender_email;?>';" maxlength="100">
													<?php
												}
												
												else
												{
													?>
													<input type="text" class="form-control" name="sender_email" placeholder="Email" value="<?php echo $sender_email;?>" maxlength="100">
													<?php
												}
											?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Phone</label>
											<?php
												//case of an input error
												if(!empty($sender_phone_error))
												{
													?>
													<input type="text" class="form-control alert-danger" name="sender_phone" placeholder="<?php echo $sender_phone_error;?>" onFocus="this.value = '<?php echo $sender_phone;?>';">
													<?php
												}
												
												else
												{
													?>
													<input type="text" class="form-control" name="sender_phone" placeholder="Phone" value="<?php echo $sender_phone;?>">
													<?php
												}
											?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Message *</label>
                                            <?php
												//case of an input error
												if(!empty($message_error))
												{
													?>
													<textarea maxlength="5000" class="form-control alert-danger" name="message" onFocus="this.value = '<?php echo $message;?>';" placeholder="<?php echo $message_error;?>"></textarea>
													<?php
												}
												
												else
												{
													?>
													<textarea maxlength="5000" class="form-control" name="message" placeholder="Message"><?php echo $message;?></textarea>
													<?php
												}
											?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<input type="submit" value="Send Message" class="btn btn-primary btn-lg mb-xlg" data-loading-text="Loading...">
									</div>
								</div>
							<?php echo form_close();?>
						</div>
                        
						<div class="col-md-6">

							<h4 class="heading-primary mt-lg">Get in <strong>Touch</strong></h4>
							<p>We would love to hear from you</p>

							<hr>

							<h4 class="heading-primary">The <strong>Office</strong></h4>
							<ul class="list list-icons list-icons-style-3 mt-xlg">
								<li><i class="fa fa-map-marker"></i> <strong>Address:</strong> Liasion House Statehouse avenue, Nairobi, Kenya/li>
								<!--<li><i class="fa fa-phone"></i> <strong>Phone:</strong> (123) 456-7890</li>-->
								<li><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:info@Dobi.co.ke">info@Dobi.co.ke</a></li>
							</ul>

							<hr>

							<!--<h4 class="heading-primary">Business <strong>Hours</strong></h4>
							<ul class="list list-icons list-dark mt-xlg">
								<li><i class="fa fa-clock-o"></i> Monday - Friday 9am to 5pm</li>
								<li><i class="fa fa-clock-o"></i> Saturday - 9am to 2pm</li>
								<li><i class="fa fa-clock-o"></i> Sunday - Closed</li>
							</ul>-->

						</div>

					</div>

				</div>

			</div>