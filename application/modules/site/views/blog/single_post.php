<?php echo $this->load->view('includes/navigation', '', TRUE); ?>

<?php

$post_id = $row->post_id;
$blog_category_name = $row->blog_category_name;
$blog_category_id = $row->blog_category_id;
$post_title = $row->post_title;
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
$created_on = date('jS M Y H:i a',strtotime($row->created));

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
		
		if($count == $categories_query->num_rows())
		{
			$categories .= '<a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts in '.$category_name.'" rel="category tag">'.$category_name.'</a>';
		}
		
		else
		{
			$categories .= '<a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts in '.$category_name.'" rel="category tag">'.$category_name.'</a>, ';
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
			$date = date('jS M Y H:i a',strtotime($row->comment_created));
			
			$comments .= 
			'
				<div class="user_comment">
					<h5>'.$post_comment_user.' - '.$date.'</h5>
					<p>'.$post_comment_description.'</p>
				</div>
			';
		}
	}
	



?>


<div class="section blog-section active-section">
			<div class="pagetop">
					<div class="page-name">
						<div class="container">
							<h1><?php echo $post_title;?></h1>
							<ul>
								<li><a href="<?php echo base_url();?>home" title="">Home</a></li>
								<li><a href="<?php echo base_url();?>blog" title="">Blog List</a></li>
								<li><?php echo $post_title;?></li>
							</ul>
						</div>
					</div>
				</div>

            <div class="container">

              
                <div class="row">
                    <div class="col m8">
                        <div class="content">
                            <div class="entry format-standard">
                            	<div class="entry-top">
                                    <ul class="entry-meta list-inline">
                                        <li><a href="#" title=""><?php echo $created_on;?> by <?php echo $created_by;?></a></li>
                                        <li><a href="#comments" title=""><?php echo $total_comments;?> <?php echo $title;?></a></li>
                                    </ul>
                                    <h3 class="entry-title"><a href="#" title=""><?php echo $post_title;?></a></h3>
                                </div><!--/.entry-top-->
                                <div class="entry-media">
                                    <a href="#" title=""><img src="<?php echo $image;?>" alt="" class="img-responsive"></a>
                                </div><!--/.entry-media-->
                                
                                <div class="entry-content">
                    				<p><?php echo $description;?>  </p>
                                </div><!--/.entry-content-->
                                <div class="entry-bottom">
                                    <ul class="list-inline entry-meta text-center">
                                        <li class="pull-left"><a href="#" title="">Prev Post</a></li>
                                        <li><a href="#" title=""><img alt="Jane Doe" src="demo/team/team1.jpg" class="avatar avatar-30 photo" height="30" width="30"> John Doe</a></li>
                                        <li class="pull-right"><a href="#" title="">Next Post</a></li>
                                    </ul><!--/.entry-meta-->
                                </div><!--/.entry-bottom-->
                            </div><!--/.entry-->
                            <div id="comments" class="comment-list">
                                <h3 class="comment-title">5 comments</h3>
                                <ul class="media-list text clearlist">
                                    
                                    <!-- Comment Item -->
                                    <li class="media comment-item">
                                        <div class="media-body">
                                            <div class="comment-item-data">
                                                <a class="pull-left" href="#"><img class="media-object comment-avatar" src="demo/team/team1.jpg" alt="" width="46" height="46"></a>
                                                <div class="comment-author">
                                                    <a href="#">John Doe</a>
                                                </div>
                                                Feb 9, 2014, at 10:23<span class="separator">—</span>
                                                <a href="#">Reply</a>
                                            </div>
                                            <p>Vestibulum pellentesque, purus ut dignissim consectetur, nulla erat ultrices purus, ut consequat sem elit non sem. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa. Fusce non ante sed lorem rutrum feugiat.</p>
                                            
                                            <!-- Comment of second level -->
                                            <div class="media comment-item">
                                                <div class="media-body">
                                                    <div class="comment-item-data">
                                                        <a class="pull-left" href="#"><img class="media-object comment-avatar" src="demo/team/team2.jpg" alt="" width="46" height="46"></a>
                                                        <div class="comment-author">
                                                            <a href="#">Sam Brin</a>
                                                        </div>
                                                        Feb 9, 2014, at 10:27<span class="separator">—</span>
                                                        <a href="#">Reply</a>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non laoreet dui. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est. Integer sit amet mi id sapien tempor molestie in nec massa.</p>
                                                </div>
                                            </div>
                                            <!-- End Comment of second level -->
                                        </div>
                                    </li>
                                    <!-- End Comment Item -->
                                    <!-- Comment Item -->
                                    <li class="media comment-item">
                                        <div class="media-body">
                                            <div class="comment-item-data">
                                                <a class="pull-left" href="#"><img class="media-object comment-avatar" src="demo/team/team3.jpg" alt="" width="46" height="46"></a>
                                                <div class="comment-author">
                                                    <a href="#">Emma Johnson</a>
                                                </div>
                                                Feb 9, 2014, at 10:37 <span class="separator">—</span>
                                                <a href="#">Reply</a>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at magna ut ante eleifend eleifend.</p>
                                        </div>
                                    </li>
                                    <!-- End Comment Item -->
                                    <!-- Comment Item -->
                                    <li class="media comment-item">
                                        <div class="media-body">
                                            <a class="pull-left" href="#"><img class="media-object comment-avatar" src="demo/team/team4.jpg" alt="" width="46" height="46"></a>
                                            <div class="comment-item-data">
                                                <div class="comment-author">
                                                    <a href="#">John Doe</a>
                                                </div>
                                                Feb 9, 2014, at 10:3<span class="separator">—</span>
                                                <a href="#">Reply</a>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non laoreet dui. Morbi lacus massa, euismod ut turpis molestie, tristique sodales est.</p>
                                        </div>
                                        
                                    </li>
                                    <!-- End Comment Item -->
                                    
                                </ul>
                                <h3 class="reply-title">Leave a Comment</h3>
                                <form data-toggle="validator" role="form" novalidate="true">
                                    <div class="form-group row">
                                        <div class="form-group col m6">
                                            <!-- Name -->
                                            <input type="text" class="form-control" id="inputName" placeholder="Name" required="">
                                            <div class="help-block with-errors"></div>
                                        </div><!--/.col-->
                                        <div class="form-group col m6">
                                            <!-- Email -->
                                            <input type="email" id="inputEmail" class="form-control" placeholder="Email" maxlength="100" data-error="Bruh, that email address is invalid" required="">
                                            <div class="help-block with-errors"></div>
                                        </div><!--/.col-->
                                    </div><!--/.row-->

                                    <div class="form-group">
                                        <!-- Website -->
                                        <input type="url" id="inputWebsite" class="form-control" placeholder="Website" maxlength="100" required="">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                    <!-- Comment -->
                                    <div class="from-group">
                                        <textarea id="inputText" class="input-md form-control" rows="6" placeholder="Comment" maxlength="400"></textarea>
                                    </div>
                                    
                                    <!-- Send Button -->
                                    <button type="submit" class="btn btn-punch btn-xs btn-black btn-darker disabled" style="pointer-events: all; cursor: pointer;">Send comment</button>
                                    
                                </form>
                            </div>
                        </div><!--/.content-->
                    </div><!--/.col-->
                    <aside class="col m4 column sidebar">
                       	<?php echo $this->load->view('blog/includes/side_bar', '', TRUE);?>
                    </aside><!--/.col-->
                </div><!--/.row-->
            </div><!--/.container-->
        </div>
<?php echo $this->load->view('site/includes/footer', '', TRUE); ?>