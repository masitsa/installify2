<?php

class Site_model extends CI_Model 
{
	public function display_page_title()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		$last = $total - 1;
		$name = $this->site_model->decode_web_name($page[$last]);
		
		if(is_numeric($name))
		{
			$last = $last - 1;
			$name = $this->site_model->decode_web_name($page[$last]);
		}
		$page_url = ucwords(strtolower($name));
		
		return $page_url;
	}
	
	function generate_price_range()
	{
		$max_price = $this->products_model->get_max_product_price();
		//$min_price = $this->products_model->get_min_product_price();
		
		$interval = $max_price/5;
		
		$range = '';
		$start = 0;
		$end = 0;
		
		for($r = 0; $r < 5; $r++)
		{
			$end = $start + $interval;
			$value = 'KES '.number_format(($start+1), 0, '.', ',').' - KES '.number_format($end, 0, '.', ',');
			$range .= '
			<label class="radio-fancy">
				<input type="radio" name="agree" value="'.$start.'-'.$end.'">
				<span class="light-blue round-corners"><i class="dark-blue round-corners"></i></span>
				<b>'.$value.'</b>
			</label>';
			
			$start = $end;
		}
		
		return $range;
	}
	
	public function get_navigation()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		
		$name = strtolower($page[0]);
		
		$home = '';
		$about = '';
		$shop = '';
		$blog = '';
		$contact = '';
		$spareparts = '';
		$wash = '';
		
		if($name == 'home')
		{
			$home = 'active';
		}
		
		if($name == 'about')
		{
			$about = 'active';
		}
		
		if($name == 'dobi')
		{
			$spareparts = 'active';
		}
		
		if($name == 'wash')
		{
			$wash = 'active';
		}
		
		if($name == 'contact')
		{
			$contact = 'active';
		}
		$neighbourhoods_query = $this->customer_model->get_neighbourhoods();
		$v_data['neighbourhood_parents'] = $neighbourhoods_query['neighbourhood_parents'];
		$v_data['neighbourhood_children'] = $neighbourhoods_query['neighbourhood_children'];
		
		$navigation = 
		'
			<li class="'.$home.'"><a href="'.site_url().'home">Home</a></li>
			<li class="'.$wash.'"><a href="'.site_url().'wash">Wash</a></li>
			<!--<li class="dropdown mega-menu-item mega-menu-fullwidth">
				<a class="dropdown-toggle" href="#">
					Dobis
				</a>
				<ul class="dropdown-menu">
					<li>
						<div class="mega-menu-content">
							<div class="row">
								<div class="col-md-3">
									<span class="mega-menu-sub-title">Category</span>
									<ul class="sub-menu">
										<li>
											<ul class="sub-menu">
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
											</ul>
										</li>
									</ul>
								</div>
								
								<div class="col-md-3">
									<span class="mega-menu-sub-title">Category</span>
									<ul class="sub-menu">
										<li>
											<ul class="sub-menu">
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
											</ul>
										</li>
									</ul>
								</div>
								<div class="col-md-3">
									<span class="mega-menu-sub-title">Category</span>
									<ul class="sub-menu">
										<li>
											<ul class="sub-menu">
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
											</ul>
										</li>
									</ul>
								</div>
								<div class="col-md-3">
									<span class="mega-menu-sub-title">Category</span>
									<ul class="sub-menu">
										<li>
											<ul class="sub-menu">
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
												<li><a href="#">Sub category</a></li>
											</ul>
										</li>
									</ul>
								</div>	
							</div>
						</div>
					</li>
				</ul>
			</li>-->
			<li class="'.$about.'"><a href="'.site_url().'about">About</a></li>
			<li class="'.$contact.'"><a href="'.site_url().'contact">Contact</a></li>
			
		';
		
		return $navigation;
	}
	
	public function create_web_name($field_name)
	{
		$web_name = str_replace(" ", "-", $field_name);
		
		return $web_name;
	}
	
	public function decode_web_name($web_name)
	{
		$field_name = str_replace("-", " ", $web_name);
		
		return $field_name;
	}
	
	public function image_display($base_path, $location, $image_name = NULL)
	{
		$default_image = 'http://placehold.it/300x300&text=Dobi';
		$file_path = $base_path.'/'.$image_name;
		//echo $file_path.'<br/>';
		
		//Check if image was passed
		if($image_name != NULL)
		{
			if(!empty($image_name))
			{
				if((file_exists($file_path)) && ($file_path != $base_path.'\\'))
				{
					return $location.$image_name;
				}
				
				else
				{
					return $default_image;
				}
			}
			
			else
			{
				return $default_image;
			}
		}
		
		else
		{
			return $default_image;
		}
	}
	
	public function get_contacts()
	{
  		$table = "contacts";
		
		$query = $this->db->get($table);
		$contacts = array();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$contacts['email'] = $row->email;
			$contacts['phone'] = $row->phone;
			$contacts['facebook'] = $row->facebook;
			$contacts['twitter'] = $row->twitter;
			$contacts['linkedin'] = $row->pintrest;
			$contacts['company_name'] = $row->company_name;
			$contacts['logo'] = $row->logo;
			$contacts['address'] = $row->address;
			$contacts['city'] = $row->city;
			$contacts['post_code'] = $row->post_code;
			$contacts['building'] = $row->building;
			$contacts['floor'] = $row->floor;
			$contacts['location'] = $row->location;
			$contacts['working_weekend'] = $row->working_weekend;
			$contacts['working_weekday'] = $row->working_weekday;
			$contacts['mission'] = $row->mission;
			$contacts['vision'] = $row->vision;
			$contacts['motto'] = $row->motto;
			$contacts['about'] = $row->about;
			$contacts['objectives'] = $row->objectives;
			$contacts['core_values'] = $row->core_values;
		}
		return $contacts;
	}
	
	public function get_breadcrumbs()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		$last = $total - 1;
		$crumbs = '<li><a href="'.site_url().'home">Home </a></li>';
		
		for($r = 0; $r < $total; $r++)
		{
			$name = $this->decode_web_name($page[$r]);
			if($r == $last)
			{
				$crumbs .= '<li class="active">'.strtoupper($name).'</li>';
			}
			else
			{
				if($total == 3)
				{
					if($r == 1)
					{
						$crumbs .= '<li><a href="'.site_url().$page[$r-1].'/'.strtolower($name).'">'.strtoupper($name).'</a></li>';
					}
					else
					{
						$crumbs .= '<li><a href="'.site_url().strtolower($name).'">'.strtoupper($name).'</a></li>';
					}
				}
				else
				{
					$crumbs .= '<li><a href="'.site_url().strtolower($name).'">'.strtoupper($name).'</a></li>';
				}
			}
		}
		
		return $crumbs;
	}
	public function contact() 
	{
		$this->load->model('site/email_model');
		$this->load->library('Mandrill', $this->config->item('mandrill_key'));
		
		$date = date('jS M Y H:i a',strtotime(date('Y-m-d H:i:s')));
		$subject = $this->input->post('sender_name')." needs some help";
		$message = '
				<p>A help message was sent on '.$date.' saying:</p> 
				<p>'.$this->input->post('message').'</p>
				<p>Their contact details are:</p>
				<p>
					Name: '.$this->input->post('sender_name').'<br/>
					Email: '.$this->input->post('sender_email').'<br/>
					Phone: '.$this->input->post('sender_phone').'
				</p>
				';
		$sender_email = $this->input->post('sender_email');
		$shopping = "";
		$from = $this->input->post('sender_name');
		
		$button = '';
		$response = $this->email_model->send_mandrill_mail('info@instorelook.com.au', "Hi", $subject, $message, $sender_email, $shopping, $from, $button, $cc = NULL);
		
		//echo var_dump($response);
		
		return $response;
	}
	
	public function get_neighbourhoods()
	{
		$this->db->order_by('neighbourhood_name');
		return $this->db->get('neighbourhood');
	}
	
	public function valid_url($url)
	{
		//$pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
		$pattern = "/^((ht|f)tp(s?)\:\/\/|~/|/)?([w]{2}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?/";
        if (!preg_match($pattern, $url))
		{
            return FALSE;
        }
 
        return TRUE;
	}
	
	public function get_days($date)
	{
		$now = time(); // or your date as well
		$your_date = strtotime($date);
		$datediff = $now - $your_date;
		return floor($datediff/(60*60*24));
	}
}

?>