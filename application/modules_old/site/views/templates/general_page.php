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
    </body>
</html>