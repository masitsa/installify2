var base_url = "http://installify.nairobisingles.com/";

var include_url = base_url+"assets/themes/jquery.smartbanner/jquery.smartbanner-account.js";//include URL

var banner_title, banner_author, banner_price, banner_langauge, banner_app_store_lang, banner_play_store_lang, banner_amazon_store_lang, banner_windows_store_lang, banner_play_store_params, banner_icon_url, banner_ios_icon_gloss, banner_url, banner_button_text, banner_auto_scale, banner_speed_in, banner_speed_out, banner_days_hidden, banner_days_reminder, banner_force_display, banner_hide_on_install, banner_overlay_layer, banner_ios_universall_app, banner_append_to_selector, banner_install_message, banner_close_message;
	
/*
* API functions
*/
var Banner = function() 
{
	/*
	*	validate values before they are used to generate the smart banner
	*	@param text: the text to be validated
	*	@param return_value: the default return value
	*/
	this.check_text = function(text, return_value)
	{
		//Check if text is a number. Convert to number and return number
		var number_check = parseInt(text);
		if(number_check > 0)
		{
			text = parseInt(text);
		}
		
		//check boolean
		else if(text == 'true')
		{
			text = true;
		}
		
		//check boolean
		else if(text == 'false')
		{
			text = false;
		}
		
		//Check if text is empty. Use return value
		else if(text == '')
		{
			text = return_value;
		}
		
		else
		{
			//No action required
		}
		
		return text;
	}
	
	/*
	*	Get website banner parameters via ajax
	*/
	this.generate_banner = function(website_address)
	{
		//include styles
		$('head').append('<link rel="stylesheet" href="'+base_url+'assets/themes/jquery.smartbanner/jquery.smartbanner.css" type="text/css" />');
		$('head').append('<link rel="stylesheet" href="'+base_url+'assets/themes/custom/css/smart_banner.css" type="text/css" />');
		//retrieve banner parameters
		$.ajax({
			type:'GET',
			url: base_url+'site/banner/get_banner_details/'+website_address,
			dataType: 'json',
			success:function(data){
				//alert(data.message);
				if(data.response == "true")
				{
					$.getScript( include_url, function() {
						
						$.smartbanner({ daysHidden: 0, daysReminder: 0, title:'Hulu' });
					});
					
					return true;
				}
				else
				{
					console.log(data.response);
					return false
				}
			},
			error: function(xhr, status, error) {
				console.log("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				return false
			}
		});
	}
};