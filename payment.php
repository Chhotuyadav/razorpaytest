<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH. 'views/razorpay/Razorpay.php';
use Razorpay\Api\Api;
class Razorpay extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->model('Razorpay_Model');
	}

	public function checkout(){

		
		$key_id = 'rzp_test_goZcGbAmt0YcmK';
		$secret = '76Y58tUTHh9GmwESOYv4FpS5';
		$price = $this->input->post('price');

		$api = new Api($key_id,$secret);
		$orderData = [
		    'receipt'         => 'rcptid_11',
		    'amount'          => $price*100, // 39900 rupees in paise
		    'currency'        => 'INR'
		];

		$razorpayOrder = $api->order->create($orderData);

		$customerid = 1;

		$this->load->view('razorpay-checkout',['order'=>$razorpayOrder,'key_id'=>$key_id,'secret'=>$secret]);

	}

	public function paymentstatus(){
		
		$razorpay_payment_id = $this->input->post('razorpay_payment_id');
		
		$razorpay_order_id = $this->input->post('razorpay_order_id');
		
		$razorpay_signature = $this->input->post('razorpay_signature');
		$data = $razorpay_order_id . "|" . $razorpay_payment_id;
		$secret = '76Y58tUTHh9GmwESOYv4FpS5';
		$generated_signature = hash_hmac("sha256",$data, $secret);

		  if ($generated_signature == $razorpay_signature) {
		    echo 'payment is successful';
		  }
	}

}
