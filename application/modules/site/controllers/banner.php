<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends MX_Controller 
{	
	function __construct()
	{
		parent:: __construct();
		
		// Allow from any origin
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}
	
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
			exit(0);
		}
		$this->load->model('banner_model');
	}
	
	public function get_banner_details($website = NULL, $customer_api_key = NULL)
	{
		if(($website != NULL) && ($customer_api_key != NULL))
		{
			$latest_banner = $this->banner_model->get_website_banner($website, $customer_api_key);
			
			if($latest_banner->num_rows() > 0)
			{
				$banner = $latest_banner->row();
				
				$smart_banner_id = $banner->smart_banner_id;
				$banner_installed = $banner->banner_installed;
				$data['smart_banner_website'] = $banner->smart_banner_website;
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
				$play_store_url = $banner->play_store_url;
				$play_store_url = $this->banner_model->parse_link($play_store_url);
				$istore_url = $banner->istore_url;
				$istore_url = $this->banner_model->parse_link($istore_url);
				$windows_store_url = $banner->windows_store_url;
				$windows_store_url = $this->banner_model->parse_link($windows_store_url);
				
				$data['play_store_url'] = $play_store_url;
				$data['istore_url'] = $istore_url;
				$data['windows_store_url'] = $windows_store_url;
				
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
				
				//update banner as installed
				if($banner_installed == 0)
				{
					$update_data['banner_installed'] = 1;
					$this->db->where('smart_banner_id', $smart_banner_id);
					$this->db->update('smart_banner', $update_data);
				}
				
				//save views
				$views_data['smart_banner_id'] = $smart_banner_id;
				$views_data['views_date'] = date('Y-m-d H:i:s');
				$this->db->insert('views', $views_data);
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
		
		echo json_encode($return);
	}
	
	public function save_app_views($website, $customer_api_key)
	{
		if($website != NULL)
		{
			if($this->banner_model->save_app_views($website, $customer_api_key))
			{
				$return['result'] = 'true';
			}
			
			else
			{
				$return['result'] = 'false';
				$return['message'] = 'Unable to save click';
			}
		}
		
		else
		{
			$return['result'] = 'false';
			$return['message'] = 'Website not found';
		}
		
		echo json_encode($return);
	}
}
?>