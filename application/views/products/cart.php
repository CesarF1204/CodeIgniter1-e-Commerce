<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../user_guide/_css/style.css">
	<title>Cart</title>
	<link rel="stylesheet" href="/user_guide/css/cart_style.css">
</head>
<body>
	<div class="container">
		<?= "<p class='deleted'>".$this->session->flashdata('deleted')."</p>" ?>
		<h1>Products</h1>
        <table border="1">
			<thead>
				<tr>
					<td>Quantity</td>
					<td>Description</td>
					<td>Price</td>
					<td></td>
				</tr>
			</thead>
			<tbody>			
<?php			$total=0;
            foreach($this->session->userdata('cart') as $id => $qty){
            	$total += $qty*$get_each_product[$id]['price'];
?>
				<tr>
					<form action="/products/delete" method="post">
						<input type="hidden" name="product_id" value="<?= $id ?>">
						<td><?= $qty ?></td>
						<td><?= $get_each_product[$id]['description'] ?></td>
						<td><?= $get_each_product[$id]['price'] * $qty ?></td>
						<td><input class="delete-item" type="submit" value="Delete"></td>
					</form>
				</tr>
<?php   		} ?>                                      
			</tbody>
		</table>
		 <h3>Total: <?= $total ?></h3>
		 <br>
<?= "<span>".$this->session->flashdata('client_errors')."</span>" ?>
        <h1>Billing Info: </h1>
        <form action="/products/order" method="post">
            <label for="first_name">First Name: </label>
            <input type="text" name="first_name" id="first_name">

            <label for="last_name">Last Name: </label>
            <input type="text" name="last_name" id="last_name">

            <label for="address">Address: </label>
            <input type="text" name="address" id="address">

            <label for="card_no">Card Number: </label>
            <input type="text" name="card_no" id="card_no">

            <input class='order-item' type="submit" value="Order">
        </form>
		<a href="<?= base_url() ?>">Go Back</a>
	</div>
</body>
</html>