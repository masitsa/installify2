<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Orders extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('admin/users_model');
		$this->load->model('orders_model');
		$this->load->model('products_model');
		$this->load->model('site/site_model');
		$this->load->model('site/cart_model');
	}
    
	/*
	*
	*	Default action is to show all the orders
	*
	*/
	public function index() 
	{
		// $where = 'orders.order_status = order_status.order_status_id AND users.user_id = orders.user_id';
		// $table = 'orders, order_status, users';

		$where = 'orders.order_status_id != 4 AND orders.order_status_id = order_status.order_status_id AND customer.customer_id = orders.customer_id';
		$table = 'orders, order_status, customer';
		$orders_search = $this->session->userdata('orders_search');
		
		if(!empty($orders_search))
		{
			$where .= $orders_search;
		}
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'vendor/all-orders';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = 2;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->orders_model->get_all_orders($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['order_status_query'] = $this->orders_model->get_order_status();
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('orders/all_orders', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<div class="alert alert-info center-align" style="margin-bottom:20px;">No orders have been made</div>';
		}
		$data['title'] = 'All orders';
		
		$this->load->view('account_template', $data);
	}
    
	/*
	*
	*	Add a new order
	*
	*/
	public function add_order() 
	{
		//form validation rules
		$this->form_validation->set_rules('order_instructions', 'Order Instructions', 'required|xss_clean');
		$this->form_validation->set_rules('user_id', 'Customer', 'required|xss_clean');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$order_id = $this->orders_model->add_order();
			//update order
			if($order_id > 0)
			{
				redirect('edit-order/'.$order_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update order. Please try again');
			}
		}
		
		//open the add new order
		$data['title'] = 'Add Order';
		
		$v_data['all_users'] = $this->users_model->get_all_front_end_users();
		$v_data['payment_methods'] = $this->orders_model->get_payment_methods();
		
		$data['content'] = $this->load->view('orders/add_order', $v_data, true);
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing order
	*	@param int $order_id
	*
	*/
	public function edit_order($order_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('order_instructions', 'Order Instructions', 'required|xss_clean');
		$this->form_validation->set_rules('user_id', 'Customer', 'required|xss_clean');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update order
			if($this->orders_model->update_order($order_id))
			{
				$this->session->set_userdata('success_message', 'Order updated successfully');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update order. Please try again');
			}
		}
		
		//open the add new order
		$data['title'] = 'Edit Order';
		
		//select the order from the database
		$query = $this->orders_model->get_order($order_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['order'] = $query->row();
			$query = $this->products_model->all_products();
			$v_data['products'] = $query->result();
			$v_data['order_items'] = $this->orders_model->get_order_items($order_id);
			$v_data['all_users'] = $this->users_model->get_all_front_end_users();
			$v_data['payment_methods'] = $this->orders_model->get_payment_methods();
			
			$data['content'] = $this->load->view('orders/edit_order', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Order does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add products to an order
	*	@param int $order_id
	*	@param int $product_id
	*	@param int $quantity
	*
	*/
	public function add_product($order_id, $product_id, $quantity, $price)
	{
		if($this->orders_model->add_product($order_id, $product_id, $quantity, $price))
		{
			redirect('edit-order/'.$order_id);
		}
	}
    
	/*
	*
	*	Add products to an order
	*	@param int $order_id
	*	@param int $order_item_id
	*	@param int $quantity
	*
	*/
	public function update_cart($order_id, $order_item_id, $quantity)
	{
		if($this->orders_model->update_cart($order_item_id, $quantity))
		{
			redirect('edit-order/'.$order_id);
		}
	}
    
	/*
	*
	*	Delete an existing order
	*	@param int $order_id
	*
	*/
	public function delete_order($order_id)
	{
		//delete order
		$this->db->delete('orders', array('order_id' => $order_id));
		$this->db->delete('order_item', array('order_item_id' => $order_id));
		redirect('vendor/all-orders');
	}

	/*
	*
	*	Delete an existing order
	*	@param int $order_id
	*
	*/
	public function reverse_order($order_id)
	{
		//delete order
		$data = array(
					'order_status_id'=>5
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('vendor/all-orders');
	}
    
	/*
	*
	*	Add products to an order
	*	@param int $order_item_id
	*
	*/
	public function delete_order_item($order_id, $order_item_id)
	{
		if($this->orders_model->delete_order_item($order_item_id))
		{
			redirect('edit-order/'.$order_id);
		}
	}
    
	/*
	*
	*	Complete an order
	*	@param int $order_id
	*
	*/
	public function finish_order($order_id)
	{
		$data = array(
					'order_status_id'=>1
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('vendor/all-orders');
	}
    
	/*
	*
	*	Cancel an order
	*	@param int $order_id
	*
	*/
	public function cancel_order($order_preffix, $order_number)
	{
		$number = $order_preffix.'/'.$order_number;
		//refund customer
		$data = array(
					'order_status_id' => 2
				);
				
		$this->db->where("order_number = '".$number."'");
		$this->db->update('orders', $data);
		
		redirect('vendor/all-orders');
	}
    
	/*
	*
	*	Deactivate an order
	*	@param int $order_id
	*
	*/
	public function deactivate_order($order_id)
	{
		$data = array(
					'order_status_id'=>3
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('vendor/all-orders');
	}
	/*
	*
	*	Deactivate an order
	*	@param int $order_id
	*
	*/
	public function activate_order($order_id)
	{
		$data = array(
					'order_status_id'=>0
				);
				
		$this->db->where('order_id = '.$order_id);
		$this->db->update('orders', $data);
		
		redirect('vendor/all-orders');
	}
	public function search_orders()
	{

		$customer_first_name = $this->input->post('customer_first_name');
		$customer_surname = $this->input->post('customer_surname');
		$order_number = $this->input->post('order_number');
		$order_status_id = $this->input->post('order_status_id');


		if(!empty($customer_first_name))
		{
			$customer_first_name = ' AND customer.customer_first_name LIKE \'%'.mysql_real_escape_string($customer_first_name).'%\' ';
		}
		else
		{
			$customer_first_name = '';	
		}
		if(!empty($customer_surname))
		{
			$customer_surname = ' AND customer.customer_surname LIKE \'%'.mysql_real_escape_string($customer_surname).'%\'';
		}
		else
		{
			$customer_surname = '';
		}
		if(!empty($order_number))
		{
			$order_number = ' AND orders.order_number LIKE \'%'.$order_number.'%\' ';
		}
		else
		{
			$order_number = '';
		}
		if(!empty($order_status_id))
		{
			$order_status_id = ' AND orders.order_status_id = '.$order_status_id.'';
		}
		else
		{
			$order_status_id = '';
		}
		
		
		$search = $customer_first_name.$customer_surname.$order_number.$order_status_id;
		$this->session->set_userdata('orders_search', $search);
		
		$this->index();
		
	}
	public function close_orders_search()
	{
		$this->session->unset_userdata('orders_search');
		redirect('vendor/all-orders');
	}
}
?>