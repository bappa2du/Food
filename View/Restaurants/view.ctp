
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">
			<i class="icon-table"></i> <?php echo __('Restaurant'); ?> </h2>
	</div>
	<table class="table table-striped">
		<tr>
			<td colspan="1">
            <?php if (strlen ( trim ( $restaurant ['Restaurant'] ['photo_dir'] ) ) > 0) :?>
                <img src="<?php echo '/files/restaurant/photo/'.$restaurant ['Restaurant'] ['id'].'/'.$restaurant ['Restaurant'] ['photo']; ?>" alt="No Image" style="max-height: 100px"/>
			<?php endif;?>
            &nbsp;
        </td>
			<td colspan="4">
            <?php echo "<span style='font-size:25px;color:#65b688;'>".h($restaurant['Restaurant']['name'])."</span>"; ?><br />
            <?php echo "<span style='color:#4fa2c2;font-weight:bold'>".h($restaurant['Restaurant']['promo_text'])."</span>"; ?><br>
            <?php echo "<span style='color:grey;font-size:12px;font-weight:bold'>".h($restaurant['Restaurant']['address'])."</span>"; ?>
            &nbsp;
        </td>


		</tr>
		<tr>
			<td colspan="1"><?php echo __('<strong>Phone</strong></'); ?></td>
			<td colspan="1"><?php echo __('<strong>Mobile</strong></'); ?></td>
			<td colspan="1"><?php echo __('<strong>Email</strong></'); ?></td>
			<td colspan="1"><?php echo __('<strong>Website</strong></'); ?></td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td colspan="1">
            <?php echo h($restaurant['Restaurant']['phone']); ?>
            &nbsp;
        </td>
			<td colspan="1">
            <?php echo h($restaurant['Restaurant']['mobile']); ?>
            &nbsp;
        </td>
			<td colspan="1">
            <?php echo h($restaurant['Restaurant']['email']); ?>
            &nbsp;
        </td>
			<td colspan="1">
            <?php echo h($restaurant['Restaurant']['website']); ?>
            &nbsp;
        </td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td><?php echo __('<strong>Country</strong>'); ?></td>
			<td><?php echo __('<strong>City</strong>'); ?></td>
			<td><?php echo __('<strong>Area</strong>'); ?></td>
			<td><?php echo __('<strong>Postal</strong>'); ?></td>
			<td><?php echo __('<strong>Lattitude</strong></'); ?></td>
			<td><?php echo __('<strong>Longitude</strong></'); ?></td>
		</tr>

		<tr>
			<td>
            <?php echo $this->Html->link($restaurant['Country']['name'], array('controller' => 'countries', 'action' => 'view', $restaurant['Country']['id'])); ?>
            &nbsp;
        </td>
			<td>
            <?php echo $this->Html->link($restaurant['City']['name'], array('controller' => 'cities', 'action' => 'view', $restaurant['City']['id'])); ?>
            &nbsp;
        </td>
			<td>
            <?php echo h($restaurant['Restaurant']['area']); ?>
            &nbsp;
        </td>
			<td>
            <?php echo h($restaurant['Restaurant']['postal']); ?>
            &nbsp;
        </td>
			<td>
            <?php echo h($restaurant['Restaurant']['lattitude']); ?>
            &nbsp;
        </td>
			<td>
            <?php echo h($restaurant['Restaurant']['longitude']); ?>
            &nbsp;
        </td>
		</tr>

		<tr>
			<td><?php echo __('<strong>Min Order</strong>'); ?></td>
			<td><?php echo __('<strong>Delivery Type</strong>'); ?></td>
			<td><?php echo __('<strong>Delivery Time</strong>'); ?></td>
			<td><?php echo __('<strong>Delivery Charge Min/Max</strong></'); ?></td>
			<td><?php echo __('<strong>Delivery Amount</strong></'); ?></td>
			<td><?php echo __('<strong>Free Delivery Amount</strong></'); ?></td>
		</tr>

		<tr>
			<td>
            <?php echo h($restaurant['Restaurant']['min_order']); ?>
            &nbsp;
        </td>
			<td>
            <?php echo h($restaurant['Restaurant']['delivery_type']); ?>
            &nbsp;
        </td>
			<td>
            <?php echo h($restaurant['Restaurant']['delivery_time']); ?>
            &nbsp;
        </td>
			<td>
            <?php echo h($restaurant['Restaurant']['delivery_charge_min']).'/'.h($restaurant['Restaurant']['delivery_charge_max']); ?>
            &nbsp;
        </td>
			<td>
            <?php echo h($restaurant['Restaurant']['delivery_amount']); ?>
            &nbsp;
        </td>
			<td>
            <?php echo h($restaurant['Restaurant']['free_delivery_amount']); ?>
            &nbsp;
        </td>
		</tr>

		<tr>
			<td colspan="2"><?php echo __('<strong>Payment Type</strong></'); ?></td>
			<td colspan="1"><?php echo __('<strong>Open Time</strong></'); ?></td>
			<td colspan="1"><?php echo __('<strong>Close Time</strong></'); ?></td>
			<td colspan="2"><?php echo __('<strong>Store Close Day</strong></'); ?></td>
		</tr>
		<tr>
			<td colspan="2">
            <?php echo h($restaurant['Restaurant']['payment_type']); ?>
            &nbsp;
        </td>
			<td colspan="1">
            <?php echo h($restaurant['Restaurant']['open_time']); ?>
            &nbsp;
        </td>
			<td colspan="1">
            <?php echo h($restaurant['Restaurant']['close_time']); ?>
            &nbsp;
        </td>
			<td colspan="2">
            <?php echo h($restaurant['Restaurant']['store_close_day']); ?>
            &nbsp;
        </td>
		</tr>

		<tr>
			<td colspan="2"><?php echo __('<strong>Discount</strong></'); ?></td>
			<td colspan="2"><?php echo __('<strong>Discount Start</strong></'); ?></td>
			<td colspan="2"><?php echo __('<strong>Discount End</strong></'); ?></td>
		</tr>

		<tr>
			<td colspan="2">
            <?php echo h($restaurant['Restaurant']['discount']); ?>
            &nbsp;
        </td>
			<td colspan="2">
            <?php echo h($restaurant['Restaurant']['discount_start']); ?>
            &nbsp;
        </td>
			<td colspan="2">
            <?php echo h($restaurant['Restaurant']['discount_end']); ?>
            &nbsp;
        </td>
		</tr>

	</table>
</div>
<div class="related">
	<h3>
        <?php echo __('Related Menus'); ?>
        <span style="float: right">
            <a data-toggle="modal" data-target="#new_menu"
               class="text-right btn btn-warning"> <span class="icon-plus"></span>&nbsp;Add
                New
            </a>
        </span>
    </h3>
	<div>
		<div class="modal" id="new_menu" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog menuAddModal">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Menu</h4>
					</div>
					<div class="modal-body" style="padding: 15px">
						<form class="form-horizontal" method="post" id="food_menu"
							action="<?php echo $this->webroot;?>restaurants/add_menu/<?php echo $restaurant['Restaurant']['id'];?>">
							<input type="hidden" name="restaurant_id"
								value="<?php echo $restaurant['Restaurant']['id'] ?>" />

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" placeholder="Name" name="data[menu][1][name]">
                                    </div>
                                </div>
								<div class="form-group">
									  <label for="description" class="col-sm-2 control-label">Description</label>
									  <div class="col-sm-9">
										  <input type="text" class="form-control" id="description" placeholder="Description" name="data[menu][1][description]">
									  </div>
								</div>
								<span id="menuAddForm"></span>

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-9">
									<button type="submit" class="btn btn-primary ">Save</button>
                                    <button type="button" class="btn btn-success pull-right menuAddForm">Add More Menu</button>
									<br/>
                                    <span style="float: right;text-decoration: underline">Or press ALT + d</span>
								</div>
							</div>

                        <?php echo $this->Form->end(); ?>
                                    
					
					</div>
				</div>
			</div>
		</div>
	</div>
    <?php if(!empty($restaurant['Menu'])): ?>

        <table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th style="width: 200px"><?php echo __('Name'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th class="actions" style="width: 80px"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
            <?php foreach($restaurant['Menu'] as $menu): ?>
                <tr>
				<td><?php echo $menu['name']; ?></td>
				<td><?php echo $menu['description']; ?></td>
				<td class="actions">
					<!--                        -->
					<?php //echo $this->Html->link('<i class="icon-eye3"></i>', array('controller' => 'menus', 'action' => 'view', $menu['id']), array('escape' => false)); ?>
<!--                        &nbsp;|&nbsp;--> <a data-toggle="modal"
					data-target="#<?php
						
						echo $menu ['id'];
						?>"> <span class="icon-pencil"></span>
				</a> &nbsp;|&nbsp;
					<div class="modal" id="<?php echo $menu['id']; ?>" tabindex="-1"
						role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"
										aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h4 class="modal-title" id="myModalLabel"><?php echo $menu['name']; ?></h4>
								</div>
								<div class="modal-body" style="padding: 15px">
									<form class="form-horizontal" method="post" id="<?php echo $menu['id']; ?>" action="<?php echo $this->webroot;?>restaurants/updateRestaurantMenuItem/<?php echo $menu['id']; ?>">

										<input type="hidden" name="restaurant_id" value="<?php echo $menu['restaurant_id'] ?>" />

										<div class="form-group">
											<label for="name" class="col-sm-2 control-label">Name</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="name" value="<?php echo $menu['name']; ?>" name="data[name]">
											</div>
										</div>
										<div class="form-group">
											<label for="description" class="col-sm-2 control-label">Description</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="description" value="<?php echo $menu['description']; ?>" name="data[description]">
											</div>
										</div>

										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-8">
												<button type="submit" class="btn btn-primary ">Update</button>
											</div>
										</div>

                                            <?php echo $this->Form->end(); ?>
								</div>
							</div>
						</div>
					</div>
                        <?php echo $this->Form->postLink('<i class="icon-cancel"></i>', array('controller' => 'restaurants', 'action' => 'deleteRestaurantMenuItem', $menu['id'],$menu['restaurant_id']), array('escape' => false), __('Are you sure you want to delete # %s?', $menu['id'])); ?>
                    </td>
			</tr>
            <?php endforeach; ?>
            </tbody>
	</table>
    <?php endif; ?>

    <!-- <div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Menu'), array('controller' => 'menus', 'action' => 'add')); ?> </li>
		</ul>
	</div>
	-->
</div>
<br>
<div class="related">
	<h3>
        <?php echo __('Related Foods'); ?>
        <span style="float: right">
            <a data-toggle="modal" data-target="#new_food" class="text-right btn btn-warning"> <span class="icon-plus"></span>&nbsp;Add
                New
            </a>
        </span>
    </h3>
	<div>
		<div class="modal" id="new_food" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog foodAddModal">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Food</h4>
					</div>
					<div class="modal-body" style="padding: 15px">
						<form class="form-horizontal" method="post" id="food_item" action="<?php echo $this->webroot;?>restaurants/add_food/<?php echo $restaurant['Restaurant']['id'];?>">

							<input type="hidden" name="restaurant_id" value="<?php echo $restaurant['Restaurant']['id'] ?>" />

							<div class="form-group">
								<label for="menu_id" class="col-sm-2 control-label">Menu</label>
								<div class="col-sm-4">
									<select class="form-control" id="menu_id" name="data[food][1][menu_id]" required="required" autofocus="autofocus">
										<span id="foodMenuOption">
											<option value="">--Select Menu--</option>
											<?php foreach($menus as $key=>$menu):?>
												<option value="<?php echo $key;?>"><?php echo $menu;?></option>
											<?php endforeach; ?>
										</span>
									</select>
								</div>
								<label for="name" class="col-sm-1 control-label">Name</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="name" name="data[food][1][name]" required>
								</div>
							</div>

							<div class="form-group">
								<label for="description" class="col-sm-2 control-label">Description</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="description" name="data[food][1][description]" >
								</div>
							</div>
							<div class="form-group">
								<label for="price" class="col-sm-2 control-label">Price</label>
								<div class="col-sm-9">
									<input type="text" class="form-control priceNumeric" id="price" name="data[food][1][price]">
								</div>
							</div>

							<!--Append food form here-->
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-9">
									<button type="submit" class="btn btn-primary" >Save</button>
									<button type="button" class="btn btn-success pull-right foodAddForm">Add More Food</button>
									<br/>
                                    <span style="float: right;text-decoration: underline">Or press ALT + d</span>
								</div>
							</div>

                            <?php echo $this->Form->end(); ?>
					
					</div>
				</div>
			</div>
		</div>
	</div>
    <?php if(!empty($foods)): ?>
        <table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th><?php echo __('Menu'); ?></th>
				<th style="width: 200px"><?php echo __('Name'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Variation'); ?></th>
				<th><?php echo __('Price'); ?></th>
				<th class="actions" style="width: 80px"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
            <?php
            $p_food = 0; 
            $p_menu = 0;
            foreach($foods as $food):
            ?>
                <tr>
                 <td><?php
                	if($p_menu !== $food[0]['menu_name']){echo $food[0]['menu_name'];}?>
				 </td>
				<td>
					<?php if($p_food != $food[0]['id']){?>
					<a data-toggle="modal" title="Add Food Variation for <?php echo $food[0]['name']; ?>"
					data-target="#variation-<?php echo $food [0] ['id'];?>"> <span class="icon-plus"></span>
				</a>&nbsp;|&nbsp;<?php echo $food[0]['name']; ?> 
					<div class="modal" id="variation-<?php echo $food [0] ['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog foodVariationAddModal">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"
										aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h4 class="modal-title" id="myModalLabel">Add Food Variation</h4>
								</div>
								<div class="modal-body" style="padding: 15px">
									<form class="form-horizontal" method="post" id="food_item_variation_<?php echo $food [0] ['id'];?>" action="<?php echo $this->webroot;?>restaurants/add_food_variation/<?php echo $restaurant['Restaurant']['id'];?>">

										<input type="hidden" name="variation[restaurant_id]" value="<?php echo $food [0] ['restaurant_id'] ?>" />

										<input type="hidden" name="variation[menu_id]" value="<?php echo $food [0] ['menu_id'] ?>" />

										<input type="hidden" name="variation[food_id]" value="<?php echo $food [0] ['id'] ?>" />

										<div class="form-group">
											<label for="variationName1" class="col-sm-3 control-label">Name</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="variationName1" name="data[foodVariation][1][name]" required autofocus="autofocus">
											</div>
										</div>

										<div class="form-group">
											<label for="variationPrice1" class="col-sm-3 control-label">Price</label>
											<div class="col-sm-8">
												<input type="text" class="form-control priceNumeric" id="variationPrice1" name="data[foodVariation][1][price]" required>
											</div>
										</div>
										<!--Append field Appear here-->
										<div class="form-group">
											<div class="col-sm-offset-3 col-sm-8">
												<button type="submit" class="btn btn-primary">Save</button>
												<button type="button" class="btn btn-success pull-right foodVariationAddForm">Add More Food Variation</button>
												<br/>
                                                <span style="float: right;text-decoration: underline">Or press ALT + d</span>
											</div>
										</div>

                                    <?php echo $this->Form->end(); ?>
                                    
								</div>
							</div>
						</div>
					</div>
					<?php
					$p_food = $food[0]['id'];
           			 }
           			 ?>
				</td>
				<td><?php echo $food[0]['description']; ?></td>
				<td><?php echo $food[0]['variation_name']; ?></td>
				<td style="width: 80px;text-align: right">£ <?php if($food[0]['price'] != 0) printf('%01.2f', $food[0]['price']) ; else "0";?></td>
				<td class="actions" style="width: 80px">
					<a data-toggle="modal"
					data-target="#food_<?php
						echo $food [0] ['id'];
						?>_variation_<?php echo $food [0] ['adf_id'];?>"> <span class="icon-pencil"></span>
				</a>
					<div class="modal" id="food_<?php
						echo $food [0] ['id'];
						?>_variation_<?php echo $food [0] ['adf_id'];?>" tabindex="-1"
						role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"
										aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h4 class="modal-title" id="myModalLabel"><?php echo $food[0]['name']; ?></h4>
								</div>
								<div class="modal-body" style="padding: 15px">
									<form class="form-horizontal" method="post" id="<?php echo $food[0]['id']."#".$food[0]['adf_id']; ?>" action="<?php echo $this->webroot;?>restaurants/updateRestaurantFoodItem/<?php echo $food[0]['id']; ?>/<?php echo $food[0]['adf_id'];?>">

										<input type="hidden" name="restaurant_id" value="<?php echo $food[0]['restaurant_id'] ?>" />

										<input type="hidden" name="menu_id" value="<?php echo $food[0]['menu_id'] ?>" />

										<div class="form-group">
											<label for="name" class="col-sm-2 control-label">Name</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="name" name="data[name]" value="<?php echo $food[0]['name'];?>" required>
											</div>
										</div>

										<div class="form-group">
											<label for="description" class="col-sm-2 control-label">Description</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="description" name="data[description]" value="<?php echo $food[0]['description']; ?>" >
											</div>
										</div>

										<?php if ($food[0]['type'] == 2): ?>
											<div class="form-group">
												<label for="variation" class="col-sm-2 control-label">Variation</label>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="variation" name="data[variation]" value="<?php echo $food[0]['variation_name']; ?>" required>
												</div>
											</div>
										<?php endif; ?>

										<div class="form-group">
											<label for="price" class="col-sm-2 control-label">Price</label>
											<div class="col-sm-9">
												<input type="text" class="form-control priceNumeric" id="price" name="data[price]" value="<?php echo $food[0]['price']; ?>" >
											</div>
										</div>

										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-8">
												<button type="submit" class="btn btn-primary">Update</button>
											</div>
										</div>

                                        <?php echo $this->Form->end(); ?>
								</div>
							</div>
						</div>
					</div>
                        &nbsp;|&nbsp;
                        <?php echo $this->Form->postLink('<i class="icon-cancel"></i>', array('controller' => 'restaurants', 'action' => 'deleteRestaurantFoodItem', $food[0]['id'],$restaurant['Restaurant']['id'],$food[0]['adf_id']), array('escape' => false), __('Are you sure you want to delete # %s?', $food[0]['id'])); ?>
                    </td>
			</tr>
            <?php 
            $p_menu = $food[0]['menu_name'];
            endforeach; ?>
            </tbody>
	</table>
    <?php endif; ?>
</div>
<br>

<!--<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>-->
<script>
    	function submitFoodForm()
    	{ 
        	if(!$("#menu_id").val())
        	{
            	alert("Please select a menu first.");
        	}
        	else if(!$("#f_name").val())
            {
        		alert("Invalid Food Name");
            }
        	else if(!$("#f_price").val()){
        		alert("Invalid Food Price");
            }
        	else
            {
        		info = [];
        		info[0] = 'Food';
        		info[1] = 0;

        		params = [];
        		params[0] = 'name';
        		params[1] = $("#f_name").val();
        		info[2] = params;
        		
				res = [];
				res[0] = 'restaurant_id';
				res[1] =  '<?php echo $restaurant['Restaurant']['id'];?>';
				info[3] = res;

				menu = [];
				menu[0] = 'menu_id';
				menu[1] = $("#menu_id").val();
				info[4] = menu;
        		
        		$.ajax({
        	        type: "post",
        	        url: '<?php echo $this->webroot;?>foods/checkDuplicateFood',
        	        dataType: "json",
        	        data: {'data':info},
        	        success: function (result) {
        	            if (result == 0) 
            	        {
        	            	$("#food_item").submit();
        	            }
        	            else
        	            {
        	            	alert("Duplicate Food Name");
        	            	$("#f_name").val("");
        	            	return false;
        	            }
        	            
        	        },
        	        error: function () {
        				alert("Error Occurred");return false;
        	        }
        	    });
            	}
        }

        function submitFoodVariationForm(food_id)
        {
           if(!$("#v_name_"+food_id).val())
            {
        		alert("Invalid Name");
            }
        	else if(!$("#v_price_"+food_id).val())
            {
        		alert("Invalid Price");
            }
        	else
            {
        		$("#food_item_variation_"+food_id).submit();
            }
        }
        
        $(".priceNumeric").keyup(function (event) {  
        	number = $(this).val().replace(/[^\d.£]/g, '');
       		$(this).val(number);        
	    });
	    $(".priceNumeric").blur(function (event) { 
	        if($(this).val() == '')
	        {
	            $(this).val('');
	        }
	        else
	        {
	        	number = $(this).val().replace(/[^\d.]/g, '');
	            number = parseFloat(number); 
	            number = number.toFixed(2);
	            $(this).val(number);
	        }         
	    });
        var index_num = 2;

        $('.menuAddForm').on('click',function(){
            $('#menuAddForm').append('<span><div class="form-group">'
            +'<label for="name" class="col-sm-2 control-label">Name</label>'
            +'<div class="col-sm-9">'
            +'<input type="text" class="form-control" id="name" placeholder="Name" name="data[menu]['+index_num+'][name]" autofocus="autofocus">'
            +'</div><div class="col-sm-1" style="padding: 5px"><button class="clearField">X</button></div>'
            +'</div>'
            +'<div class="form-group">'
            +'<label for="description" class="col-sm-2 control-label">Description</label>'
            +'<div class="col-sm-9">'
            +'<input type="text" class="form-control" id="description" placeholder="Description" name="data[menu]['+index_num+'][description]">'
            +'</div>'
            +'</div></span>');
            index_num++;
        });

        $('body').on('click','.clearField',function(){
            $(this).parent().parent().parent().remove();
        });
		var foodIndex = 2;

		var optionList = $('#foodMenuOption').html();

		$('.foodAddForm').on('click',function(){
			$(this).parent().parent().before('<span><div class="form-group">'+
			'<label for="menu_id" class="col-sm-2 control-label">Menu</label>'+
			'<div class="col-sm-4">'+
			'<select class="form-control" id="menu_id" name="data[food]['+foodIndex+'][menu_id]" required="required">'+
			'<option value="">--Select Menu--</option>'+
			'<?php foreach($menus as $key=>$menu):?>'+
			'<option value="<?php echo $key;?>"><?php echo $menu;?></option>'+
			'<?php endforeach; ?>'+
			'</select>'+
			'</div>'+
			'<label for="name" class="col-sm-1 control-label">Name</label>'+
			'<div class="col-sm-4">'+
			'<input type="text" class="form-control" id="name" name="data[food]['+foodIndex+'][name]" required>'+
			'</div><div class="col-sm-1" style="padding: 5px"><button class="clearFoodField">X</button></div>'+
			'</div>'+
			'<div class="form-group">'+
			'<label for="description" class="col-sm-2 control-label">Description</label>'+
			'<div class="col-sm-9">'+
			'<input type="text" class="form-control" id="description" name="data[food]['+foodIndex+'][description]">'+
			'</div>'+
			'</div>'+
			'<div class="form-group">'+
			'<label for="price" class="col-sm-2 control-label">Price</label>'+
			'<div class="col-sm-9">'+
			'<input type="text" class="form-control priceNumeric" id="price" name="data[food]['+foodIndex+'][price]" >'+
			'</div>'+
			'</div></span>');
			foodIndex++;
		});

		$('body').on('click','.clearFoodField',function(){
			$(this).parent().parent().parent().remove();
		});

		var foodVariationIndex = 2;
		//var foodVariationForm = $('#foodVariationField').html();

		$('.foodVariationAddForm').on('click',function(){
			$(this).parent().parent().before('<span><div class="form-group">'+
			'<label for="variationName'+foodVariationIndex+'" class="col-sm-3 control-label"> Name</label>'+
			'<div class="col-sm-8">'+
			'<input type="text" class="form-control" id="variationName'+foodVariationIndex+'" name="data[foodVariation]['+foodVariationIndex+'][name]" required>'+
			'</div><div class="col-sm-1" style="padding: 5px"><button class="clearVariationField">X</button></div>'+
			'</div>'+
			'<div class="form-group">'+
			'<label for="variationPrice'+foodVariationIndex+'" class="col-sm-3 control-label">Price</label>'+
			'<div class="col-sm-8">'+
			'<input type="text" class="form-control priceNumeric" id="variationPrice'+foodVariationIndex+'" name="data[foodVariation]['+foodVariationIndex+'][price]" required>'+
			'</div>'+
			'</div><span>');
			foodVariationIndex++;
		});

		$('body').on('click','.clearVariationField',function(){
			$(this).parent().parent().parent().remove();
		});

        $('body').on('shown.bs.modal', '.modal', function () {
            $('#name').focus();
        });
        $('body').on('shown.bs.modal', '.modal', function () {
            $('#variationName1').focus();
        });
        $('body').on('shown.bs.modal', '.modal', function () {
            $('#menu_id').focus();
        });

        $(".foodVariationAddModal").keydown(function(e) {
            if(e.altKey && e.keyCode == 68){
                e.preventDefault();
                $('.foodVariationAddForm').click();
                return false;
            }
        });

        $(".foodAddModal").keydown(function(e) {
            if(e.altKey && e.keyCode == 68){
                e.preventDefault();
                $('.foodAddForm').click();
                return false;
            }
        });

        $(".menuAddModal").keydown(function(e) {
            if(e.altKey && e.keyCode == 68){
                e.preventDefault();
                $('.menuAddForm').click();
                return false;
            }
        });

    </script>
