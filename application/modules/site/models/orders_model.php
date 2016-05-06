<?php

class Orders_model extends CI_Model 
{
	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_orders($table, $where, $per_page, $page)
	{
		//retrieve all orders
		$this->db->from($table);
		$this->db->select('orders.*, orders.order_status_id AS status,customer.customer_first_name AS first_name, customer.customer_surname AS other_names, order_status.order_status_name');
		$this->db->where($where);
		$this->db->order_by('orders.order_created, orders.order_number');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	/*
	*	Retrieve latest orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_latest_orders()
	{
		$where = 'orders.order_status_id != 4 AND orders.order_status_id = order_status.order_status_id AND customer.customer_id = orders.customer_id AND orders.vendor_id = '.$this->session->userdata('vendor_id');
		$table = 'orders, order_status, customer';
		
		//retrieve all orders
		$this->db->from($table);
		$this->db->select('orders.*, orders.order_status_id AS status,customer.customer_first_name AS first_name, customer.customer_surname AS other_names, order_status.order_status_name');
		$this->db->where($where);
		$this->db->order_by('orders.order_created', 'DESC');
		$query = $this->db->get('', 20);
		
		return $query;
	}
	
	/*
	*	Retrieve all orders of a user
	*
	*/
	public function get_user_orders($customer_id)
	{
		$this->db->select('payment_method.payment_method_name, orders.*, order_status.order_status_name');
		$this->db->where('orders.payment_method_id = payment_method.payment_method_id AND orders.order_status_id = order_status.order_status_id AND orders.customer_id = '.$customer_id);
		$this->db->order_by('order_created', 'DESC');
		$query = $this->db->get('orders, order_status, payment_method');
		
		return $query;
	}
	
	/*
	*	Retrieve all wishlist items of a user
	*
	*/
	public function get_user_wishlist($customer_id)
	{
		$this->db->select('brand.brand_name, product.*, wishlist.date_added, wishlist.wishlist_id');
		$this->db->where('product.brand_id = brand.brand_id AND product.product_id = wishlist.product_id AND wishlist.customer_id = '.$customer_id);
		$this->db->order_by('wishlist.date_added', 'DESC');
		$query = $this->db->get('product, wishlist, brand');
		
		return $query;
	}
	
	/*
	*	Retrieve an order
	*
	*/
	public function get_order($order_id)
	{
		$this->db->select('*');
		$this->db->where('orders.order_status = order_status.order_status_id AND users.user_id = orders.user_id AND orders.order_id = '.$order_id);
		$query = $this->db->get('orders, order_status, users');
		
		return $query;
	}
	
	/*
	*	Retrieve all order items of an order
	*
	*/
	public function get_order_items($order_id)
	{
		$this->db->select('product.product_name, product.product_thumb_name, order_item.*, vendor.vendor_store_name, vendor.vendor_id');
		$this->db->where('product.created_by = vendor.vendor_id AND product.product_id = order_item.product_id AND order_item.order_id = '.$order_id);
		$query = $this->db->get('order_item, product, vendor');
		
		return $query;
	}
	
	/*
	*	Retrieve all order item featuress of an order item
	*
	*/
	public function get_order_item_features($order_item_id)
	{
		$this->db->select('order_item_feature.*, product_feature.feature_value, product_feature.thumb, feature.feature_name');
		$this->db->where('product_feature.feature_id = feature.feature_id AND order_item_feature.product_feature_id = product_feature.product_feature_id AND order_item_feature.order_item_id = '.$order_item_id);
		$query = $this->db->get('order_item_feature, product_feature, feature');
		
		return $query;
	}
	
	/*
	*	Create order number
	*
	*/
	public function create_order_number()
	{
		//select product code
		$this->db->from('orders');
		$this->db->where("order_number LIKE 'ORD".date('y')."/%'");
		$this->db->select('MAX(order_number) AS number');
		$query = $this->db->get();
		$preffix = "ORD".date('y').'/';
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$number =  $result[0]->number;
			$real_number = str_replace($preffix, "", $number);
			$real_number++;//go to the next number
			$number = $preffix.sprintf('%06d', $real_number);
		}
		else{//start generating receipt numbers
			$number = $preffix.sprintf('%06d', 1);
		}
		
		return $number;
	}
	
	/*
	*	Create the total cost of an order
	*	@param int order_id
	*
	*/
	public function calculate_order_cost($order_id)
	{
		//select product code
		$this->db->from('order_item');
		$this->db->where('order_id = '.$order_id);
		$this->db->select('SUM(order_item_price * order_item_quantity) AS total_cost');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$total_cost =  $result[0]->total_cost;
		}
		
		else
		{
			$total_cost = 0;
		}
		
		return $total_cost;
	}
	
	/*
	*	Add a new order
	*
	*/
	public function add_order($order_status_id, $order_number, $order_date, $receipt_number)
	{
		//$order_number = $this->create_order_number();
		
		$data = array(
				'order_date'=>date('Y-m-d', $order_date),
				'order_number'=>$order_number,
				'receipt_number'=>$receipt_number,
				'customer_id'=>$this->session->userdata('customer_id'),
				'order_status_id'=>$order_status_id,
				'order_created'=>date('Y-m-d H:i:s')
			);
			
		if($this->db->insert('orders', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an order
	*	@param int $order_id
	*
	*/
	public function _update_order($order_id)
	{
		$order_number = $this->create_order_number();
		
		$data = array(
				'user_id'=>$this->input->post('user_id'),
				'payment_method'=>$this->input->post('payment_method'),
				'order_status'=>1,
				'order_instructions'=>$this->input->post('order_instructions'),
				'modified_by'=>$this->session->userdata('user_id')
			);
		
		$this->db->where('order_id', $order_id);
		if($this->db->update('orders', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_payment_methods()
	{
		//retrieve all orders
		$this->db->from('payment_method');
		$this->db->select('*');
		$this->db->order_by('payment_method_name');
		$query = $this->db->get();
		
		return $query;
	}

	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_order_status()
	{
		//retrieve all orders
		$this->db->from('order_status');
		$this->db->select('*');
		$this->db->order_by('order_status_name');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Add a order product
	*
	*/
	public function add_item($order_id, $plan_id, $quantity, $price)
	{
		$data = array(
				'order_id'=>$order_id,
				'plan_id'=>$plan_id,
				'order_item_quantity'=>$quantity,
				'order_item_price'=>$price
			);
			
		if($this->db->insert('order_item', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an order item
	*
	*/
	public function update_cart($order_item_id, $quantity)
	{
		$data = array(
					'quantity'=>$quantity
				);
				
		$this->db->where('order_item_id = '.$order_item_id);
		if($this->db->update('order_item', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing order item
	*	@param int $product_id
	*
	*/
	public function delete_order_item($order_item_id)
	{
		if($this->db->delete('order_item', array('order_item_id' => $order_item_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function request_cancel($order_number, $customer_id)
	{
		$this->db->where(array(
				'order_number' => $order_number,
				'customer_id' => $customer_id
			)
		);
		$data['order_status_id'] = 6;
		if($this->db->update('orders', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_customer($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$query = $this->db->get('customer');
		
		return $query;
	}
	
	public function get_invoices($customer_id)
	{
		$this->db->where('order_status.order_status_id = orders.order_status_id AND customer_id = '.$customer_id);
		$query = $this->db->get('orders, order_status');
		
		return $query;
	}
	
	public function get_invoice_items($order_id)
	{
		$this->db->where('plan.plan_id = order_item.plan_id AND order_item.order_id = '.$order_id);
		$query = $this->db->get('plan, order_item');
		
		return $query;
	}


	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_clicks($table, $where, $per_page, $page)
	{
		//retrieve all orders
		$this->db->from($table);
		$this->db->select('click.*');
		$this->db->where($where);
		$this->db->order_by('click.created', 'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
}