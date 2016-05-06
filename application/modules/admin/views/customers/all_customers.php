<?php
		
		$result = '';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th><a href="'.site_url().'admin/customers/customer_first_name/'.$order_method.'/'.$page.'">First name</a></th>
						<th><a href="'.site_url().'admin/customers/customer_last_name/'.$order_method.'/'.$page.'">Last name</a></th>
						<th><a href="'.site_url().'admin/customers/customer_email/'.$order_method.'/'.$page.'">Email</a></th>
						<th><a href="'.site_url().'admin/customers/customer_discount/'.$order_method.'/'.$page.'">Discount</a></th>
						<th><a href="'.site_url().'admin/customers/created/'.$order_method.'/'.$page.'">Registered</a></th>
						<th><a href="'.site_url().'admin/customers/last_login/'.$order_method.'/'.$page.'">Last login</a></th>
						<th colspan="5">Actions</th>
					</tr>
				</thead>
				  <tbody>
				  
			';
			
			foreach ($query->result() as $row)
			{
				$last_login = $row->last_login;
				$created = $row->created;
				$customer_id = $row->customer_id;
				$customer_first_name = $row->customer_first_name;
				$customer_first_name = $row->customer_first_name;
				$last_name = $row->customer_surname;
				$discount = $row->customer_discount;
				$email = $row->customer_email;
				$customer_status = $row->customer_status;
				
				if($discount == 0 || $discount == NULL)
				{
					$discount = '-';
				}
				else
				{
					$discount = $discount.'%';
				}
				//create deactivated status display
				if($customer_status == 0)
				{
					$status = '<span class="label label-default">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'users/activate-customer/'.$customer_id.'" onclick="return confirm(\'Do you want to activate '.$customer_first_name.'?\');" title="Activate '.$customer_first_name.'"><i class="fa fa-thumbs-up"></i></a>';
				}
				//create activated status display
				else if($customer_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'users/deactivate-customer/'.$customer_id.'" onclick="return confirm(\'Do you want to deactivate '.$customer_first_name.'?\');" title="Deactivate '.$customer_first_name.'"><i class="fa fa-thumbs-down"></i></a>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$customer_first_name.'</td>
						<td>'.$last_name.'</td>
						<td>'.$email.'</td>
						<td>'.$discount.'</td>
						<td>'.date('jS M Y H:i a',strtotime($created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($last_login)).'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'users/user-account/'.$customer_id.'" class="btn btn-sm btn-warning" >Account</a></td>
						<td>'.$button.'</td>
					
						<td><a href="'.site_url().'delete-customer/'.$customer_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$customer_first_name.'?\');" title="Delete '.$customer_first_name.'"><i class="fa fa-trash"></i></a></td>
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no customers";
		}
?>

						<section class="panel">
							<header class="panel-heading">
						
								<h2 class="panel-title"><?php echo $title;?></h2>
							</header>
							<div class="panel-body">
								<div class="table-responsive">
                                	
									<?php 
									$success = $this->session->userdata('success_message');
									$error = $this->session->userdata('error_message');
									
									if(!empty($success))
									{
										echo '<div class="alert alert-success">'.$success.'</div>';
										$this->session->unset_userdata('success_message');
									}
									
									if(!empty($error))
									{
										echo '<div class="alert alert-danger">'.$error.'</div>';
										$this->session->unset_userdata('error_message');
									}
									echo $result;
									?>
							
                                </div>
							</div>
                            
							<div class="panel-body">
                            	<?php if(isset($links)){echo $links;}?>
							</div>
                            
						</section>