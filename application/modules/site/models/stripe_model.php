<?php
require_once "./application/libraries/stripe-php-3.5.0/init.php";

class Stripe_model extends CI_Model 
{
	public function get_subscription($stripe_customer_id)
	{
		try {
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));

			$response = \Stripe\Customer::retrieve($stripe_customer_id)->subscriptions->all(array('limit'=>1));
			
			$data = $response->data;
			$stripe_subscription_id = $data[0]->id;
			$return['message'] = 'true';
			$return['response'] = $stripe_subscription_id;
			
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	public function get_single_subscription($stripe_customer_id, $stripe_subscription_id)
	{
		try {
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));
			
			$response = \Stripe\Customer::retrieve($stripe_customer_id);
			$subscription = $response->subscriptions->retrieve($stripe_subscription_id);
			
			$data = $subscription->data;
			$current_period_end = $subscription->current_period_end;
			$return['message'] = 'true';
			$return['response'] = $current_period_end;
			
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	
	public function cancel_subscription($stripe_customer_id, $stripe_subscription_id)
	{
		try {
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));
			
			$cu = \Stripe\Customer::retrieve($stripe_customer_id);
			$response = $cu->subscriptions->retrieve($stripe_subscription_id)->cancel(array('at_period_end' => TRUE));
			/*$cu = \Stripe\Customer::retrieve($stripe_customer_id);
			$subscription = $cu->subscriptions->retrieve($stripe_subscription_id);
			$subscription->cancel_at_period_end = TRUE;
			$subscription->save();
			
			$return['message'] = 'true';
			$return['response'] = 'Subscription cancelled successfully';*/
			
			if($response->id == $stripe_subscription_id)
			{
				$return['message'] = 'true';
				$return['response'] = 'Subscription cancelled successfully';
			}
			
			else
			{
				$return['message'] = 'false';
				$return['response'] = 'Unable to cancel subscription';
			}
			
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	
	public function create_subscription($stripe_customer_id, $plan_id, $current_period_end = NULL)
	{
		try {
			//get subscription details
			$query_sub = $this->subscription_model->get_plan($plan_id);
			$plan_name = '';
			
			if($query_sub->num_rows() > 0)
			{
				$row = $query_sub->row();
				$plan_name = $row->plan_name;
				$plan_amount = $row->plan_amount;
				$stripe_plan = $row->stripe_plan;
				
				if(!empty($stripe_plan) && ($plan_amount > 0) && ($plan_id > 1))
				{
					//echo "here";die();
					\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));
					//echo $stripe_customer_id;
					$cu = \Stripe\Customer::retrieve($stripe_customer_id);
					//var_dump($stripe_plan);
					
					if(!empty($current_period_end))
					{
						$response = $cu->subscriptions->create(array("plan" => $stripe_plan, "quantity" => 1, "trial_end" => $current_period_end));
					}
					
					else
					{
						$response = $cu->subscriptions->create(array("plan" => $stripe_plan, "quantity" => 1));
					}
							
					$stripe_subscription_id = $response->id;
					
					$this->session->set_userdata('success_message', 'You have successfully subscribed to the '.$plan_name.' plan');
					//subscribe customer
					if($this->subscription_model->subscribe_customer($this->session->userdata('customer_id'), $plan_id, $stripe_subscription_id))
					{
						//save invoice
						if($this->get_invoice($stripe_customer_id, $plan_id))
						{
							$return['message'] = 'true';
						}
						
						else
						{
							$return['message'] = 'true';
							$return['response'] = 'Unable to create an invoice. Please try again';
						}
					}
					
					else
					{
						$return['message'] = 'false';
						$return['response'] = 'Unable to save your plan. Please try again';
					}
				}
				
				else
				{
					//subscribe customer
					if($this->subscription_model->subscribe_customer($this->session->userdata('customer_id'), $plan_id, $stripe_subscription_id = NULL))
					{
						$return['message'] = 'true';
					}
					
					else
					{
						$return['message'] = 'false';
						$return['response'] = 'Unable to save your plan. Please try again';
					}
				}
			}
				
			else
			{
				$return['message'] = 'false';
				$return['response'] = 'Plan does not exist';
			}
			
			
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	
	public function create_customer($customer_email, $stripe_token)
	{
		try {
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));

			$response = \Stripe\Customer::create(array(
				"email" => $customer_email,
				"description" => 'New customer and card added',
				"source" => $stripe_token // obtained with Stripe.js
			));
			
			$stripe_customer_id = $response->id;
			
			//save stripe customer to the db
			$data['stripe_customer_id'] = $stripe_customer_id;
			$this->db->where('customer_id', $this->session->userdata('customer_id'));
			if($this->db->update('customer', $data))
			{
				$return['message'] = 'true';
				$return['response'] = $stripe_customer_id;
			}
			
			else
			{
				$return['message'] = 'false';
				$return['response'] = 'Unable to save stripe customer';
			}
									
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage(); 	
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	
	public function update_customer($stripe_customer_id, $stripe_token)
	{
		try {
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));

			$cu = \Stripe\Customer::retrieve($stripe_customer_id);
			$cu->description = "Updated card";
			$cu->source = $stripe_token; // obtained with Stripe.js
			$response = $cu->save();
			
			$return['message'] = 'true';
			$return['response'] = 'Customer updated successfully';
									
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	
	public function create_plan($stripe_plan, $plan_name, $plan_amount)
	{
		try 
		{
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));

			$response = \Stripe\Plan::create(array(
				"amount" => number_format($plan_amount, 2),
				"interval" => "month",
				"name" => $plan_name,
				"currency" => "usd",
				"id" => $stripe_plan)
			);
			$return['message'] = 'true';
			
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	
	public function update_plan($stripe_plan, $plan_name, $plan_amount)
	{
		try 
		{
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));
			
			$p = \Stripe\Plan::retrieve($stripe_plan);
			$p->name = $plan_name;
			$p->amount = number_format($plan_amount, 2);
			$p->save();
			
			$return['message'] = 'true';
			
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	
	public function delete_plan($stripe_plan)
	{
		try 
		{
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));
			
			$plan = \Stripe\Plan::retrieve($stripe_plan);
			$plan->delete();
			
			$return['message'] = 'true';
			
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	
	public function get_invoice($stripe_customer_id, $plan_id)
	{
		try {
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));
			
			$reply = \Stripe\Invoice::all(array("customer" => $stripe_customer_id));
			$data = $reply->data;
			
			$response = $data;
			$total_invoices = count($response);
			for($r = 0; $r < $total_invoices; $r++)
			{
				$stripe_invoice_id = $response[$r]->id;
				//check if invoice exists
				$this->db->where('order_number', $stripe_invoice_id);
				$query = $this->db->get('orders');
				
				//process if doesnt exist
				if($query->num_rows() == 0)
				{
					//$invoice_amount = $response[$r]->amount_due;
					$invoice_date = $response[$r]->date;
					//$closed = $response[$r]->closed;
					$lines = $response[$r]->lines;
					$data = $lines->data;
					$next_payment_attempt = $response[$r]->next_payment_attempt;
					$paid = $response[$r]->paid;
					$receipt_number = $lines->receipt_number;
					$order_status_id = 1;
					
					if($paid == TRUE)
					{
						$order_status_id = 7;
					}
					//create order
					$order_id = $this->orders_model->add_order($order_status_id, $stripe_invoice_id, $invoice_date, $receipt_number);
					
					if($order_id > 0)
					{
						$total_invoice_items = count($data);
						for($s = 0; $s < $total_invoice_items; $s++)
						{
							$subscription_id = $data[$s]->id;
							$amount = $data[$s]->amount;
							$amount = substr($amount, 0, -2);
							$quantity = $data[$s]->quantity;
							//var_dump($data); die();
							if($this->orders_model->add_item($order_id, $plan_id, $quantity, $amount))
							{
							}
						}
					}
				}
			}
			$return['message'] = 'true';
			$return['response'] = 'Invoice added successfully';
			
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
	
	public function get_invoice_test($stripe_customer_id)
	{
		try {
			\Stripe\Stripe::setApiKey($this->config->item("stripe_secret_key"));
			
			$reply = \Stripe\Invoice::all(array("customer" => $stripe_customer_id));
			$data = $reply->data;
			
			$response = $data;
			$total_invoices = count($response);
			for($r = 0; $r < $total_invoices; $r++)
			{
				$stripe_invoice_id = $response[$r]->id;
				$invoice_amount = $response[$r]->amount_due;
				$invoice_date = $response[$r]->date;
				//$closed = $response[$r]->closed;
				$lines = $response[$r]->lines;
				$data = $lines->data;
				$next_payment_attempt = $response[$r]->next_payment_attempt;
				$paid = $response[$r]->paid;
				$receipt_number = $lines->receipt_number;
				echo "<br/>Invoice Amount = ".$invoice_amount;
				
				$total_invoice_items = count($data);
				for($s = 0; $s < $total_invoice_items; $s++)
				{
					$subscription_id = $data[$s]->id;
					$amount = $data[$s]->amount;
					$quantity = $data[$s]->quantity;
					
					echo "<br/>Invoice Item Amount = ".$amount;
				}
			}
			$return['message'] = 'true';
			$return['response'] = 'Invoice added successfully';
			
		} catch(\Stripe\Error\Card $e) {
			// Since it's a decline, \Stripe\Error\Card will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$return['message'] = 'false';
			$return['response'] = $err['message'];
			
			/*echo('Status is:' . $e->getHttpStatus() . "\n");
			echo('Type is:' . $err['type'] . "\n");
			echo('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			echo('Param is:' . $err['param'] . "\n");
			echo('Message is:' . $err['message'] . "\n");*/
		} catch (\Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
			// yourself an email
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$return['message'] = 'false';
			$return['response'] = $e->getMessage();
		}
		return $return;
	}
}
?>