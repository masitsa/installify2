var base_url = "http://installify.nairobisingles.com/";

//var include_url = base_url+"assets/themes/jquery.smartbanner/jquery.smartbanner-account.js";//include URL
var include_url = base_url+"assets/themes/jquery.smartbanner/jquery.smartbanner.js";//include URL

var banner_title, banner_author, banner_price, banner_langauge, banner_app_store_lang, banner_play_store_lang, banner_amazon_store_lang, banner_windows_store_lang, banner_play_store_params, banner_icon_url, banner_ios_icon_gloss, banner_url, banner_button_text, banner_auto_scale, banner_speed_in, banner_speed_out, banner_days_hidden, banner_days_reminder, banner_force_display, banner_hide_on_install, banner_overlay_layer, banner_ios_universall_app, banner_append_to_selector, banner_install_message, banner_close_message;
	
/*
* API functions
*/
var Banner = function() 
{
	this.check_browser = function()
	{
		var ua= navigator.userAgent, tem,
		M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
		if(/trident/i.test(M[1])){
			tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
			return 'IE '+(tem[1] || '');
		}
		if(M[1]=== 'Chrome'){
			tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
			if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
		}
		M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
		if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
		return M.join(' ');
	}
	
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
		
		//check boolean
		else if(text == null)
		{
			text = return_value;
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
		$.cookie("website_address", website_address);
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
						var items = data.message;
						banner_title = items.title;
						banner_author = items.author;
						banner_price = items.price;
						banner_langauge = items.language;
						banner_app_store_lang = items.app_store_lang;
						banner_play_store_lang = items.play_store_lang;
						banner_amazon_store_lang = items.amazon_store_lang;
						banner_windows_store_lang = items.windows_store_lang;
						banner_play_store_params = items.play_store_params;
						banner_icon_url = items.icon_url;
						banner_ios_icon_gloss = items.ios_icon_gloss;
						banner_url = items.url;
						banner_button_text = items.button_text;
						banner_auto_scale = items.auto_scale;
						banner_speed_in = items.speed_in;
						banner_speed_out = items.speed_out;
						banner_days_hidden = items.days_hidden;
						$.cookie("days_hidden", banner_days_hidden);
						banner_days_reminder = items.days_reminder;
						$.cookie("days_reminder", banner_days_reminder);
						banner_force_display = items.force_display;
						banner_hide_on_install = items.hide_on_install;
						banner_overlay_layer = items.overlay_layer;
						banner_ios_universall_app = items.ios_universall_app;
						banner_append_to_selector = items.append_to_selector;
						banner_install_message = items.install_message;
						banner_close_message = items.close_message;
						top_border_color = items.top_border_color;//alert(top_border_color);
						top_gradient_color = items.top_gradient_color;//alert(top_gradient_color);
						bottom_gradient_color = items.bottom_gradient_color;//alert(bottom_gradient_color);
						text_color = items.text_color;//alert(text_color);
						button_color = items.button_color;//alert(button_color);
						button_text_color = items.button_text_color;//alert(button_text_color);
						
						var validate = new Banner();//initialize banner object
						//validate parameters
						/* Banner title */
						banner_title = validate.check_text(banner_title, 'Enter title');//alert(banner_title);
						
						/* Banner author */
						banner_author = validate.check_text(banner_author, 'Enter author');//alert(banner_author);
						
						/* Banner price */
						banner_price = validate.check_text(banner_price, 'Free');//alert(banner_price);
						
						/* Banner language */
						if(banner_langauge == null)
						{
							banner_langauge = 'us';
						}
						//alert(banner_langauge);
						//banner_langauge = validate.check_text(banner_langauge, 'us');
						
						/* Banner app_store_lang */
						banner_app_store_lang = validate.check_text(banner_app_store_lang, 'On the App Store');//alert(banner_app_store_lang);
						
						/* Banner play_store_lang */
						banner_play_store_lang = validate.check_text(banner_play_store_lang, 'In Google Play');//alert(banner_play_store_lang);
						
						/* Banner amazon_store_lang */
						banner_amazon_store_lang = validate.check_text(banner_amazon_store_lang, 'In the Amazon Appstore');//alert(banner_amazon_store_lang);
						
						/* Banner windows_store_lang */
						banner_windows_store_lang = validate.check_text(banner_windows_store_lang, 'In the Windows store');//alert(banner_windows_store_lang);
						
						/* Banner play_store_params */
						banner_play_store_params = validate.check_text(banner_play_store_params, null);//alert(banner_play_store_params);
						
						/* Banner icon_url */
						banner_icon_url = validate.check_text(banner_icon_url, null);//alert(banner_icon_url);
						
						/* Banner ios_icon_gloss */
						banner_ios_icon_gloss = validate.check_text(banner_ios_icon_gloss, null);//alert(banner_ios_icon_gloss);
						
						/* Banner url */
						banner_url = validate.check_text(banner_url, null);//alert(banner_url);
						
						/* Banner button_text */
						banner_button_text = validate.check_text(banner_button_text, 'VIEW');//alert(banner_button_text);
						
						/* Banner auto_scale */
						banner_auto_scale = validate.check_text(banner_auto_scale, 'auto');//alert(banner_auto_scale);
						
						/* Banner speed_in */
						banner_speed_in = validate.check_text(banner_speed_in, 300);//alert(banner_speed_in);
						
						/* Banner speed_out */
						banner_speed_out = validate.check_text(banner_speed_out, 400);//alert(banner_speed_out);
						
						/* Banner days_hidden */
						banner_days_hidden = validate.check_text(banner_days_hidden, 15);//alert(banner_days_hidden);
						
						/* Banner days_reminder */
						banner_days_reminder = validate.check_text(banner_days_reminder, 15);//alert(banner_days_reminder);
						
						/* Banner force_display */
						banner_force_display = validate.check_text(banner_force_display, null);//alert(banner_force_display);
						
						/* Banner hide_on_install */
						banner_hide_on_install = validate.check_text(banner_hide_on_install, true);//alert(banner_hide_on_install);
						
						/* Banner overlay_layer */
						banner_overlay_layer = validate.check_text(banner_overlay_layer, false);//alert(banner_overlay_layer);
						
						/* Banner ios_universall_app */
						banner_ios_universall_app = validate.check_text(banner_ios_universall_app, true);//alert(banner_ios_universall_app);
						
						/* Banner append_to_selector */
						banner_append_to_selector = validate.check_text(banner_append_to_selector, 'installify_banner');//alert(banner_append_to_selector);
						
						/* Banner install_message */
						banner_install_message = validate.check_text(banner_install_message, 'Installation successfull');//alert(banner_install_message);
						
						/* Banner close_message */
						banner_close_message = validate.check_text(banner_close_message, 'Closed');//alert(banner_close_message);
												/* Clear smart banner */
						//$('installify_banner').html('');
						/* Generate banner using validated variables *///alert(banner_title);
						$.smartbanner({
							title: banner_title, // What the title of the app should be in the banner (defaults to <title>)
							author: banner_author, // What the author of the app should be in the banner (defaults to <meta name="author"> or hostname)
							price: banner_price, // Price of the app
							appStoreLanguage: banner_langauge, // Language code for App Store
							inAppStore: banner_app_store_lang, // Text of price for iOS
							inGooglePlay: banner_play_store_lang, // Text of price for Android
							inAmazonAppStore: banner_amazon_store_lang,
							inWindowsStore: banner_windows_store_lang, // Text of price for Windows
							GooglePlayParams: banner_play_store_params, // Aditional parameters for the market
							icon: banner_icon_url, // The URL of the icon (defaults to <meta name="apple-touch-icon">)
							iconGloss: banner_ios_icon_gloss, // Force gloss effect for iOS even for precomposed
							url: banner_url, // The URL for the button. Keep null if you want the button to link to the app store.
							button: banner_button_text, // Text for the install button
							scale: banner_auto_scale, // Scale based on viewport size (set to 1 to disable)
							speedIn: banner_speed_in, // Show animation speed of the banner
							speedOut: banner_speed_out, // Close animation speed of the banner
							daysHidden: banner_days_hidden, // Duration to hide the banner after being closed (0 = always show banner)
							daysReminder: banner_days_reminder, // Duration to hide the banner after "VIEW" is clicked *separate from when the close button is clicked* (0 = always show banner)
							force: banner_force_display, // Choose 'ios', 'android' or 'windows'. Don't do a browser check, just always show this banner
							hideOnInstall: banner_hide_on_install, // Hide the banner after "VIEW" is clicked.
							layer: banner_overlay_layer, // Display as overlay layer or slide down the page
							iOSUniversalApp: banner_ios_universall_app, // If the iOS App is a universal app for both iPad and iPhone, display Smart Banner to iPad users, too.      
							appendToSelector: banner_append_to_selector, //Append the banner to a specific selector
							onInstall: function() {
							},
							onClose: function() {
							}
						});
						
						//apply banner styles
						//border top
						$('#smartbanner.android').css('border-top', '5px solid #'+top_border_color);
						$('#smartbanner.ios').css('border-top', '5px solid #'+top_border_color);
						$('#smartbanner.windows').css('border-top', '5px solid #'+top_border_color);
						
						//gradient
						$('#smartbanner.android').css('background', 'linear-gradient(#'+top_gradient_color+', #'+bottom_gradient_color+')');
						$('#smartbanner.ios').css('background', 'linear-gradient(#'+top_gradient_color+', #'+bottom_gradient_color+')');
						$('#smartbanner.windows').css('background', 'linear-gradient(#'+top_gradient_color+', #'+bottom_gradient_color+')');
						
						//text
						$('#smartbanner.android .sb-info strong').css('color', '#'+text_color);
						$('#smartbanner.ios .sb-info strong').css('color', '#'+text_color);
						$('#smartbanner.windows .sb-info strong').css('color', '#'+text_color);
						$('#smartbanner .sb-info > span').css('color', '#'+text_color);
						
						//button
						$('#smartbanner.android .sb-button span').css('background-color', '#'+button_color);
						$('#smartbanner.android .sb-button span').css('background-image', '-moz-linear-gradient(center top , #'+button_color+', #'+button_color+')');
						
						$('#smartbanner.ios .sb-button').css('background-color', '#'+button_color);
						$('#smartbanner.ios .sb-button').css('background-image', '-moz-linear-gradient(center top , #'+button_color+', #'+button_color+')');
						
						$('#smartbanner.windows .sb-button').css('background-color', '#'+button_color);
						$('#smartbanner.windows .sb-button').css('background-image', '-moz-linear-gradient(center top , #'+button_color+', #'+button_color+')');
						
						//button text
						$('#smartbanner.android .sb-button span').css('color', '#'+button_text_color);
						$('#smartbanner.ios .sb-button span').css('color', '#'+button_text_color);
						$('#smartbanner.windows .sb-button span').css('color', '#'+button_text_color);
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

//close smart banner
$(document).on("click","#smartbanner .sb-close",function() 
{
	var days_hidden = parseInt($.cookie("days_hidden"));
	
	if(days_hidden > 0)
	{
		//alert(days_hidden);
	}
	
	else
	{
		days_hidden = 10;
	}
	//set close cookie
	$.cookie("sb-closed", 1, { expires : days_hidden });
	
	//close banner
	$('#smartbanner').fadeTo(500, 0).slideUp(500, function(){
		$('#smartbanner').remove();
	});
});

//View app
$(document).on("click","#smartbanner .sb-button",function() 
{
	var days_reminder = parseInt($.cookie("days_reminder"));
	var website_address = $.cookie("website_address");
	var location = $(this).attr('href');
	if(days_reminder > 0)
	{
		//alert(days_hidden);
	}
	
	else
	{
		days_reminder = 10;
	}
	//set close cookie
	$.cookie("sb-installed", 1, { expires : days_reminder });
	
	//close banner
	$('#smartbanner').fadeTo(500, 0).slideUp(500, function(){
		$('#smartbanner').remove();
	});
	
	$.getScript( base_url+'assets/themes/hgoebl-mobile-detect/mobile-detect.min.js', function() 
	{
		//get browser
		var md = new MobileDetect(window.navigator.userAgent);
		
		// more typically we would instantiate with 'window.navigator.userAgent'
		// as user-agent; this string literal is only for better understanding
		
		var mobile = md.mobile();          // 'Sony'
		var phone = md.phone();           // 'Sony'
		var tablet = md.tablet();          // null
		var browser = md.userAgent();       // 'Safari'
		var os = md.os();              // 'AndroidOS'
		var iphone = md.is('iPhone');      // false
		var bot = md.is('bot');         // false
		var webkit = md.version('Webkit');         // 534.3
		var build = md.versionStr('Build');       // '4.1.A.0.562'
		var game_console = md.match('playstation|xbox'); // false
		//save click to db
		$.ajax({
			type:'POST',
			url: base_url+'site/banner/save_app_views/'+website_address,
			dataType: 'json',
			data: {device: mobile, phone: phone, tablet: tablet, browser:browser, os: os, iphone: iphone, bot: bot, webkit: webkit, build: build, game_console: game_console},
			success:function(data){
				//alert(data.message);
				if(data.result == "true")
				{
					window.location.href = location;
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
	});
	return false;
});