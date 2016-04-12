<?php 
$v_data['order_status_query'] = $order_status_query;
echo $this->load->view('vendor/search/search_orders', '' , TRUE); ?>
<?php

		$error = $this->session->userdata('error_message');
		$success = $this->session->userdata('success_message');
		$search_result ='';
		$search_result2  ='';
		if(!empty($error))
		{
			$search_result2 = '<div class="alert alert-danger">'.$error.'</div>';
			$this->session->unset_userdata('error_message');
		}
		
		if(!empty($success))
		{
			$search_result2 ='<div class="alert alert-success">'.$success.'</div>';
			$this->session->unset_userdata('success_message');
		}
				
		$search = $this->session->userdata('orders_search');
		
		if(!empty($search))
		{
			$search_result = '<a href="'.site_url().'vendor/close-orders-search" class="btn btn-danger">Close Search</a>';
		}


		$result = '<div class="padd">';	
		$result .= ''.$search_result2.'';
		$result .= '
					<div class="row" style="margin-bottom:8px;">
						<div class="pull-left">
						'.$search_result.'
						</div>
	            		<div class="pull-right">
							
						
						</div>
					</div>
				';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="example table-autosort:0 table-stripeclass:alternate table table-hover table-bordered " id="TABLE_2">
				  <thead>
					<tr>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Date Created</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Order Number</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Customer</th>
					  <th>Total Items</th>
					  <th>Order Total ($)</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Status</th>
					  <th colspan="2">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			//get all administrators
			$administrators = $this->users_model->get_all_administrators();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$order_id = $row->order_id;
				$order_number = $row->order_number;
				$order_status = $row->order_status_id;
				$order_instructions = $row->order_instructions;
				$order_status_name = $row->order_status_name;
				$created_by = $row->order_created_by;
				$created = $row->order_created;
				$modified_by = $row->order_modified_by;
				$last_modified = $row->order_last_modified;
				$user = $row->first_name.' '.$row->other_names;
				
				$order_details = $this->orders_model->get_order_items($order_id);
				$total_price = 0;
				$total_items = 0;
				//creators & editors
				if($admins != NULL)
				{
					foreach($admins as $adm)
					{
						$user_id = $adm->user_id;
						
						if($user_id == $modified_by)
						{
							$modified_by = $adm->first_name;
						}
					}
				}
				
				else
				{
					$modified_by = '-- Not modified --';
				}
				if($order_details->num_rows() > 0)
				{
					$items = '
					<p><strong>Last Modified:</strong> '.date('jS M Y H:i a',strtotime($last_modified)).'<br/>
					<strong>Modified by:</strong> '.$modified_by.'</strong></br>
					<strong>Instructions:</strong> '.$order_instructions.'</strong></p>
					
					<table class="table table-striped table-condensed table-hover">
					<tr>
						<th>Item</th>
						<th>Quantity</th>
						<th>Price ($)</th>
						<th>Added price ($)</th>
						<th>Total ($)</th>
					</tr>';
					$order_items = $order_details->result();
					$total_price = 0;
					$total_items = 0;
					
					foreach($order_items as $res)
					{
						$order_item_id = $res->order_item_id;
						$product = $res->product_name;
						$quantity = $res->order_item_quantity;
						$price = $res->order_item_price;
						$product_id = $res->product_id;
						$vendor_id = $res->vendor_id;
						$vendor_store_name = $res->vendor_store_name;
						$web_name = $this->site_model->create_web_name($vendor_store_name);
						$vendor_link = site_url().'businesses/'.$web_name.'&'.$vendor_id;
						$order_item_features = $this->orders_model->get_order_item_features($order_item_id);
						
						$total_items += $quantity;
						
						//display features
						$features_display = '';
						$cancel = '<a class="btn btn-sm btn-danger" href="'.site_url().'reverse-product/'.$product_id.'/'.$order_number.'">Reverse product</a>';
						$cancel = '';
						$total_additional_price = 0;
						
						if($order_item_features->num_rows() > 0)
						{
							$features_display = '<table class="table table-condensed">
								<tr>
									<th>Feature</th>
									<th>Selected</th>
									<th>Added price ($)</th>
								</tr>';
							foreach($order_item_features->result() as $feat)
							{
								$product_feature_id = $feat->product_feature_id;
								$added_price = $feat->additional_price;
								$feature_name = $feat->feature_name;
								$feature_value = $feat->feature_value;
								$feature_image = $feat->thumb;
								$total_additional_price += $added_price;
								
								$feature_location = base_url().'assets/images/products/features/';
								$feature_path = realpath(APPPATH . '../assets/images/products/features');
								$feature_image_display = $this->products_model->image_display($feature_path, $feature_location, $feature_image);
								
								//display feature images
								if($feature_image != 'None')
								{
									$features_display.= '
										<tr>
											<td>'.$feature_name.'</td>
											<td><img src="'.$feature_image_display.'" /></td>
											<td>'.number_format($added_price, 2).'</td>
										</tr>';
								}
								
								//display features in dropdown
								else
								{
									$features_display.= '
										<tr>
											<td>'.$feature_name.'</td>
											<td>'.$feature_value.'</td>
											<td>'.number_format($added_price, 2).'</td>
										</tr>';
								}
							}
							$features_display .= '
								<tr>
									<th></th>
									<th></th>
									<th>'.number_format($total_additional_price, 2).'</th>
								</tr>
							</table>';
						}
						
						$total_price += (($quantity*$price) + $total_additional_price);
						
						$items .= '
						<tr>
							<td>
							'.$product.'
							'.$features_display.'
							</td>
							<td>'.$quantity.'</td>
							<td>'.number_format($price, 2, '.', ',').'</td>
							<td>'.number_format($total_additional_price, 2, '.', ',').'</td>
							<td>'.number_format(($quantity*$price)+$total_additional_price, 2, '.', ',').'</td>
						</tr>
						';
					}
						
					$items .= '
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td colspan="4">'.number_format($total_price, 2, '.', ',').'</td>
						</tr>
					</table>
					';
				}
				
				else
				{
					$items = 'This order has no items';
				}
				
				$button = '';
				
				//pending order
				if($order_status == 0)
				{
					$status = '<span class="label label-info">'.$order_status_name.'</span>';
					$button = '<a href="'.site_url().'vendor/complete-order/'.$order_id.'" class="btn btn-info" onclick="return confirm(\'Do you really want to complete this order '.$order_number.'?\');">Complete</a>
					<a href="'.site_url().'vendor/cancel-order/'.$order_number.'" class="btn btn-danger pull-right" onclick="return confirm(\'Do you really want to cancel this order '.$order_number.'?\');">Cancel</a>';
					$button2 = '';
				}
				else if($order_status == 1)
				{
					$status = '<span class="label label-success">'.$order_status_name.'</span>';
					$button = '<a href="'.site_url().'vendor/cancel-order/'.$order_id.'" class="btn btn-danger" onclick="return confirm(\'Do you really want to cancel this order '.$order_number.'?\');">Cancel</a>';
					$button2 = '';
				}
				else if($order_status == 2)
				{
					$status = '<span class="label label-warning">'.$order_status_name.'</span>';
					$button = '';
				}
				else if($order_status == 6)
				{
					$status = '<span class="label label-danger">'.$order_status_name.'</span>';
					$button = '<a href="'.site_url().'vendor/cancel-order/'.$order_id.'" class="btn btn-danger" onclick="return confirm(\'Do you really want to cancel this order '.$order_number.'?\');">Cancel</a>';
					$button2 = '';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.date('jS M Y H:i a',strtotime($created)).'</td>
						<td>'.$order_number.'</td>
						<td>'.$user.'</td>
						<td>'.$total_items.'</td>
						<td>'.number_format($total_price, 2, '.', ',').'</td>
						<td>'.$status.'</td>
						<td>
							<!-- Button to trigger modal -->
							<a href="#user'.$order_id.'" class="btn btn-primary" data-toggle="modal">View</a>
							
							<!-- Modal -->
							<div id="user'.$order_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$order_number.'</h4>
										</div>
										
										<div class="modal-body">
											'.$items.'
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											'.$button.'
										</div>
									</div>
								</div>
							</div>
						</td>
						<td>'.$button.'</td>
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
					</div>
			';
		}
		
		else
		{
			$result .= "There are no orders";
		}
		$result .= '</div>';
		echo $result;
?>