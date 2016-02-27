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
                 <!-- Comment Item -->
                    <li class="media comment-item">
                        <div class="media-body">
                            <div class="comment-item-data">
                                <div class="comment-author">
                                    <a href="#">'.$post_comment_user.'</a>
                                </div>
                                Feb 9, 2014, at 10:23<span class="separator">—</span>
                            </div>
                            <p>'.$post_comment_description.'</p>
                            
                        </div>
                    </li>
                    <!-- End Comment Item -->
				
			';
		}
	}
	



?>

<div class="section blog-section active-section">
    <div class="pagetop">
        <div class="page-name">
            <div class="container">
                <h1 class="white-text darken-2 right"><?php echo $post_title;?></h1>
            </div>
        </div>
    </div>
        
    <div class="row grey lighten-4">
        <div class="col m12">
            <ul class="breadcrumbs">
                <li><a href="<?php echo site_url();?>home" title="" class="grey-text darken-2">Home</a></li>
                <li><a href="<?php echo site_url();?>blog" title="" class="grey-text darken-2">Blog List</a></li>
                <li><?php echo $post_title;?></li>
            </ul>
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
                               <?php echo $previous_post;?>
                                <?php echo $next_post;?>
                               <!-- <li class="pull-right"><a href="#" title="">Next Post</a></li> -->
                            </ul><!--/.entry-meta-->
                        </div><!--/.entry-bottom-->
                    </div><!--/.entry-->
                    <div id="comments" class="comment-list">
                        <h3 class="comment-title"><?php echo $total_comments;?> <?php echo $title;?></h3>
                        <ul class="media-list text clearlist">
                            <?php echo $comments;?>
                            
                        </ul>
                        <h3 class="reply-title">Leave a Comment</h3>
                        <form method="post" action="<?php echo site_url().'site/blog/add_comment/'.$post_id.'/'.$web_name;?>" data-toggle="validator" novalidate="true">
                            <div class="form-group row">
                                <div class="form-group col m6">
                                    <!-- Name -->
                                    <input type="text" class="form-control" id="inputName" placeholder="Name" name="name" required="">
                                    <div class="help-block with-errors"></div>
                                </div><!--/.col-->
                                <div class="form-group col m6">
                                    <!-- Email -->
                                    <input type="email" id="inputEmail" class="form-control" placeholder="Email" name="email" maxlength="100" data-error="Bruh, that email address is invalid" required="">
                                    <div class="help-block with-errors"></div>
                                </div><!--/.col-->
                            </div><!--/.row-->

                
                            
                            <!-- Comment -->
                            <!--<div class="from-group">
                                <textarea id="inputText" name="post_comment_description" class="input-md form-control" rows="6" placeholder="Comment" maxlength="400"></textarea>
                            </div>-->
                            
                            <div class="input-field col s12">
                                <textarea id="textarea1" class="materialize-textarea" name="post_comment_description" maxlength="400" placeholder="Comment" rows="10"></textarea>
                                <label for="textarea1">Comment</label>
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