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

<!--<header class="blue lighten-2">-->
<header class="">
	<div class="container">
        <!--<nav class="blue lighten-2">-->
        <nav>
            <div class="nav-wrapper">
                <a href="<?php echo site_url();?>" class="brand-logo">
                    <img src="<?php echo base_url().'assets/logo/white.png';?>" class="responsive-img" alt="<?php echo $company_name;?>">
                </a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <!--<li><a href="<?php echo site_url();?>">Home</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>-->
                    <li><a href="#" class="btn" id="google_signin">Sign in</a></li>
                </ul>
            </div>
        </nav>

		<li class="divider"></li>
    </div>
</header>