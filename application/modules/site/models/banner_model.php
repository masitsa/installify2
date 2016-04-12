<?php

class Banner_model extends CI_Model 
{
	/*
	*	Add new banner
	*
	*/
	public function save_new_banner($customer_id, $website, $customer_api_key = NULL)
	{
		if(!empty($website) && $customer_api_key != NULL)
		{
			//check if website exists
			$this->db->where('smart_banner_website', $website);
			$query = $this->db->get('smart_banner');
			if($query->num_rows() > 0)
			{
				$return['message'] = FALSE;
				$return['response'] = 'Website already registered. Please enter another one';
			}
			else
			{
				$data = array(
					'smart_banner_created' => date('Y-m-d H:i:s'),
					'smart_banner_website' => $website,
					'customer_api_key' => $customer_api_key,
					'customer_id' => $customer_id
				);
				
				if($this->db->insert('smart_banner', $data))
				{
					$return['message'] = TRUE;
					$return['smart_banner_id'] = $this->db->insert_id();
				}
				
				//in case of registration error
				else
				{
					$return['message'] = FALSE;
					$return['response'] = 'Unable to create banner';
				}
			}
		}
		
		//in case of registration error
		else
		{
			$return['message'] = FALSE;
			$return['response'] = 'No website selected';
		}
		
		return $return;
	}
	
	/*
	*	Add banner
	*
	*/
	public function add_banner($customer_id, $customer_api_key)
	{
		/*$phrase  = $this->input->post('website');
		$healthy = array("http://", "https://", "www.");
		$yummy   = array("", "", "");

		$website = str_replace($healthy, $yummy, $phrase);*/
		$website  = $this->input->post('website');

		//$this->db->where('smart_banner_website', $website);
		//$query = $this->db->get('smart_banner');
		//if($query->num_rows() > 0)
		if(1 > 2)
		{
			$return['message'] = FALSE;
			$return['response'] = 'Website already registered. Please enter another one';
		}
		else
		{
			$data = array(
				'smart_banner_created' => date('Y-m-d H:i:s'),
				'customer_id' => $customer_id,
				'smart_banner_website' => $website,
				'customer_api_key' => $customer_api_key,
				/*'url' => $this->input->post('url'),
				'icon_url' => $this->input->post('icon_url'),
				'title' => $this->input->post('title'),
				'author' => $this->input->post('author'),
				'price' => $this->input->post('price')*/
			);
			
			if($this->db->insert('smart_banner', $data))
			{
				$return['smart_banner_id'] = $this->db->insert_id();
				$return['message'] = 'true';
				$this->session->set_userdata('success_message', 'Banner created successfully');
			}
			
			//in case of registration error
			else
			{
				$return['message'] = 'false';
				$return['response'] = 'Unable to create banner';
			}
		}
		
		return $return;
	}
	
	/*
	*	Add banner
	*
	*/
	public function update_banner($smart_banner_id)
	{
		$data = array(
			'smart_banner_created' => date('Y-m-d H:i:s'),
			'url' => $this->input->post('url'),
			'icon_url' => $this->input->post('icon_url'),
			'title' => $this->input->post('title'),
			'author' => $this->input->post('author'),
			'price' => $this->input->post('price'),
			'app_store_lang' => $this->input->post('app_store_lang'),
			'play_store_lang' => $this->input->post('play_store_lang'),
			'windows_store_lang' => $this->input->post('windows_store_lang'),
			'play_store_params' => $this->input->post('play_store_params'),
			'ios_icon_gloss' => $this->input->post('ios_icon_gloss'),
			'speed_in' => $this->input->post('speed_in'),
			'speed_out' => $this->input->post('speed_out'),
			'days_hidden' => $this->input->post('days_hidden'),
			'days_reminder' => $this->input->post('days_reminder'),
			'days_hidden' => $this->input->post('days_hidden'),
			'button_text' => $this->input->post('button_text'),
			'top_border_color' => $this->input->post('top_border_color'),
			'top_gradient_color' => $this->input->post('top_gradient_color'),
			'bottom_gradient_color' => $this->input->post('bottom_gradient_color'),
			'text_color' => $this->input->post('text_color'),
			'button_color' => $this->input->post('button_color'),
			'button_text_color' => $this->input->post('button_text_color')
		);
		
		$this->db->where('smart_banner_id', $smart_banner_id);
		if($this->db->update('smart_banner', $data))
		{
			$return['message'] = 'true';
			//$this->session->set_userdata('success_message', 'Banner updated successfully');
		}
		
		//in case of registration error
		else
		{
			$return['message'] = 'false';
			$return['response'] = 'Unable to create banner';
		}
		
		return $return;
	}
	
	public function get_banners($customer_id)
	{
		$this->db->where(array('customer_id' => $customer_id, 'banner_delete' => 0));
		$query = $this->db->get('smart_banner');
		
		return $query;
	}
	
	public function get_latest_banner($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$this->db->order_by('smart_banner_created', 'DESC');
		$query = $this->db->get('smart_banner', 1);
		
		return $query;
	}
	
	public function get_banner($customer_id, $smart_banner_id)
	{
		$this->db->where(array('customer_id' => $customer_id, 'smart_banner_id' => $smart_banner_id));
		$query = $this->db->get('smart_banner');
		
		return $query;
	}
	
	public function get_website_banner($website, $customer_api_key)
	{
		$this->db->where(array('smart_banner_website' => $website, 'customer_api_key' => $customer_api_key));
		$query = $this->db->get('smart_banner');
		
		return $query;
	}
	
	public function save_app_views($website, $customer_api_key)
	{
		$data['device'] = $this->input->post('device');
		$data['phone'] = $this->input->post('phone');
		$data['tablet'] = $this->input->post('tablet');
		$data['browser'] = $this->input->post('browser');
		$data['os'] = $this->input->post('os');
		$data['iphone'] = $this->input->post('iphone');
		$data['bot'] = $this->input->post('bot');
		$data['webkit'] = $this->input->post('webkit');
		$data['build'] = $this->input->post('build');
		$data['game_console'] = $this->input->post('game_console');
		$data['customer_api_key'] = $customer_api_key;
		$data['website'] = $website;
		$data['created'] = date('Y-m-d H:i:s');
		if($this->db->insert('click', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing banner
	*	@param int $banner_id
	*
	*/
	public function delete_banner($smart_banner_id)
	{
		$data = array('banner_delete' => 1);
		
		$this->db->where(array('smart_banner_id' => $smart_banner_id, 'customer_id' => $this->session->userdata('customer_id')));
		
		if($this->db->update('smart_banner', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated banner
	*	@param int $smart_banner_website
	*
	*/
	public function activate_banner($smart_banner_website)
	{
		$data = array('smart_banner_status' => 1);
		
		$this->db->where(array('smart_banner_website' => $smart_banner_website, 'customer_id' => $this->session->userdata('customer_id')));
		
		if($this->db->update('smart_banner', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated banner
	*	@param int $smart_banner_website
	*
	*/
	public function deactivate_banner($smart_banner_website)
	{
		$data = array('smart_banner_status' => 0);
		
		$this->db->where(array('smart_banner_website' => $smart_banner_website, 'customer_id' => $this->session->userdata('customer_id')));
		
		if($this->db->update('smart_banner', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_clicks($smart_banner_id)
	{
		$this->db->select('COUNT(smart_banner_id) AS click_total');
		$this->db->where('smart_banner_id = '.$smart_banner_id);
		$query = $this->db->get('smart_banner');
		
		$result = $query->row();
		
		return $result->click_total;
	}
	
	public function get_maximum_clicks($customer_id)
	{
		$this->db->select('maximum_clicks');
		$this->db->where('subscription.plan_id = plan.plan_id AND subscription.subscription_status = 1 AND  subscription.customer_id = '.$customer_id);
		$query = $this->db->get('subscription, plan');
		
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			
			$clicks = $result->maximum_clicks;
			
			if(empty($clicks))
			{
				$clicks = '&#8734';
			}
			return $result->maximum_clicks;
		}
		
		else
		{
			return 0;
		}
	}
	
	public function get_banner_clicks($customer_api_key)
	{
		$this->db->select('count(click_id) as total_clicks');
		$this->db->where(array('customer_api_key' => $customer_api_key));
		$query = $this->db->get('click');
		
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			
			$total_clicks = $result->total_clicks;
			
			if(empty($clicks))
			{
				$total_clicks = 0;
			}
			return $total_clicks;
		}
		
		else
		{
			return 0;
		}
	}
	
	public function activate_banner2($smart_banner_id)
	{
		$data = array('smart_banner_status' => 1);
		
		$this->db->where(array('smart_banner_id' => $smart_banner_id, 'customer_id' => $this->session->userdata('customer_id')));
		
		if($this->db->update('smart_banner', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function deactivate_banner2($smart_banner_id)
	{
		$data = array('smart_banner_status' => 0);
		
		$this->db->where(array('smart_banner_id' => $smart_banner_id, 'customer_id' => $this->session->userdata('customer_id')));
		
		if($this->db->update('smart_banner', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function obfusicate_script($website_name, $customer_api_key)
	{
		$base_url = str_replace("http:", "", base_url());
		$base_url = str_replace("https:", "", $base_url);
		$jquery = $base_url.'assets/themes/jquery-2.1.4.min.js';
		
		$script = 
		"
		function banner_generation_start()
		{
			try {
				
				$.getScript( '".$base_url."assets/themes/custom/js/jquery.cookie.js', function() 
				{
					$.getScript( '".$base_url."installify.js', function() 
					{
						var generate = new Banner();
						generate.generate_banner('".$website_name."', '".$customer_api_key."');
					});
				});
			}
			catch(err) {
				console.log = err.message;
				getScript('".$jquery."', function() 
				{
					if (typeof jQuery=='undefined') {
					
					
					} else {
					
						banner_generation_start();
					}
				
				});
			}
		}
		";
		$this->load->library('packer/javascriptpacker', $script);
		$obfusicated = $this->javascriptpacker->pack();
		
		return "function getScript(url, success) {var script = document.createElement('script');script.src = url;var head = document.getElementsByTagName('head')[0],done = false;script.onload = script.onreadystatechange = function() {	if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {done = true;				success();script.onload = script.onreadystatechange = null;head.removeChild(script);};};head.appendChild(script);}; window.onload = function() {if (typeof jQuery == 'undefined') 	{getScript('".$jquery."', function() {					if (typeof jQuery=='undefined') {} else {banner_generation_start();}});	} else {banner_generation_start();	};};".$obfusicated;
	}
}