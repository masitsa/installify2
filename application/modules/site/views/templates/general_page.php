<!DOCTYPE html>
<html lang="en">
    <head>
    	<?php echo $this->load->view('site/includes/header', '', TRUE); ?>
    </head>
    <body class="smooth-navigation">
    	<input type="hidden" id="base_url" value="<?php echo base_url();?>"/>
        <?php //echo $this->load->view('site/includes/top_navigation', $data, TRUE); ?>
            
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
    </body>
</html>