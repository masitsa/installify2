<!DOCTYPE html>
<html lang="en">
    <head>
    	<?php echo $this->load->view('site/includes/header', '', TRUE); ?>
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
        
        <!--Start of Zopim Live Chat Script-->
		<script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
        $.src="//v2.zopim.com/?3rBjWQlkYAbyFGWONGi3yXjlu9WTErDi";z.t=+new Date;$.
        type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
        </script>
        <!--End of Zopim Live Chat Script-->

    </body>
</html>