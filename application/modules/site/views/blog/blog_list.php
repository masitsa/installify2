<?php echo $this->load->view('includes/blog_navigation', '', TRUE); ?>

<?php

		$result = '';
		
		//if users exist display them
	
		if ($query->num_rows() > 0)
		{	
			//get all administrators
			$administrators = $this->users_model->get_all_administrators();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
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
				$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
				$categories_query = $this->blog_model->get_all_post_categories($blog_category_id);
				$description = $row->post_content;
				$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 50));
				$created = $row->created;
				$day = date('j',strtotime($created));
				$month = date('M Y',strtotime($created));
				$created_on = date('jS M Y',strtotime($row->created));
				
				$categories = '';
				$count = 0;
				//get all administrators
					$administrators = $this->users_model->get_all_administrators();
					if ($administrators->num_rows() > 0)
					{
						$admins = $administrators->result();
						
						if($admins != NULL)
						{
							foreach($admins as $adm)
							{
								$user_id = $adm->user_id;
								
								if($user_id == $created_by)
								{
									$created_by = $adm->first_name;
								}
							}
						}
					}
					
					else
					{
						$admins = NULL;
					}
				
					foreach($categories_query->result() as $res)
					{
						$count++;
						$category_name = $res->blog_category_name;
						$category_id = $res->blog_category_id;
						$category_web_name = $this->site_model->create_web_name($category_name);
						
						if($count == $categories_query->num_rows())
						{
							$categories .= '<a href="'.site_url().'blog/category/'.$category_web_name.'" title="View all posts in '.$category_name.'" rel="category tag">'.$category_name.'</a>';
						}
						
						else
						{
							$categories .= '<a href="'.site_url().'blog/category/'.$category_web_name.'" title="View all posts in '.$category_name.'" rel="category tag">'.$category_name.'</a>, ';
						}
					}
					$comments_query = $this->blog_model->get_post_comments($post_id);
					//comments
					$comments = 'No Comments';
					$total_comments = $comments_query->num_rows();
					if($total_comments == 1)
					{
						$title = 'comment';
					}
					else
					{
						$title = 'comments';
					}
					
					if($comments_query->num_rows() > 0)
					{
						$comments = '';
						foreach ($comments_query->result() as $row)
						{
							$post_comment_user = $row->post_comment_user;
							$post_comment_description = $row->post_comment_description;
							$date = date('jS M Y',strtotime($row->comment_created));
							
							$comments .= 
							'
								<div class="user_comment">
									<h5>'.$post_comment_user.' - '.$date.'</h5>
									<p>'.$post_comment_description.'</p>
								</div>
							';
						}
					}
				$result .= '

					<div class="entry format-standard">
						 <div class="entry-top" style=" margin-top:-15px">
						 	<div class="right">'.$categories.'</div>
                            <h3 class="entry-title"><a href="'.site_url().'blog/'.$web_name.'" title="">'.$post_title.'</a></h3>
							<div class="divider"></div>
                            <ul class="entry-meta list-inline">
                                <li><a href="#" title="">'.$created_on.'</a></li>
                                <li><a href="'.site_url().'blog/'.$web_name.'#comments" title="">'.$total_comments.'</a></li>
                            </ul>
                        </div><!--/.entry-top-->
                        <div class="entry-media">
                            <a href="'.site_url().'blog/'.$web_name.'" title=""><img src="'.$image.'" alt="" class="img-responsive"></a>
                        </div><!--/.entry-media-->
                       
                        <div class="entry-content">
                            <p>'.$mini_desc.' <a href="'.site_url().'blog/view-single/'.$web_name.'">[...]</a> </p>
                        </div><!--/.entry-content-->
                        <div class="entry-bottom">

                            <ul class="list-inline entry-meta">
                            	<li class="pull-left hidden-xs hidden-md hidden-mobile">
                            	<div data-easyshare data-easyshare-url="'.site_url().'blog/view-single/'.$web_name.'">
									  <!-- Total -->
									  <button data-easyshare-button="total">
									    <span>Total</span>
									  </button>
									  <span data-easyshare-total-count>0</span>

									  <!-- Facebook -->
									  <button data-easyshare-button="facebook">
									    <span class="fa fa-facebook"></span>
									    <span>Share</span>
									  </button>
									  <span data-easyshare-button-count="facebook">0</span>

									  <!-- Twitter -->
									  <button data-easyshare-button="twitter" data-easyshare-tweet-text="'.$post_title.'">
									    <span class="fa fa-twitter"></span>
									    <span>Tweet</span>
									  </button>
									  <span data-easyshare-button-count="twitter">0</span>

									  <!-- Google+ -->
									  <button data-easyshare-button="google">
									    <span class="fa fa-google-plus"></span>
									    <span>+1</span>
									  </button>
									  <span data-easyshare-button-count="google">0</span>

									  <div data-easyshare-loader>Loading...</div>
									</div>
                            	</li>
                                <li class="pull-right hidden-xs hidden-md hidden-mobile"><a href="'.site_url().'blog/'.$web_name.'" title="" class="btn blue white-text">Read More</a></li>
                            </ul><!--/.entry-meta-->
                        </div><!--/.entry-bottom-->
                    </div><!--/.entry-->

		           
		            ';
		        }
			}
			else
			{
				$result .= "There are no posts :-(";
			}
           
          ?> 

<div class="section blog-section active-section">
    <div class="pagetop">
        <div class="page-name">
            <div class="container">
                <h1 class="white-text darken-2 right">BLOG</h1>
            </div>
        </div>
    </div>
    
    <!--<div class="pagetop grey lighten-4">
        <div class="page-name">
            <div class="container">
                <h1 class="grey-text darken-2">BLOG</h1>
                <ul>
                    <li><a href="<?php echo base_url();?>home" title="" class="grey-text darken-2">Home</a></li>
                    <li><a href="<?php echo base_url();?>blog" title="" class="grey-text darken-2">Blog List</a></li>
                </ul>
            </div>
        </div>
    </div>-->
        
    <div class="row grey lighten-4">
        <div class="col m12">
            <ul class="breadcrumbs">
                <li><a href="<?php echo base_url();?>home" title="" class="grey-text darken-2">Home</a></li>
                <li><a href="<?php echo base_url();?>blog" title="" class="grey-text darken-2">Blog List</a></li>
            </ul>
        </div>
    </div>
    
    <div class="container">
        <div class="row" style="margin-top:50px">
            <div class="col m8">
                <div class="content">
                   
                	<?php echo $result;?>
                    
                    <?php if(isset($links)){echo $links;}?>
                </div><!--/.content-->
            </div><!--/.col-->
            <div class="col m3 ">
              <?php echo $this->load->view('blog/includes/side_bar', '', TRUE);?>
            </div><!--/.col-->
        </div><!--/.row-->
    </div><!--/.container-->
</div>

<?php echo $this->load->view('site/includes/footer', '', TRUE); ?>