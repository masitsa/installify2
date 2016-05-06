<?php
$maximum_clicks = $this->banner_model->get_maximum_clicks($this->session->userdata('customer_id'));
$clicks = $this->banner_model->get_banner_clicks($this->session->userdata('customer_api_key'));
if($maximum_clicks == 0)
{
	$maximum_clicks = '&#8734;';
}
?>
<div class="row">
	<div class="col s12">
        <!-- title -->
        <div class="row">
            <div class="col s12">
                <h4 class="header center-align">Summary</h4>
            </div>
        </div>
        <!-- end title -->
        
        <div class="row">
        	<!--<div class="col m8 center-align">
            	<div id="expiry_year"></div>
            </div>-->
        	<div class="col m2 offset-m6">
            	<?php echo $clicks.'/'.$maximum_clicks;?> clicks used 
            </div>
        	<div class="col m2">
            	<a href="<?php echo site_url().'subscribe';?>" class="btn grey lighten-1 pull-right">Upgrade</a>
            </div>
            
        	<div class="col m2">
                <a href="#new_banner" class="btn grey lighten-1 modal-trigger"><i class="fa fa-plus"></i> New banner</a>
            </div>
        </div>
        <div class="row">
            
        	<div class="col m12">
				<?php
                //display payments
                if($banners->num_rows() > 0)
                {
                    $count = 0;
                    ?>
                    
                    <table>
                        <thead>
                            <tr>
                                <th data-field="id">#</th>
                                <th data-field="name">Website</th>
                                <th data-field="name">Age</th>
                                <th data-field="Expiry">Status</th>
                                <th data-field="Created">Installed</th>
                                <th data-field="Views">Conversions</th>
                                <th data-field=""></th>
                                <th data-field=""></th>
                                <th data-field=""></th>
                                <th data-field=""></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                    <?php
                    foreach($banners->result() as $res2)
                    {
						$smart_banner_id = $res2->smart_banner_id;
						$website_name = $res2->smart_banner_website;
						$smart_banner_status = $res2->smart_banner_status;
						$banner_installed = $res2->banner_installed;
						$smart_banner_created = $res2->smart_banner_created;
						$total_views = $this->banner_model->get_views($smart_banner_id);
						$total_banner_clicks = $this->banner_model->get_total_clicks($website_name, $this->session->userdata('customer_api_key'));
						$age = $this->site_model->get_days($smart_banner_created);
						$obfusicated = $this->banner_model->obfusicate_script($website_name, $this->session->userdata('customer_api_key'));
        
                        if($smart_banner_status == 1)
                        {
                            $status = 'Active';
							$button = '<a href="'.site_url().'banner-deactivation/"'.$smart_banner_id.'" class="btn grey lighten-1">Deactivate</a>';
                        }
                        else
                        {
                            $status = 'Disabled';
							$button = '<a href="'.site_url().'banner-activation/"'.$smart_banner_id.'" class="btn grey lighten-1">Aactivate</a>';
                        }
						
						if($banner_installed == 1)
                        {
                            $installed = 'Yes';
                        }
                        else
                        {
                            $installed = 'No';
                        }
                        $count++
                        ?>
                        <tr>
                            <td><?php echo $count;?></td>
                            <td><?php echo $website_name;?></td>
                            <td><?php echo $age;?> days</td>
                            <td><?php echo $status;?></td>
                            <td><?php echo $installed;?></td>
                            <td><?php echo $total_banner_clicks;?>/<?php echo $total_views;?> </td>
                            <!--<td><?php echo $button;?></td>
                            <td><a href="<?php echo site_url().'subscribe';?>" class="btn grey lighten-1">Upgrade</a></td>-->
                            <td>
                            	<a class="btn grey lighten-1 modal-trigger" href="#banner_settings<?php $smart_banner_id;?>">Install</a>
                                
                                <div class="modal" id="banner_settings">
                                    <div class="modal-content">
                                        <h4>Install <?php echo $website_name;?></h4>
										<p>Copy & paste this code before the &lt;/body&gt; tag of your website on every page that you would like the banner to appear</p>
<pre class=" language-markup">
<code class=" language-markup">
<span class="token tag"><span class="token punctuation">&lt;</span>script</span><span class="token punctuation">&gt;</span></span>
<?php echo $obfusicated; ?>
<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>/script</span><span class="token punctuation">&gt;</span></span></code>
</pre>
										<div class="clear"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="row">
                                            <div class="col m6">
                                                <button type="button" class="modal-action modal-close waves-effect waves-green btn red" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a href="<?php echo site_url().'banner/'.$smart_banner_id;?>" class="btn grey lighten-1">Edit</a></td>
                            <td><a href="<?php echo site_url().'delete-banner/'.$smart_banner_id;?>" class="btn grey lighten-1" onclick="return confirm('Are you sure you want to delete this banner?')">Delete</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                            </tbody>
                        </table>
                    <?php
                }
				
				else
				{
					?>
                    <p class="center-align">You have not added any banners.</p>
                    <?php
				}
                ?>
            </div>
			
        </div>
        
	</div>
</div>
