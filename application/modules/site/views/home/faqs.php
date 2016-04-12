<?php

   /* $result = '';
    
    //if users exist display them

    if ($faqs->num_rows() > 0)
    {   
       
        foreach ($faqs->result() as $row)
        {
            $post_id = $row->post_id;
            $blog_category_name = $row->blog_category_name;
            $blog_category_id = $row->blog_category_id;
            $post_title = $row->post_title;
            $web_name = $this->site_model->create_web_name($post_title);
            $post_status = $row->post_status;
            $post_views = $row->post_views;
            $image = base_url().'assets/images/posts/'.$row->post_image;
            $created_by = $row->created_by;
            $modified_by = $row->modified_by;
            $description = $row->post_content;
            $mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 50));
            $created = $row->created;
            $day = date('j',strtotime($created));
            $month = date('M Y',strtotime($created));
            $created_on = date('jS M Y',strtotime($row->created));
            
            $categories = '';
            $count = 0;
           
              
            $result .= '
                        <li>
                            <div class="collapsible-header"><i class="material-icons">info_outline</i>'.$post_title.'</div>
                            <div class="collapsible-body"><p>'.$description.'</p></div>
                        </li>
                   
                ';
            }
        }
        else
        {
            $result .= "There are no faqs :-(";
        }*/
       
      ?> 
<!--<div class="grey lighten-4 section-content">
	<div class="container">
        
        <h3 class="header center-align grey-text darken-2 margin-height-60">Frequently asked questions</h3>
        
        <div class="row">
            
            <div class="col m12">
            	<ul class="collapsible popout" data-collapsible="accordion">
                    <?php echo $result;?>
                </ul>
            </div>
        </div>
        
        <div class="margin-height-60"></div>
        
    </div>
</div>-->

<div class="grey lighten-4 section-content">
	<div class="container">
        
        <h3 class="header center-align grey-text darken-2 margin-height-60">Frequently asked questions</h3>
        
        <div class="row">
            
            <div class="col m12">
            	<ul class="collapsible popout" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons">info_outline</i>Is there a cost to using Installify?</div>
                        <div class="collapsible-body"><p>No, there is no cost unless you sign up for our premium packages. Our free package allows you up to 1500 clicks for free.</p></div>
                    </li>
                    
                    <li>
                        <div class="collapsible-header"><i class="material-icons">info_outline</i>Is there any examples of this in practice?</div>
                        <div class="collapsible-body"><p>We can show you what it would like on your website in practice if you click here and sign-in with Google.</p></div>
                    </li>
                    
                    <li>
                        <div class="collapsible-header"><i class="material-icons">info_outline</i>How many organic installs can I receive using your service?</div>
                        <div class="collapsible-body"><p>This varies from user to user. It depends on a number of factors including your volume of web traffic, proportion of web traffic that is mobile traffic, relevence and source of traffic.</p></div>
                    </li>
                    
                    <li>
                        <div class="collapsible-header"><i class="material-icons">info_outline</i>Which platforms do you work with?</div>
                        <div class="collapsible-body"><p>At present we work with iOS, Android and Windows phone devices.</p></div>
                    </li>
                    
                    <li>
                        <div class="collapsible-header"><i class="material-icons">info_outline</i>Will I be forced to pay if I exceed my free allowance?</div>
                        <div class="collapsible-body"><p>No, if after you have exceeded your free allowance of clicks, we will send you an email to let you know. We will then disable your banner either until the next month and you have a new click quota or until you decide to upgrade your account.</p></div>
                    </li>
                    
                    <li>
                        <div class="collapsible-header"><i class="material-icons">info_outline</i>How can I track the results of my banner campaigns?</div>
                        <div class="collapsible-body"><p>We recommend using Appsflyer. It is free to attribute and track organic installs on Appsflyer. Set up links that uniquely identify your smartbanner on Appsflyer and then use this link in your smart banner setup.</p></div>
                    </li>
                    
                    <li>
                        <div class="collapsible-header"><i class="material-icons">info_outline</i>Can installify be user by marketers, who do not have technical or coding skills?</div>
                        <div class="collapsible-body"><p>Yes. All of our setup is very easy and done within our webapp, you can change all the banner attributes and properties. After the banner is created you will be given a Javascript code which you will have to put in the header of the page's HTML page. This is literally just a copy and paste job so nothing scary there. If you do need to use tech time, it should take no more than 5 minutes. Once installed you will be able to change all the baner properties in your Installify account.</p></div>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="margin-height-60"></div>
        
    </div>
</div>