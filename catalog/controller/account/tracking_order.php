<?php
class ControllerAccountTrackingOrder extends Controller {
	private $error = array();
	
	public function index() {

	if ($this->customer->isLogged()) {
		$this->redirect($this->url->link('account/account', '', 'SSL'));
	}

	$this->language->load('account/tracking_order');
		
	$this->document->setTitle($this->language->get('heading_title'));
		
	$this->load->model('account/tracking_order');
		
	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
		$result = $this->model_account_tracking_order->getResi($this->request->post);

		foreach($result as $result) {
			$result['shipping_receipt'];
		}

		$this->data['tracking'] = $result['shipping_receipt'];

		$url = 'http://202.159.35.122:22230/jandt_track/trackToJson.action';
		$billcode   = $result['shipping_receipt'];
		$keyAPI  = md5(date('Ymd').'YnTrackQuery'.$billcode);

		$data = array(
  		'billcode'  => $billcode,
  		'lang'      => 'id',
    	'pictype'   => 'sj,yn,lc,qs',
    	'sign'      => $keyAPI,
		);
 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($ch);

		//echo'<pre>';print_r($response);echo'</pre>';

		//echo'<pre>';
		$array_data = json_decode($response); 
		//$array_data = var_dump($array_data);
		$array_data = json_decode($response);

		//$this->data['tes2'] = $array_data->result->traces->billcode;
		$this->data['tracking_result'] = $array_data->result->traces->details;
							
		//$this->redirect($this->url->link('account/tracking_order'));
	}

	$this->data['breadcrumbs'] = array();
	$this->data['breadcrumbs'][] = array(
	'text'      => $this->language->get('text_home'),
	'href'      => $this->url->link('common/home'),
	'separator' => false
	);

	$this->data['breadcrumbs'][] = array(
	'text'      => $this->language->get('text_account'),
	'href'      => $this->url->link('account/account', '', 'SSL'),
	'separator' => $this->language->get('text_separator')
	);
		
	$this->data['breadcrumbs'][] = array(
	'text'      => $this->language->get('text_register'),
	'href'      => $this->url->link('account/register', '', 'SSL'),
	'separator' => $this->language->get('text_separator')
	);
		
	$this->data['heading_title'] = $this->language->get('heading_title');	
	$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', 'SSL'));
	$this->data['text_details'] = $this->language->get('text_details');
	$this->data['text_description'] = $this->language->get('text_description');
	$this->data['entry_order_id'] = $this->language->get('entry_order_id');
	$this->data['button_continue'] = $this->language->get('button_continue');

	if (isset($this->error['warning'])) {
		$this->data['error_warning'] = $this->error['warning'];
	} else {
		$this->data['error_warning'] = '';
	}

	if (isset($this->error['order_id'])) {
		$this->data['error_order_id'] = $this->error['order_id'];
	} else {
		$this->data['error_order_id'] = '';
	}
		
	$this->data['action'] = $this->url->link('account/tracking_order', '', 'SSL');

	if (isset($this->request->post['order_id'])) {
	$this->data['order_id'] = $this->request->post['order_id'];
	} else {
		$this->data['order_id'] = '';
	}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/tracking_order.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/tracking_order.tpl';
		} else {
			$this->template = 'default/template/account/tracking_order.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
				
		$this->response->setOutput($this->render());
	}

	private function validate() {

		if (empty($this->request->post['order_id'])){
			$this->error['order_id'] = $this->language->get('error_order_id');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>