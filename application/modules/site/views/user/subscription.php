<style type="text/css">
	.receipt_spacing{letter-spacing:0px; font-size: 12px;}
	.center-align{margin:0 auto; text-align:center;}
	
	.receipt_bottom_border{border-bottom: #888888 medium solid;}
	.row .col-md-12 table {
		border:solid #000 !important;
		border-width:1px 0 0 1px !important;
		font-size:10px;
	}
	.row .col-md-12 th, .row .col-md-12 td {
		border:solid #000 !important;
		border-width:0 1px 1px 0 !important;
	}
	.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td
	{
		 padding: 2px;
	}
	
	.title-item{float:left;width: 130px; font-weight:bold; text-align:right; padding-right: 20px;}
	.title-img{float:left; padding-left:30px;}
	img.logo{max-height:70px; margin:0 auto;}
</style>
<div class="row">
	<div class="col s12">
        <!-- title -->
        <div class="row">
            <div class="col s12">
                <h4 class="header center-align">Upgrade</h4>
            </div>
        </div>
        <!-- end title -->
        
        <div class="row">
        	<div class="col m12">
            	<?php
				$subscribed_plan_id = NULL;
				//check if customer has subscribed to any plans
				if($active_subscription->num_rows() > 0)
				{
					foreach($active_subscription->result() as $res2)
					{
						$subscription_id = $res2->subscription_id;
						$subscribed_plan_id = $res2->plan_id;
						$plan_name = $res2->plan_name;
						?>
						
						<p class="center-align">You are subscribed to the <span class="header"><?php echo $plan_name;?></span> plan</p>
						<?php
					}
				}
				?>
            </div>
        </div>
        
        <div class="row">
			<?php
			
			//check if customer has subscribed to any plans
			if($invoices->num_rows() > 0)
			{
				?>
                
					<div class="col m12">
						<h5 class="header">Change plan</h5>
						<div class="preloader_subscribe"></div>
						<div class="row">
							<?php
							//check if customer has subscribed to any plans
							if($plans->num_rows() > 0)
							{
								$count = 0;
								foreach($plans->result() as $res)
								{
									$count++;
									$plan_id = $res->plan_id;
									$plan_name = $res->plan_name;
									$plan_description = $res->plan_description;
									$plan_amount = $res->plan_amount;
									$class = 'installify-blue';
									if($subscribed_plan_id == $plan_id)
									{
										$class = 'installify-blue-lighten';
									}
									?>
									<div class="col s12 l4">
										<div class="card <?php echo $class;?>">
											<div class="card-content">
												<span class="card-title"><?php echo $plan_name;?></span>
												<p class="center-align" style="margin-top:10%"><?php echo number_format($plan_amount, 2);?> USD per month</p>
												<?php echo $plan_description;?>
											</div>
											<div class="card-action">
												<a href="<?php echo $plan_id?>" class="upgrade">Upgrade</a>
											</div>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
			
			else
			{
				?>
				<div id="preloader_subscribe"></div>
				<div class="row">
					<?php
					//check if customer has subscribed to any plans
					if($plans->num_rows() > 0)
					{
						$count = 0;
						foreach($plans->result() as $res)
						{
							$count++;
							$plan_id = $res->plan_id;
							$plan_name = $res->plan_name;
							$plan_description = $res->plan_description;
							$plan_amount = $res->plan_amount;
							$plan_id = $res->plan_id;
							$class = 'installify-blue';
							if($subscribed_plan_id == $plan_id)
							{
								$class = 'installify-blue-lighten';
							}
							?>
                            <div class="col s12 l4">
								<div class="card <?php echo $class;?>">
									<div class="card-content">
										<span class="card-title"><?php echo $plan_name;?></span>
										<p class="center-align" style="margin-top:10%"><?php echo number_format($plan_amount, 2);?> USD per month</p>
										<?php echo $plan_description;?>
									</div>
									<div class="card-action">
										<a href="<?php echo $plan_id?>" class="subscribe">Subscribe</a>
									</div>
								</div>
							</div>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
			?>
        </div>
        
	</div>
</div>

<!-- New card modal -->
<div id="newcard" class="modal modal-fixed-footer">
    <form class="form-horizontal sidebar_form" id="add_new_card" method="POST" action="<?php echo site_url().'site/account/add_card'?>">
        <div class="modal-content">
            <h4 class="header center-align">Add card</h4>
            <div class="row">
                <div class="input-field col m6">
                    <input type="text" name="card_number" id="card_number" size="20" autocomplete="off">
                    <label for="card_number">Card number <span class="required">*</span></label>
                </div>
                <div class="input-field col m6">
                    <input type="text"  name="card_cvc" id="card_cvc" size="4" autocomplete="off">
                    <label for="card_cvc">CVC <span class="required">*</span></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col m6">
                    <input type="text"  name="card_expiry_month" id="card_expiry_month" size="2">
                    <label for="card_expiry_month">Expiry month (MM)<span class="required">*</span></label>
                </div>
                <div class="input-field col m6">
                    <input type="text"  name="card_expiry_year" id="card_expiry_year" size="4">
                    <label for="card_expiry_year">Expiry year (YYYY)<span class="required">*</span></label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div id="expiry_year" class="center-align"></div>
            <div class="row">
                <div class="col m6">
                    <button type="button" class="modal-action modal-close waves-effect waves-green btn red" data-dismiss="modal">Close</button>
                </div>
                <div class="col m6">
                    <button type="submit" class="waves-effect waves-green btn blue" id="add_banner">Add card</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End new card modal -->