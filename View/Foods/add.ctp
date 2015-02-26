<div class="row">
	<?php
	$restaurant = isset ( $restaurant ) ? $restaurant : "";
	$menu = isset ( $menu ) ? $menu : "";
	$city = isset ( $city ) ? $city : "";
	$postal = isset ( $postal ) ? $postal : "";
	?>
    <?php echo $this->Form->create('Food'); ?>
    <fieldset>
		<div class="col-md-12">
			<legend><?php echo __('Add Food'); ?></legend>
		</div>
        <?php
								
								echo $this->Form->input ( 'city', array (
										'div' => array (
												'class' => 'form-group col-md-6 ' 
										),
										'class' => 'form-control',
										'autofocus',
										'placeholder' => 'e.g. London N',
										'value' => $city 
								) );
								
								echo $this->Form->input ( 'postal', array (
										'div' => array (
												'class' => 'form-group col-md-4 ' 
										),
										'class' => 'form-control',
										'placeholder' => 'e.g. HD6 EA',
										'value' => $postal 
								) );?>

								<div class="form-group col-md-2 text-center">
								<button class="btn btn-info form-control" type="button" onclick="getRestaurantListByQuery()" style="margin-top: 22px;">Show Restaurant</button>
								</div>
								<?php
								echo $this->Form->input ( 'restaurant_id', array (
										'div' => array (
												'class' => 'form-group col-md-6' 
										),
										'onchange' => 'getMenuItemsForRestaurent(this.value)',
										'empty' => '(Choose Restaurant)',
										'class' => 'form-control',
										'value' => $restaurant,
										'required' 
								) );
								echo $this->Form->input ( 'menu_id', array (
										'value' => $menu,
										'div' => array (
												'class' => 'form-group col-md-6' 
										),
										'empty' => '(Choose Menu)',
										'class' => 'form-control',
										'required' 
								) );
								echo $this->Form->input ( 'name', array (
										'div' => array (
												'class' => 'form-group col-md-4' 
										),
										'list' => 'existing_foods',
										'type' => 'text',
										'class' => 'form-control',
										'autofocus',
										'required' 
								) );
								?>
        <datalist id="existing_foods">
            <?php foreach($foods as $val) { ?>
                <option value="<?php echo $val;?>"><?php echo $val;?></option>
            <?php } ?>
        </datalist>
        <?php
								
								echo $this->Form->input ( 'price', array (
										'div' => array (
												'class' => 'form-group price_div col-md-2' 
										),
										'type' => 'text',
										'class' => 'form-control priceNumeric' 
								) );
								echo $this->Form->input ( 'description', array (
										'div' => array (
												'class' => 'form-group col-md-6' 
										),
										'rows' => 2,
										'type' => 'textarea',
										'class' => 'form-control' 
								) );
								?>
			
        
	</fieldset>
	<fieldset>
		<legend>Add Food Variations</legend>
		<div id="food_variation"></div>
	</fieldset>
	<div class="form-group col-md-12">
		<button class="btn btn-lg btn-primary addNew" type="button"
			onclick="addFoodItem()">Add Food Variations</button>
	</div>
	<br>
	<div class="form-group col-md-12 text-center">
		<button class="btn btn-lg btn-success" type="submit">Save</button>
	</div>
	<datalist id="existing_additional_foods">
        <?php foreach($additional_foods as $val) { ?>
            <option value="<?php echo $val;?>"><?php echo $val;?></option>
        <?php } ?>
    </datalist>
</div>
<style>
.autocomplete-suggestions {
	border: 1px solid #999;
	background: #FFF;
	overflow: auto;
}

.autocomplete-suggestion {
	padding: 2px 5px;
	white-space: nowrap;
	overflow: hidden;
}

.autocomplete-selected {
	background: #F0F0F0;
}

.autocomplete-suggestions strong {
	font-weight: normal;
	color: #3399FF;
}

.autocomplete-group {
	padding: 2px 5px;
}

.autocomplete-group strong {
	display: block;
	border-bottom: 1px solid #000;
}

.wait {
	background: url("/716.GIF") no-repeat top right;
}

.focusClass {
	border-color: red;
	box-shadow: 0px 0px 1px red;
	color: red;
}

.focusClassOut {
	border-color: green;
	box-shadow: 0px 0px 1px green;
	color: green;
}
</style>
<script type="text/javascript">
	var cityId;
	var food_index = 0;
	$(function(){
		getMenuItemsForRestaurent($("#FoodRestaurantId").val());
	});
	function addFoodItem(){
		$('.addNew').prop('disabled', true);
		$(".button_remove_food").hide();
		$(".price_div").hide();
		food_index++;
		$("#button_food_remove_id_"+food_index).show();
		var food_items = '<div id="food_item_'+food_index+'" class="col-md-12"><div class="form-group col-md-4">';
		food_items+='<label for="FoodItem'+food_index+'Name">Name</label>';
		food_items+='<input id="FoodItem'+food_index+'Name" class="form-control " list="existing_additional_foods" type="text" name="data[FoodItem]['+food_index+'][name]" required onkeyup="matchingValue(this.value)">';
		food_items+='</div>';
		food_items+='<div class="form-group col-md-4">';
		food_items+='<label for="FoodItem'+food_index+'Price">Price</label>';
		food_items+='<input id="FoodItem'+food_index+'Price" class="form-control priceNumeric" type="text" name="data[FoodItem]['+food_index+'][price]" required>';
		food_items+='</div>'
		food_items+='<div class="form-group col-md-2 button_remove_food" id="button_food_remove_id_'+food_index+'" >';
		food_items+='<label for="FoodItem'+food_index+'Price">Action</label>';
		food_items+='<button id="'+food_index+'" onclick="removeFoodItem(this.id)" style="width:40px;" class="form-control " type="button"><i class="icon-remove"></button>';
		food_items+='</div></div>';
        $("#food_variation").append(food_items);
        document.getElementById('FoodItem'+food_index+'Name').focus();
        
	    $("#"+'FoodItem'+food_index+'Price').keyup(function (event) {  
        	number = $(this).val().replace(/[^\d.£]/g, '');
       		$(this).val(number);        
	    });
	    
	    $("#"+'FoodItem'+food_index+'Price').blur(function (event) { 
	        if($(this).val() == '')
	        {
	            $(this).val('');
	        }
	        else
	        {
	            number = parseFloat($(this).val()); 
	            number = number.toFixed(2);
	            $(this).val(number);
	        }         
	    });

	}

	function matchingValue(id)
	{
		if(id.length > 0)
		{
			$('.addNew').prop('disabled', false);
		}
		else
		{
			$('.addNew').prop('disabled', true);
		}
	}

	function removeFoodItem(selected_food_index){
		$('.addNew').prop('disabled', false);
		$("#food_item_"+selected_food_index).remove();
		food_index--;
		$("#button_food_remove_id_"+food_index).show();
		if(food_index < 1){$(".price_div").show();}
		}
	function getMenuItemsForRestaurent(restaurent_id){
		 $.ajax({
             type: "post",
             url: '<?php echo $this->webroot;?>foods/getMenuItems',
             dataType: "json",
             data: {
                 restaurent_id: restaurent_id,
             },
             success: function (result) {
                 if (result != 0) {
                     $("#FoodMenuId").empty();
                     var options = "<option value='0'> --Select Menu-- </option>";
                    $.each(result, function(i,v){
                        options+="<option value='"+v.id+"'>"+v.name+"</option>";
                        })
                    $("#FoodMenuId").append(options);
                    $("#FoodMenuId").val('<?php echo $menu;?>')
                 }
                 else{
                	 $("#FoodMenuId").empty();
                     var options = "<option value='0'> --Select Menu-- </option>";
                     $("#FoodMenuId").append(options);
                     }
             },
             error: function () {

             }
         });
		}

		/**
		 * search by city
		 */

		$('#FoodCity').autocomplete({
	    serviceUrl: '<?php echo $this->webroot;?>restaurants/getCityListAutoComplete',
	    minChars:3,
	    onSearchStart: function (query) {$(this).addClass("wait");},
	    onSearchComplete: function (query, suggestions) {$(this).removeClass("wait");},
	    onSelect:function(suggestion){
	    	cityId = suggestion["data"];
	    	$('#FoodCity').removeClass('focusClass');
	    },
		});

		

		

		/**
		 * Search by Postcode
		 */

		$('#FoodPostal').autocomplete({
	    serviceUrl: '<?php echo $this->webroot;?>restaurants/getPostCodeListAutoComplete',
	    minChars:3,
	    onSearchStart: function (query) {$(this).addClass("wait");},
	    onSearchComplete: function (query, suggestions) {$(this).removeClass("wait");},
	    onSelect:function(suggestion){
    	$('#FoodPostal').removeClass('focusClass');
    	},
		});

		

		/**
		 * Additional item
		 */
		
		function getRestaurantListByQuery(){
			var postal = $("#FoodPostal").val();
			var city = $("#FoodCity").val();

            if(city == '') {cityId = '';}

			$.ajax({
		        type: "post",
		        url: '<?php echo $this->webroot;?>menus/getRestaurantListByQuery',
		        dataType: "json",
		        data: {
		            postal: postal,
		            city:   cityId
		        },
		        success: function (result) {
		            if (result == 0) {
                        alert("Sorry No Restaurant Found.");
		            	clearDropDownList("FoodRestaurantId", "---- Restaurant Unavailable ----");
		            }
		            else
		            {
                        alert("Restaurant Available");
		            	makeDropDownList("FoodRestaurantId", result, "--Available Restaurant--");
		            }
		        },
		        error: function () {

		        }
		    });

		}
		
		function makeDropDownList(table_id, drop_down_data, no_option_text){
			$("#"+table_id).empty();
			var options = "<option value=''>"+no_option_text+"</option>";
		    $.each(drop_down_data, function(i,v){
		        options+="<option value='"+v.id+"'>"+v.name+"</option>";
		        })
		    $("#"+table_id).append(options);
		}

		function clearDropDownList(table_id,no_option_text){
			$("#"+table_id).empty();
			var options = "<option value=''>"+no_option_text+"</option>";
		    $("#"+table_id).append(options);
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
	            number = parseFloat($(this).val()); 
	            number = number.toFixed(2);
	            $(this).val(number);
	        }         
	    });

		function checkDuplicateFoodName()
		{
			$('.addNew').prop('disabled', true);
			
			$('.saveButton').prop('disabled', true);

			var resId = $("#MenuRestaurantId").val();
			var menuId = $("#MenuRestaurantId").val();
			
			info = [];
			info[0] = 'Menu';
			info[1] = 0;
			params = [];
			params[0] = 'name';
			params[1] = c_name;
			info[2] = params;

			p1 = [];
			p1[0] = 'restaurant_id';
			p1[1] = resId;
			info[3] = p1;
			
			$.ajax({
		        type: "post",
		        url: '<?php echo $this->webroot;?>menus/checkDuplicateMenu',
		        dataType: "json",
		        data: {'data':info},
		        success: function (result) {
		            if (result == 0) {
		            	addMenuItem();
		            }
		            else
		            {
		            	alert("Duplicate Menu");
		            	$("#MenuItem"+Menu_index+"Name").val("");
		            	$('.addNew').prop('disabled', true);
		            	$('.saveButton').prop('disabled', true);
		            }
		        },
		        error: function () {
					alert("Error Occurred");
					$('.addNew').prop('disabled', true);
					$('.saveButton').prop('disabled', true);
		        }
		    });
		}

		window.onload = function(){
			$('.language').css('display','none');
		}
		
</script>

