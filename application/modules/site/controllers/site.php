<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MX_Controller 
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('site_model');
		$this->load->model('auth_model');
		$this->load->model('banner_model');
	}
    
	/*
	*
	*	Default action is to go to the home page
	*
	*/
	public function index() 
	{
		redirect('home');
	}
    
	/*
	*
	*	Sign in
	*
	*/
	public function sign_in() 
	{
		$data['title'] = $this->site_model->display_page_title();
		$data['content'] = $this->load->view("sign_in", '', TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
    
	/*
	*
	*	Sign in
	*
	*/
	public function sign_out() 
	{
		$this->session->sess_destroy();
		
		redirect('home');
	}
    
	/*
	*
	*	Home Page
	*
	*/
	public function home_page() 
	{
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		$data['title'] = $this->site_model->display_page_title();
		$data['sign_up'] = 1;
		$data['content'] = $this->load->view("home", $v_data, TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
    
	/*
	*
	*	Register customer
	*
	*/
	public function register_customer()
	{
		$this->form_validation->set_rules('website', 'Website url', 'required|is_unique[smart_banner.smart_banner_website]');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('image', 'Image', 'trim');
		$this->form_validation->set_message('is_unique', 'That website already exists. Please enter another one');
		
		if ($this->form_validation->run() == FALSE)
		{
			$response['message'] = 'false';
			$validation_errors = validation_errors();
			$response['result'] = $validation_errors;
		}
		else
		{
			$url = $this->input->post('website');
			
			//check for valid url
			if($this->site_model->valid_url($url))
			{
				$reply = $this->auth_model->register_user();
				
				if($reply['message'] == TRUE)
				{
					//send registration email
					$email_reply = $this->auth_model->send_registration_email($this->input->post('email'), $reply['first_name']);
					//var_dump($response);
					if($email_reply)
					{
						//$data2['success'] = $response;
					}
					
					else
					{
						//$data2['error'] = $response;
					}
					$response['message'] = 'true';
					$this->session->set_userdata('success_message', $reply['response']);
				}
				
				else
				{
					$response['message'] = 'false';
					$response['result'] = $reply['response'];
				}
			}
			
			else
			{
				$response['message'] = 'false';
				$response['result'] = 'Please enter a valid website url. Ensure it starts with http(s)://';
			}
		}
		
		echo json_encode($response);
	}
    
	/*
	*
	*	Register customer
	*
	*/
	public function sign_in_customer()
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('image', 'Image', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$response['message'] = 'false';
			$validation_errors = validation_errors();
			$response['result'] = $validation_errors;
		}
		else
		{
			$reply = $this->auth_model->sign_in_customer();
			
			if($reply['message'] == TRUE)
			{
				$response['message'] = 'true';
				$this->session->set_userdata('success_message', $reply['response']);
			}
			
			else
			{
				$response['message'] = 'false';
				$response['result'] = $reply['response'];
			}
		}
		
		echo json_encode($response);
	}
    
	/*
	*
	*	Search for a product
	*
	*/
	public function search()
	{
		$search = $this->input->post('search_item');
		
		if(!empty($search))
		{
			redirect('products/search/'.$search);
		}
		
		else
		{
			redirect('products/all-products');
		}
	}
    
	/*
	*
	*	Products Page
	*
	*/
	public function view_product($product_id)
	{
		$data['logo'] = base_url().'assets/logo.png';
		$this->products_model->update_clicks($product_id);
		//Required general page data
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		//get page data
		$v_data['all_features'] = $this->features_model->all_features();
		$v_data['similar_products'] = $this->products_model->get_similar_products($product_id);
		$v_data['product_details'] = $this->products_model->get_product($product_id);
		$v_data['product_images'] = $this->products_model->get_gallery_images($product_id);
		$v_data['product_features'] = $this->products_model->get_features($product_id);
		$data['content'] = $this->load->view('products/view_product', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Categories Page
	*
	*/
	public function categories() 
	{	
		//contacts
		$v_data['categories'] = $this->categories_model->all_child_categories();
		$v_data['categories_location'] = $this->categories_location;
		$v_data['categories_path'] = $this->categories_path;
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		
		$data['title'] = $this->site_model->display_page_title();
		$v_data['title'] = $data['title'];
		$data['contacts'] = $contacts;
		$data['content'] = $this->load->view("categories", $v_data, TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
    
	/*
	*
	*	Select dobi
	*
	*/
	public function select_dobi()
	{
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $data['contacts'] = $contacts;
		
		$data['title'] = $this->site_model->display_page_title();
		$v_data['title'] = $data['title'];
		
		$data['content'] = $this->load->view("select_dobi", $v_data, TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
	
	public function all_dobis()
	{
		$table = "dobi";
		$where = "dobi.availability = 1";
		
		$this->db->where($where);
		$query = $this->db->get($table);
		
		if($query->num_rows() > 0)
		{
			$result['message'] = 'success';
			$result['result'] = $query->result();
		}
		
		else
		{
			$result['message'] = 'error';
		}
		
		echo json_encode($result);
	}
    
	/*
	*
	*	Select dobi
	*
	*/
	public function select_dobi_old($neighbourhood_web_name = '__')
	{
		//contacts
		/*$neighbourhoods_query = $this->customer_model->get_neighbourhoods();
		$v_data['neighbourhood_parents'] = $neighbourhoods_query['neighbourhood_parents'];
		$v_data['parent'] = '';
		$v_data['child'] = '';
		$v_data['neighbourhood_children'] = $neighbourhoods_query['neighbourhood_children'];*/
		$v_data['neighbourhood_id'] = '';
		$v_data['neighbourhoods'] = $this->site_model->get_neighbourhoods();
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		
		$data['title'] = $this->site_model->display_page_title();
		$v_data['title'] = $data['title'];
		$data['contacts'] = $contacts;
				
		$table = "dobi, neighbourhood";
		$where = "neighbourhood.neighbourhood_id = dobi.neighbourhood_id AND dobi.availability = 1";
		$order = "neighbourhood_name";
		
		if($neighbourhood_web_name != '__')
		{
			$neighbourhood_name = $this->site_model->decode_web_name($neighbourhood_web_name);
			$where .= " AND (neighbourhood.neighbourhood_name = '".$neighbourhood_name."' OR neighbourhood.neighbourhood_parent = (SELECT neighbourhood.neighbourhood_id FROM neighbourhood WHERE neighbourhood.neighbourhood_name = '".$neighbourhood_name."'))";
		}
		
		//pagination
		$segment = 2;
		$this->load->library('pagination');
		$config['base_url'] = base_url().'select-dobi';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination no-margin-top">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = '»';

		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = '«';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		
		$v_data["page"] = $page;
		$v_data["first"] = $page + 1;
		$v_data["total"] = $config['total_rows'];
		$v_data["last"] = $config['total_rows'];
		
		$v_data['dobis'] = $this->dobi_model->get_all_dobis($table, $where, $config["per_page"], $page);
		
		$data['content'] = $this->load->view("select_dobi", $v_data, TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
	
	public function filter_dobi()
	{
		$neighbourhood_id = $this->input->post('neighbourhood_id');
		
		if(!empty($neighbourhood_id))
		{
			$this->db->where('neighbourhood_id', $neighbourhood_id);
			$query = $this->db->get('neighbourhood');
			
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$neighbourhood_name = $row->neighbourhood_name;
				$web_name = $this->site_model->create_web_name($neighbourhood_name);
				redirect('select-dobi/'.$web_name);
			}
			
			else
			{
				redirect('select-dobi');
			}
		}
		
		else
		{
			redirect('select-dobi');
		}
	}
    
	/*
	*
	*	FAQs
	*
	*/
	public function faqs() 
	{	
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		
		$data['title'] = $this->site_model->display_page_title();
		$v_data['title'] = $data['title'];
		$data['contacts'] = $contacts;
		$data['content'] = $this->load->view("faqs", $v_data, TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
    
	/*
	*
	*	terms
	*
	*/
	public function terms() 
	{	
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		
		$data['title'] = $this->site_model->display_page_title();
		$v_data['title'] = $data['title'];
		$data['contacts'] = $contacts;
		$data['content'] = $this->load->view("terms", $v_data, TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
    
	/*
	*
	*	privacy
	*
	*/
	public function privacy() 
	{	
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		
		$data['title'] = $this->site_model->display_page_title();
		$v_data['title'] = $data['title'];
		$data['contacts'] = $contacts;
		$data['content'] = $this->load->view("privacy", $v_data, TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
    
	/*
	*
	*	about
	*
	*/
	public function about() 
	{	
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		
		$data['title'] = $this->site_model->display_page_title();
		$v_data['title'] = $data['title'];
		$data['contacts'] = $contacts;
		$data['content'] = $this->load->view("about", $v_data, TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
    
	/*
	*
	*	Contact
	*
	*/
	public function contact()
	{
		$v_data['sender_name_error'] = '';
		$v_data['sender_email_error'] = '';
		$v_data['sender_phone_error'] = '';
		$v_data['message_error'] = '';
		
		$v_data['sender_name'] = '';
		$v_data['sender_email'] = '';
		$v_data['sender_phone'] = '';
		$v_data['message'] = '';
		
		//form validation rules
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('sender_name', 'Your Name', 'required');
		$this->form_validation->set_rules('sender_email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('sender_phone', 'phone', 'xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'required');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$response = $this->site_model->contact();
			$this->session->set_userdata('success_message', 'Your message has been sent successfully. We shall get back to you as soon as possible');
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				//create errors
				$v_data['sender_name_error'] = form_error('sender_name');
				$v_data['sender_email_error'] = form_error('sender_email');
				$v_data['sender_phone_error'] = form_error('sender_phone');
				$v_data['message_error'] = form_error('message');
				
				//repopulate fields
				$v_data['sender_name'] = set_value('sender_name');
				$v_data['sender_email'] = set_value('sender_email');
				$v_data['sender_phone'] = set_value('sender_phone');
				$v_data['message'] = set_value('message');
			}
		}
		
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		
		$data['title'] = $v_data['title'] = $this->site_model->display_page_title();
		$data['contacts'] = $contacts;
		$data['content'] = $this->load->view('contact', $v_data, true);
		
		$this->load->view("site/templates/general_page", $data);
	}
	
	public function smartbanner()
	{
		$this->load->view('smartbanner');
	}
	
	public function get_banner_details($website = NULL)
	{
		if($website != NULL)
		{
			$latest_banner = $this->banner_model->get_website_banner($website);
			
			if($latest_banner->num_rows() > 0)
			{
				$banner = $latest_banner->row();
				
				$data['smart_banner_id'] = $banner->smart_banner_id;
				$data['smart_banner_website'] = $banner->smart_banner_website;
				$data['customer_id'] = $banner->customer_id;
				$data['smart_banner_status'] = $banner->smart_banner_status;
				$data['smart_banner_created'] = $banner->smart_banner_created;
				$data['smart_banner_last_modified'] = $banner->smart_banner_last_modified;
				$data['title'] = $banner->title;
				$data['author'] = $banner->author;
				$data['price'] = $banner->price;
				$data['language'] = $banner->language;
				$data['app_store_lang'] = $banner->app_store_lang;
				$data['play_store_lang'] = $banner->play_store_lang;
				$data['amazon_store_lang'] = $banner->amazon_store_lang;
				$data['windows_store_lang'] = $banner->windows_store_lang;
				$data['play_store_params'] = $banner->play_store_params;
				$data['icon_url'] = $banner->icon_url;
				$data['ios_icon_gloss'] = $banner->ios_icon_gloss;
				$data['url'] = $banner->url;
				$data['speed_in'] = $banner->speed_in;
				$data['speed_out'] = $banner->speed_out;
				$data['days_hidden'] = $banner->days_hidden;
				$data['days_reminder'] = $banner->days_reminder;
				$data['button_text'] = $banner->button_text;
				$data['auto_scale'] = $banner->auto_scale;
				$data['force_display'] = $banner->force_display;
				$data['hide_on_install'] = $banner->hide_on_install;
				$data['overlay_layer'] = $banner->overlay_layer;
				$data['ios_universall_app'] = $banner->ios_universall_app;
				$data['append_to_selector'] = $banner->append_to_selector;
				$data['install_message'] = $banner->install_message;
				$data['close_message'] = $banner->close_message;
				$data['top_border_color'] = $banner->top_border_color;
				$data['top_gradient_color'] = $banner->top_gradient_color;
				$data['bottom_gradient_color'] = $banner->bottom_gradient_color;
				$data['text_color'] = $banner->text_color;
				$data['button_color'] = $banner->button_color;
				$data['button_text_color'] = $banner->button_text_color;
				
				if(empty($data['top_border_color']))
				{
					$data['top_border_color'] = '88B131';
				}
				if(empty($data['top_gradient_color']))
				{
					$data['top_gradient_color'] = '555555';
				}
				if(empty($data['bottom_gradient_color']))
				{
					$data['bottom_gradient_color'] = '555555';
				}
				if(empty($data['text_color']))
				{
					$data['text_color'] = 'ffffff';
				}
				if(empty($data['button_color']))
				{
					$data['button_color'] = '2196F3';
				}
				if(empty($data['button_text_color']))
				{
					$data['button_text_color'] ='ffffff';
				}
				
				$return['response'] = 'true';
				$return['message'] = $data;
			}
		
			else
			{
				$return['response'] = 'false';
				$return['message'] = 'Website not found';
			}
		}
		
		else
		{
			$return['response'] = 'false';
			$return['message'] = 'Website not added';
		}
	}
	
	public function generate_api_key($customer_id)
	{
		$api_ley =  md5(site_url().'-'.$customer_id);
		
		$this->db->where('customer_id', $customer_id);
		if($this->db->update('customer', array('customer_api_key' => $api_ley)))
		{
			echo $api_ley;
		}
		
		else
		{
			echo 'Unable to update API Key';
		}
	}
	
	public function clicks($order = 'category_name', $order_method = 'ASC') 
	{
		$where = 'category_id > 0';
		$table = 'category';
		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'admin/categories/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
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
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->categories_model->get_all_categories($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Categories';
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['all_categories'] = $this->categories_model->all_categories();
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('categories/all_categories', $v_data, true);
		
		$this->load->view('templates/general_page', $data);
	}
	
	public function check_url($url)
	{
		if($this->site_model->valid_url($url))
		{
			echo 'true';
		}
		
		else
		{
			echo 'false';
		}
	}
}
?>