<?php
$recent_query = $this->blog_model->get_recent_posts();
$recent_posts  ='';
if($recent_query->num_rows() > 0)
{
	$row = $recent_query->row();
	
	$post_id = $row->post_id;
	$post_title = $row->post_title;
	$web_name = $this->site_model->create_web_name($post_title);
	$image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
	$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
	$description = $row->post_content;
	$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 50));
	$created = date('jS M Y',strtotime($row->created));
	$recent_posts .= '
	 		
            <li>
	            <img src="'.$image.'" alt="">
	            <a href="#" title="">'.$post_title.'</a>
	            <span>'.$created.'</span>
	        </li>
		
	';

}

else
{
	$recent_posts = 'No posts yet';
}
$categories_query = $this->blog_model->get_all_active_category_parents();
$categories = '';
if($categories_query->num_rows() > 0)
{
	
	foreach($categories_query->result() as $res)
	{
		$category_id = $res->blog_category_id;
		$category_name = $res->blog_category_name;
		$web_name = $this->site_model->create_web_name($category_name);
		
		$children_query = $this->blog_model->get_all_active_category_children($category_id);
		
		//if there are children
		$categories = '<li><span>75</span><a href="'.site_url().'blog/category/'.$web_name.'" title="">'.$category_name.'</a></li>';
		// $categories .= '<li><a href="'.site_url().'blog/category/'.$web_name.'"><i class="fa fa-angle-right about-list-arrows"></i>'.$category_name.'</a></li>';
	}
}

else
{
	$categories = 'No Categories';
}
$popular_query = $this->blog_model->get_popular_posts();

if($popular_query->num_rows() > 0)
{
	$popular_posts = '';
	
	foreach ($popular_query->result() as $row)
	{
		$post_id = $row->post_id;
		$post_title = $row->post_title;
		$web_name = $this->site_model->create_web_name($post_title);
		$image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
		$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
		$description = $row->post_content;
		$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
		$created = date('jS M Y',strtotime($row->created));
		
		$popular_posts .= '
			<li>
	            <img src="'.$image.'" alt="">
	            <a href="'.site_url().'blog/'.$web_name.'" title="'.$post_title.'">'.$post_title.'</a>
	            <span>'.$created.'</span>
	        </li>
			
				
		';
	}
}

else
{
	$popular_posts = 'No posts views yet';
}
?>
 <div class="widget">
 	<h3 class="widget-title">Recent Posts</h3>
    <ul class="recent-posts">
        <?php echo $recent_posts;?>
    </ul>
</div><!--/.widget-->
 <div class="widget">
    <h3 class="widget-title">Categories</h3>
    <ul >
        <?php echo $categories;?>
    </ul>
</div><!--/.widget-->
 <div class="widget">
    <h3 class="widget-title">Popular Posts</h3>
    <ul class="recent-posts">
        <?php echo $popular_posts;?>
    </ul>
</div><!--/.widget-->





