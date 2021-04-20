<?php
	class Product extends CI_Model {
		public function get_products() {
			$query = "SELECT * FROM products";
			return $this->db->query($query)->result_array();
		}
		public function order_product($client) {
	    	$query = "INSERT INTO clients (first_name, last_name, address, card_no, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
	    	$values = array($client['first_name'], $client['last_name'], $client['address'], $client['card_no']);
	    	return $this->db->query($query, $values);
    	}
	}

?>