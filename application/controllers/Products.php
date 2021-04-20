<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
		$this->load->helper('security');
	}
	public function index(){
		$cart = $this->session->userdata('cart');
		if(!empty($cart)){
			$total_order = count($cart);
		}else{
			$total_order = 0;
		}
		$this->session->set_userdata('total_order', $total_order);

		$this->load->model('Product');
		$get_each_product = $this->Product->get_products();
		$this->load->view('products/index.php', array('get_each_product' => $get_each_product));
		$this->output->enable_profiler();
	}
	public function add_to_cart() {
		$cart = $this->session->userdata('cart');
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		
		$new_qty = $quantity + $this->session->userdata('quantity');
		$this->load->library("form_validation");
		$this->form_validation->set_rules("quantity", "Quantity", "required|greater_than[0]");
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('errors', validation_errors());
			} else {
			$cart[$product_id] = $quantity;
				if(isset($cart[$product_id])){
					$cart[$product_id] = $new_qty;
				} else {
					$cart[$product_id] = $quantity;
				}
			$this->session->set_userdata('cart', $cart);
		}
		$data = $this->security->xss_clean($data);
		redirect(base_url());
	}
	public function cart() {
		$this->load->model('Product');
		$get_each_product = $this->Product->get_products();
		$product_id_as_index = array();
		$cart = $this->session->userdata('cart');
		$product = $this->session->userdata('product');
		if(empty($cart)){
			redirect(base_url());
		}
		foreach($get_each_product as $key => $value){
			$product_id_as_index[$value['id']] = $value;
		}
		$this->load->view('products/cart.php', array('get_each_product' => $product_id_as_index));
	}
	public function delete(){
		$product_id = $this->input->post('product_id');
		if(isset($product_id)){
			$cart = $this->session->userdata('cart');
			unset($cart[$product_id]);
			$this->session->set_userdata('cart', $cart);
		}
		$this->session->set_flashdata('deleted', "Your order has been deleted");
		redirect('/products/cart');
	}
	public function order(){
		$this->load->model("Product");
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('card_no', 'Card Number', 'required');
        if($this->form_validation->run() == FALSE) {
        	$this->session->set_flashdata('client_errors', validation_errors());
        	redirect(base_url().'products/cart');
        } else {
        	//clients db
        	$client_details = array("first_name" => $this->input->post('first_name'), "last_name" => $this->input->post('last_name'), "address" => $this->input->post('address'), "card_no" => $this->input->post('card_no'));
        	$add_order = $this->Product->order_product($client_details);
        	if($add_order === TRUE || $add_order2 === TRUE) {
        		$this->session->set_flashdata('added', '<p class="added">Your order was successfully added!</p>');
        	}
        }
        $data = $this->security->xss_clean($data);
        $this->session->unset_userdata('cart');
        redirect(base_url());
	}
}
