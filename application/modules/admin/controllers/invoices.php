<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Invoices extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('admin/users_model');
		$this->load->model('admin/invoices_model');
		$this->load->model('site/site_model');
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
		$config['base_url'] = base_url().'invoices';
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
}
?>