<?php

class Invoices_model extends CI_Model 
{
	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_invoices($table, $where, $per_page, $page, $order = 'order_created', $order_method = 'DESC')
	{
		//retrieve all orders
		$this->db->from($table);
		$this->db->select('orders.*, orders.order_status_id AS status,customer.customer_first_name AS first_name, customer.customer_surname AS other_names, order_status.order_status_name');
		$this->db->where($where);
		$this->db->order_by('orders.order_created, orders.order_number');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
}
?>