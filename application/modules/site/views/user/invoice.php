<?php
$customer_details = $this->orders_model->get_customer($this->session->userdata('customer_id'));

if($customer_details->num_rows() > 0)
{
	$row = $customer_details->row();
	$customer_first_name = $row->customer_first_name;
	$customer_surname = $row->customer_surname;
}

$contacts = $this->site_model->get_contacts();
?>
        <div class="row">
        	<div class="col m12 center-align">
            	<img src="<?php echo base_url().'assets/logo/black.png';?>" class="responsive-img logo"/>
            </div>
        </div>
    	<div class="row">
        	<div class="col m12 center-align receipt_bottom_border">
            	<strong>
                	<?php echo $contacts['company_name'];?><br/>
                    P.O. Box <?php echo $contacts['address'];?> <?php echo $contacts['post_code'];?>, <?php echo $contacts['city'];?><br/>
                    E-mail: <?php echo $contacts['email'];?>. Tel : <?php echo $contacts['phone'];?><br/>
                </strong>
            </div>
        </div>
        
      	<div class="row receipt_bottom_border" >
        	<div class="col m12 center-align">
            	<strong>INVOICE</strong>
            </div>
        </div>
        
        <!-- Patient Details -->
    	<div class="row receipt_bottom_border" style="margin-bottom: 10px;">
        	<div class="col m12">
            	<div class="row">
                	<div class="col m4">
                    	
                    	<div class="title-item">Customer First Name:</div>
                        
                    	<?php echo $customer_first_name; ?>
                    </div>
                    
                	<div class="col m4">
                    	<div class="title-item">Customer Last Name:</div>
                        
                    	<?php echo $customer_surname; ?>
                    </div>
            
                    <div class="col m4">
                        <div class="title-item">Invoice Status:</div>
                        <?php echo $order_status_name; ?>
                    </div>
                </div>
            
            </div>
            
        	<div class="col m12">
            	<div class="row">
                	<div class="col m6">
                    	<div class="title-item">Invoice Date:</div>
                        
                    	<?php echo date('jS M Y', strtotime($order_date)); ?>
                    </div>
                    
                	<div class="col m6">
                    	<div class="title-item">Invoice Number:</div>
                        
                    	<?php echo $order_number; ?>
                    </div>
                </div>
                
            </div>
        </div>
        
    	<div class="row receipt_bottom_border">
        	<div class="col m12 center-align">
            	<strong>BILLED ITEMS</strong>
            </div>
        </div>
        
    	<div class="row">
        	<div class="col m12">
                <table class="table table-hover table-bordered table-striped col m12">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Plan Name</th>
                      <th>Units</th>
                      <th>Unit Cost ($)</th>
                      <th>Total ($)</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $total = 0;
						
						if($order_items_query->num_rows() > 0)
						{
							foreach($order_items_query->result() as $res3)
							{
								$count++;
								$plan_name = $res3->plan_name;
								$order_item_quantity = $res3->order_item_quantity;
								$order_item_price = $res3->order_item_price;                
								?>
								<tr>
									<td><?php echo $count;?></td>
									<td><?php echo $plan_name;?></td>
									<td><?php echo number_format($order_item_quantity);?></td>
									<td><?php echo number_format($order_item_price,2);?></td>
									<td><?php echo number_format(($order_item_quantity * $order_item_price), 2);?></td>
								</tr>
								<?php
								$total += ($order_item_price * $order_item_quantity);
							}
						}
						?>
                        <tr>
                            <th colspan="4" align="right">Total</th>
                            <th><?php echo number_format($total,2);?></th>
                        </tr>
                    </tbody>
                  </table>
            </div>
        </div>
        
    	<div class="row" style="font-style:italic; font-size:11px;">
        	<div class="col m12 pull-right">
            	<?php echo date('jS M Y H:i a'); ?> Thank you
            </div>
        </div>