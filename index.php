<!DOCTYPE html>
<html>
<head>
	<title>Shop List</title>
	<script type="text/javascript" src="js/jquery_1_12.js"></script>
	<script type="text/javascript" src="js/common_scripts.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript">
		$(document).ready(function(e){

			var action 	=	{'action':'show_shops'};
			var data 	=	"jsonString="+JSON.stringify(action);
			$.ajax({
				url         : 	"shop/curl_calls.php",
				data 		: 	data,
				dataType    : 	"json",
				type        : 	"POST",
				success 	: 	function(msg){
					$.each(msg['data'],function(index,shopObject){
						var html   = "<tr><td class='shop_id'>"+shopObject['id']+"</td><td>"+shopObject['shop_name']+"</td><td>"+shopObject['db_name']+"</td><td><a href='show_products.php?shop_id="+shopObject['id']+"&shop_name="+shopObject['shop_name']+"'>Show Products</a></td><td><a href='add_product.php?shop_id="+shopObject['id']+"&shop_name="+shopObject['shop_name']+"'>Add Product</a></td>";
						$('.shopTable').children('tbody').append(html);
					});
				},
				error		: 	function(){
					console.log('Error in ajax requests !!');
				}
			});

			$(document).on('click','.show_products',function(e){
				$('.productTable').children('tbody').empty();
				var shop_id =	$(this).closest("tr").find("td:eq(0)").text();
				var action 	=	{'action':'show_products','shop_id':shop_id};
				var data 	=	"jsonString="+JSON.stringify(action);
				$.ajax({
					url         : 	"shop/curl_calls.php",
					data 		: 	data,
					dataType    : 	"json",
					type        : 	"POST",
					success 	: 	function(msg){
						$.each(msg['data'],function(index,productObject){

							var discountPer 	=	productObject['discount'];
							var salePrice 		=	productObject['price'];
							var fractionDis 	=	100 - discountPer;
							var fractionPri		=	salePrice*100;
							var actualPrice 	=	Math.round((fractionPri/fractionDis));

							var html   			= "<tr><td class='product_id'>"+productObject['id']+"</td><td>"+productObject['category']+"</td><td>"+productObject['product']+"</td><td>"+productObject['discount']+"</td><td>"+productObject['price']+"</td><td>"+actualPrice+"</td>";
							$('.productTable').children('tbody').append(html);
							$('.shop_name').text(msg['shop_name']);

						});	
					},
					error		: 	function(){
						console.log('Error in ajax request !!');
					}
				});

			});
		});
	</script>
</head>
<body>
	<h1 align="center">Shops Table</h1>
	<table cellpadding="5" class="shopTable" align="center" border="1" width="50%">
			<thead>
				<tr>
					<th>Shop ID</th>
					<th>Shop Name</th>
					<th>Database</th>
					<th>Show Products</th>
					<th>Add Product</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5"><a href="add_shop.php">Add New Shop</a></td>
				</tr>
			</tfoot>
	</table>
</body>
</html>