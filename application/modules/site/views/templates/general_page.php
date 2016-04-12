<!DOCTYPE html>
<html lang="en">
    <head>
    	<?php echo $this->load->view('site/includes/header', '', TRUE); ?>
        <!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);mixpanel.init("67b4540b4278f9b5d4f8dc8d2a96ad15");</script><!-- end Mixpanel -->
    </head>
    <body class="smooth-navigation">
    	<input type="hidden" id="base_url" value="<?php echo base_url();?>"/>
        <?php //echo $this->load->view('site/includes/top_navigation', $data, TRUE); ?>
        <?php 
			if(isset($sign_up))
			{
				?>
                <input type="hidden" id="sign_up" value="<?php echo $sign_up;?>"/>
                <?php
			}
			
			else
			{
				?>
                <input type="hidden" id="sign_up" value="0"/>
                <?php
			}
		?>
            
		<?php echo $content;?>
        
        <script type="text/javascript" src="<?php echo base_url()."assets/themes/materialize/";?>js/materialize.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()."assets/themes/jscolor/";?>jscolor.js"></script>
        <script type="text/javascript" src="<?php echo base_url()."assets/themes/owl-carousel/";?>owl.carousel.min.js"></script>
        <script src="<?php echo base_url()."assets/themes/custom/js/";?>masonry.pkgd.min.js"></script>
        <script type="application/javascript">
			$( document ).ready(function()
			{
				$('.owl-carousel').owlCarousel({
					loop:true,
					margin:10,
					responsiveClass:true,
					responsive:{
						0:{
							items:1,
							nav:true
						},
						600:{
							items:3,
							nav:false
						},
						1000:{
							items:5,
							nav:true,
							loop:false
						}
					}
				});
			});
			
			$(document).on("click","button.learn_more",function(e)
			{
				e.preventDefault();
				$('#page-body').css('display', 'block');
				//return true;
				
				var target = '#installs';
				var $target = $(target);
		
				$('html, body').stop().animate({
					'scrollTop': $target.offset().top
				}, 900, 'swing', function () {
					window.location.hash = target;
				});
			});
		</script>
        
        <?php
		$error = $this->session->userdata('error_message');
		$success = $this->session->userdata('success_message');
		
		//display error
		if(!empty($error))
		{
			?>
			<script type="text/javascript">
				$( document ).ready(function() {
					var response = '<span><?php echo $error;?></span>';
					Materialize.toast(response, 5000);
				});
			</script>
			<?php
			$this->session->unset_userdata('error_message');
		}
		
		//display error
		if(!empty($success))
		{
			?>
			<script type="text/javascript">
				$( document ).ready(function() {
					var response = '<span><?php echo $success;?></span>';
					Materialize.toast(response, 5000);
				});
			</script>
			<?php
			$this->session->unset_userdata('success_message');
		}
		?>
        <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-75042830-1', 'auto');
		  ga('send', 'pageview');
		
		</script>

    </body>
</html>