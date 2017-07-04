<!DOCTYPE html>
<html>
<head>
	<title>Product List</title>
	<script type="text/javascript" src="js/jquery_1_12.js"></script>
	<script type="text/javascript" src="js/common_scripts.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript">
		$(document).ready(function(e){

				$('.productTable').children('tbody').empty();
				var shop_id =	$('.shop_id').val();
				var action 	=	{'action':'show_products','shop_id':shop_id};
				var data 	=	"jsonString="+JSON.stringify(action);
				$.ajax({
					url         : 	"shop/curl_calls.php",
					data 		: 	data,
					dataType    : 	"json",
					type        : 	"POST",
					success 	: 	function(msg){
						if(msg['success']==false){
							$('.success_message').text("FAILURE : "+msg['error']);
						}
						else if(msg['data'].length==0){
							//console.log('not found');
							$('.success_message').text("No product found in selected store !!");
						}
						else{
							$.each(msg['data'],function(index,productObject){
								var discountPer 	=	productObject['discount'];
								var salePrice 		=	productObject['price'];
								var fractionDis 	=	100 - discountPer;
								var fractionPri		=	salePrice*100;
								var actualPrice 	=	Math.round((fractionPri/fractionDis));

								var html   			= "<tr><td class='product_id'>"+productObject['id']+"</td><td>"+productObject['category']+"</td><td>"+productObject['product']+"</td><td>"+productObject['discount']+"</td><td>"+productObject['price']+"</td><td>"+actualPrice+"</td><td><input type='button' class='delete_product' value='Delete Product' /></td><td><input type='button' class='update_product_form_make' value='Update Product' /></td>";
								$('.productTable').children('tbody').append(html);
								$('.shop_name').text(msg['shop_name']);
							});
						}	
					},
					error		: 	function(){
						console.log('Error in ajax request !!');
					}
				});

				$(document).on('click','.delete_product',function(e){
					if(confirm('Sure want to delete product ?')){
						var shop_id 	=	$('.shop_id').val();
						var product_id 	=	$(this).closest("tr").find("td:eq(0)").text();
						var action 		=	{'action':'delete_product', 'shop_id' : shop_id,'product_id':product_id};
						var data 		=	"jsonString="+JSON.stringify(action);
						$.ajax({
							url         : 	"shop/curl_calls.php",
							data 		: 	data,
							dataType    : 	"json",
							type        : 	"POST",
							success 	: 	function(msg){
								if(msg['success']==false){
									$('.success_message').text("FAILURE : "+msg['error']);
								}
								else{
									alert('Product deleted with ID : #'+product_id);
									window.location.reload();
								}
							},
							error		: 	function(){
								console.log('Error in ajax request !!');
							}
					});
				}
			});

			$(document).on('click','.update_product_form_make',function(e){
				var product_id 			=	$(this).closest("tr").find("td:eq(0)").text();
				var category_name 		=	$(this).closest("tr").find("td:eq(1)").text();
				var product_name 		=	$(this).closest("tr").find("td:eq(2)").text();
				var product_discount 	=	$(this).closest("tr").find("td:eq(3)").text();
				var product_price 		=	$(this).closest("tr").find("td:eq(5)").text();

				$('.product_id_updation').val(product_id);
				$('.category_name').val(category_name);
				$('.product_name').val(product_name);
				$('.product_discount').val(product_discount);
				$('.product_price').val(product_price);
			});

			$(document).on('click','.product_update',function(e){
				var shop_id 			=	$('.shop_id').val();
				var product_id 			=	$('.product_id_updation').val();	
				var category_name 		=	$('.category_name').val();
				var product_name		=	$('.product_name').val();	
				var product_discount 	=	$('.product_discount').val();	
				var product_price		=	$('.product_price').val();
				var product_update_type	=	$('.product_update_type').val();	

				var action 				=	{'action':'update_product','shop_id':shop_id,'product_id':product_id,'category_name':category_name,'product_name':product_name,'product_discount':product_discount,'product_price':product_price,'product_update_type':product_update_type};
				var data 				=	"jsonString="+JSON.stringify(action);
				
				$.ajax({
						url         : 	"shop/curl_calls.php",
						data 		: 	data,
						dataType    : 	"json",
						type        : 	"POST",
						success 	: 	function(msg){
							if(msg['success']==false){
								$('.success_message_update').text("FAILURE : "+msg['error']);
							}
							else{
								alert('Product updated with ID : #'+product_id);
								window.location.reload();
							}
						},
						error		: 	function(){
							console.log('Error in ajax requests !!');
						}
				});
			});
		});
	</script>
</head>
<body>
	<h2 align="center">Products Table</h2>
	<p align="center">NOTE :Products available in shop <span class="shop_name"><?php echo $_GET['shop_name']; ?></span></p>
	<input type="hidden" name="shop_id" id="shop_id" class="shop_id" value="<?php echo $_GET['shop_id']; ?>">
	<table cellpadding="5" class="productTable" align="center" border="1" width="80%">
			<thead>
				<tr>
					<th>Id</th>
					<th>Category name</th>
					<th>Product Name</th>
					<th>Discount in Percentage</th>
					<th>Offered Price</th>
					<th>Original Price</th>
					<th>Delete Product</th>
					<th>Update Product</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			<tfoot>
				<tr>
					<td align="center" colspan="8">
						<p class="success_message"></p>
					</td>
				</tr>
			</tfoot>
	</table>
	<form method="POST" action="#">
		<h2 align="center">Update Product Form</h2>
		<table cellpadding="5" class="shopTable" align="center" border="1" width="70%">
				<tbody>
					<tr>
						<td>Category Name</td>
						<td> : </td>
						<td>
						<input type="hidden" name="product_id_updation" id="product_id_updation" class="product_id_updation">
						<input type="text" name="category_name" class="category_name" id="category_name"></td>
					</tr>
					<tr>
						<td>Product Name</td>
						<td> : </td>
						<td><input type="text" name="product_name" class="product_name" id="product_name"></td>
					</tr>
					<tr>
						<td>Discount Percentage(%)</td>
						<td> : </td>
						<td><input value="0" type="text" name="product_discount" class="product_discount" id="product_discount"></td>
					</tr>
					<tr>
						<td>Actual Price</td>
						<td> : </td>
						<td><input type="text" name="product_price" class="product_price" id="product_price"></td>
					</tr>
					<tr>
						<td>Update Type</td>
						<td> : </td>
						<td>
							<select name="product_update_type" id="product_update_type" class="product_update_type">
								<option value="patch">PATCH</option>
								<option value="put">PUT</option>
							</select>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td  align="center" colspan="3">
							<input class="product_update" type="button" value="Update Product">
						</td>
					</tr>
					<tr>
						<td  align="center" colspan="3">
							<p class="success_message_update"></p>
						</td>
					</tr>
				</tfoot>
		</table>
	</form>
	<p align="center"><a href="index.php">Back Show Shops</p>
</body>
</html>