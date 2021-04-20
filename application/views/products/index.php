<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Product Listing</title>
	<link rel="stylesheet" href="user_guide/css/style.css">
</head>
<body>
<div class="container">
<?php	if($this->session->flashdata('errors')) {
			echo "<span>".$this->session->flashdata('errors')."</span>";
		} else if($this->session->flashdata('added')) {
			echo $this->session->flashdata('added');
		} ?>
	<h1>Products</h1>
	<a href="/products/cart">Your Cart(<?= $this->session->userdata('total_order') ?>)</a>
	<table>
		<thead>
			<tr>
				<th>Description</th>
				<th>Price</th>
				<th>Quantity</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php	foreach($get_each_product as $product) { ?>
			<tr>
			<form action="/products/add_to_cart" method='POST'>
				<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
				<input type="hidden" name="product_id" value="<?= $product['id'] ?>">
				<td> <?= $product['description'] ?></td>
				<td> <?= $product['price'] ?> </td>
				<td> <input type="number" name="quantity" min="1" max="<?= $product['quantity'] ?>"> </td>
				<td><input type="submit" value="Buy"></td>
			</form>	
			</tr>
<?php } ?>
		</tbody>
	</table>
</div>
</body>
</html>