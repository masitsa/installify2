<?php
	if(count($contacts) > 0)
	{
		$email = $contacts['email'];
		$email2 = $contacts['email'];
		$facebook = $contacts['facebook'];
		$twitter = $contacts['twitter'];
		$linkedin = $contacts['linkedin'];
		$logo = $contacts['logo'];
		$company_name = $contacts['company_name'];
		$phone = $contacts['phone'];
		
		if(!empty($facebook))
		{
			$facebook = '<li class="facebook"><a href="'.$facebook.'" target="_blank" title="Facebook">Facebook</a></li>';
		}
		
	}
	else
	{
		$email = '';
		$facebook = '';
		$twitter = '';
		$linkedin = '';
		$logo = '';
		$company_name = '';
		$google = '';
	}
?>
<div class="" style="background-color:#FFC107;">
	
    <div class="top-navigation container">
    	<div class="row">
            <div class="col s3">
            	<a class="waves-effect waves-light btn btn-small blue lighten-2" href="mailto:info@installify.io"><i class="fa fa-envelope"></i> info@installify.io</a>
            </div>
            
            <div class="col s2 offset-s7">
            	<?php
				if($this->session->userdata('login_status'))
				{
					?>
                	<a class="waves-effect waves-light btn btn-small blue lighten-2" href="<?php echo site_url().'my-account';?>"><i class="fa fa-user"></i> Account</a>
					<?php
				}
				
				else
				{
					?>
                    <a class="waves-effect waves-light btn btn-small blue lighten-2" href="<?php echo site_url().'my-account';?>"><i class="fa fa-user"></i> Account</a>
					<?php
				}
				?>
            </div>
        </div>
    </div>
    
</div>
