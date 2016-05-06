<?php
$customer_details = $this->orders_model->get_customer($this->session->userdata('customer_id'));

if($customer_details->num_rows() > 0)
{
	$row = $customer_details->row();
	$customer_first_name = $row->customer_first_name;
	$customer_surname = $row->customer_surname;
}

$contacts = $this->site_model->get_contacts();
?>
<div class="row receipt_bottom_border">
	<div class="col m12 center-align">
    	<strong>Clicks</strong>
    </div>
</div>

<div class="row">
	<div class="col m12">
        <table class="table table-hover table-bordered table-striped col m12">
            <thead>
            <tr>
              <th>#</th>
              <th>Created</th>
              <th>Device</th>
              <th>Phone</th>
              <th>Browser</th>
              <th>OS</th>
              <th>iphone</th>
              <th>Bot</th>
              <th>Webkit</th>
              <th>Build</th>
              <th>Game Console</th> 
            </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                $total = 0;
				
				if($clicks->num_rows() > 0)
				{
					foreach($clicks->result() as $res3)
					{
						$count++;
						$device = $res3->device;
						$phone = $res3->phone;
						$tablet = $res3->tablet; 
						$browser = $res3->browser;
						$os = $res3->os;
						$iphone = $res3->iphone; 
						$bot = $res3->bot;
						$webkit = $res3->webkit;
						$build = $res3->build;
						$game_console = $res3->game_console;
						$created = $res3->created;             
						?>
						<tr>
							<td><?php echo $count;?></td>
							<td><?php echo $device;?></td>
							<td><?php echo $phone;?></td>
							<td><?php echo $tablet;?></td>
							<td><?php echo $browser;?></td>
							<td><?php echo $os;?></td>
							<td><?php echo $iphone;?></td>
							<td><?php echo $bot;?></td>
							<td><?php echo $webkit;?></td>
							<td><?php echo $build;?></td>
							<td><?php echo $game_console;?></td>
							<td><?php echo $created;?></td>
						</tr>
						<?php
					
					}
				}
				?>
            </tbody>
          </table>
    </div>
</div>
