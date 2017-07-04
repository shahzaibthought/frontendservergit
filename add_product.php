<!DOCTYPE html>
<html>
	<head>
		<title>Add Product</title>
		<script type="text/javascript" src="js/jquery_1_12.js"></script>
		<script type="text/javascript" src="js/common_scripts.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript">
		$(document).ready(function(e){
			$('.product_add').click(function(e){
				
				var shop_id 			=	$('.shop_id').val();	
				var category_name 		=	$('.category_name').val();
				var product_name		=	$('.product_name').val();	
				var product_discount 	=	$('.product_discount').val();	
				var product_price		=	$('.product_price').val();	

				var action 				=	{'action':'add_product','shop_id':shop_id,'category_name':category_name,'product_name':product_name,'product_discount':product_discount,'product_price':product_price};
				var data 				=	"jsonString="+JSON.stringify(action);
				
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
								$('.success_message').text("SUCCESS : Product has been created with Product ID : #"+msg['product_id']);
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
		<h1 align="center">Add Product</h1>
		<p align="center">NOTE : Adding product in shop <span class="shop_name"><?php echo $_GET['shop_name']; ?></span></p>
		<form method="POST" accept="#">
			<table cellpadding="5" class="shopTable" align="center" border="1" width="70%">
				<input type="hidden" name="shop_id" class="shop_id" id="shop_id" value="<?php echo $_GET['shop_id']; ?>">
				<tbody>
					<tr>
						<td>Category Name</td>
						<td> : </td>
						<td><input type="text" name="category_name" class="category_name" id="category_name"></td>
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
				</tbody>
				<tfoot>
					<tr>
						<td  align="center" colspan="3">
							<input class="product_add" type="button" value="Add Product">
						</td>
					</tr>
					<tr>
						<td  align="center" colspan="3">
							<p class="success_message"></p>
						</td>
					</tr>
				</tfoot>
			</table>
			<p align="center"><a href="index.php">Back Show Shops</p>
		</form>
	</body>
</html>