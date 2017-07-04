<!DOCTYPE html>
<html>
	<head>
		<title>Add Shop</title>
		<script type="text/javascript" src="js/jquery_1_12.js"></script>
		<script type="text/javascript" src="js/common_scripts.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript">
		$(document).ready(function(e){
			$('.shop_add').click(function(e){
				var shop_name 	=	$('.shop_name').val();				
				var action 		=	{'action':'add_shop','shop_name':shop_name};
				var data 		=	"jsonString="+JSON.stringify(action);
				$.ajax({
						url         : 	"shop/curl_calls.php",
						data 		: 	data,
						dataType    : 	"json",
						type        : 	"POST",
						success 	: 	function(msg){
							$('.success_message').text("SUCCESS : Shop has been created with Shop Name #: "+msg['shop_name']+" , Database #: "+msg['db_name']+" and Shop ID #: "+msg['shop_id']);
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
		<form method="POST" accept="#">
			<h1 align="center">Add Shop</h1>
			<table cellpadding="5" class="shopTable" align="center" border="1" width="70%">
				<tbody>
					<tr>
						<td>Shop Name</td>
						<td> : </td>
						<td><input type="text" name="shop_name" class="shop_name" id="shop_name"></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td  align="center" colspan="3">
							<input class="shop_add" type="button" value="Add Shop">
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