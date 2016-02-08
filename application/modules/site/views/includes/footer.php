<?php
	if(count($contacts) > 0)
	{
		$email = $contacts['email'];
		$facebook = $contacts['facebook'];
		$twitter = $contacts['twitter'];
		$logo = $contacts['logo'];
		$company_name = $contacts['company_name'];
		$phone = $contacts['phone'];
	}
?>

<footer class="page-footer">
    <div class="container">
        <div class="row">
            <!--<div class="col l6 s12">
                <h5 class="white-text">Installify</h5>
                <p class="grey-text text-lighten-4">Increase organic installs of your mobile application.</p>
            </div>-->
            <div class="col offset-m4 m8 s12">
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Blog</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Contact</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Terms of Use</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Privacy Policy</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="footer-copyright">
    	<div class="container">
            © <?php echo date('Y');?> <?php echo $company_name;?>
        </div>
    </div>
</footer>