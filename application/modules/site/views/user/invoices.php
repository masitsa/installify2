<?php
			//check if customer has subscribed to any plans
			if($invoices->num_rows() > 0)
			{
				?>
				<div class="row">
					<div class="col m12">
						<h5 class="header">Invoices</h5>
						
						<table class="striped">
							<thead>
								<tr>
									<th>Invoice #</th>
									<th>Date</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							
							<tbody>
							<?php
                            foreach($invoices->result() as $res2)
                            {
                                $order_id = $res2->order_id;
                                $order_date = $res2->order_date;
                                $receipt_number = $res2->receipt_number;
                                $order_number = $res2->order_number;
                                $order_status_name = $res2->order_status_name;
								
								$order_items_query = $this->orders_model->get_invoice_items($order_id);
								$v_data['order_date'] = $order_date;
								$v_data['receipt_number'] = $receipt_number;
								$v_data['order_number'] = $order_number;
								$v_data['order_status_name'] = $order_status_name;
								$v_data['order_items_query'] = $order_items_query;
                                //display invoice?>
								<tr>
									<td><?php echo $order_number;?></td>
									<td><?php echo date('jS M Y', strtotime($order_date));?></td>
									<td><?php echo $order_status_name;?></td>
									<td>
                                    	<a class="waves-effect waves-light btn blue modal-trigger" href="#invoice<?php echo $order_id;?>">View</a>
                                        <div class="modal" id="invoice<?php echo $order_id;?>">
                                            <div class="modal-content">
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <?php echo $this->load->view('user/invoice', $v_data, TRUE);?>
                                                    </div>
                                                </div>
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
								<?php
                            }
							
							?>
                            </tbody>
                        </table>
					</div>
                    
                    <?php if(isset($links)){echo $links;}?>
			</div>
			<?php } else{?>
			<p class="center-align">You have not made any payments</p>
            <?php }?>