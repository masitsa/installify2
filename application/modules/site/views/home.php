		
	<?php //echo $this->load->view('includes/top_navigation', '', TRUE); ?>
	<?php echo $this->load->view('includes/navigation', '', TRUE); ?>
    <?php echo $this->load->view('home/head', '', TRUE); ?>
    <div id="page-body">
		<?php echo $this->load->view('home/installs', '', TRUE); ?>
        <?php echo $this->load->view('home/increase', '', TRUE); ?>
        <?php echo $this->load->view('home/ease', '', TRUE); ?>
        <?php echo $this->load->view('home/mobile', '', TRUE); ?>
        <?php echo $this->load->view('home/faqs', '', TRUE); ?>
        <?php echo $this->load->view('home/testimonials', '', TRUE); ?>
        <?php echo $this->load->view('home/ready', '', TRUE); ?>
        <?php echo $this->load->view('site/includes/footer', '', TRUE); ?>
	</div>