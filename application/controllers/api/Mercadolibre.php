<?php 
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mercadolibre extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->functions->cors();
    $this->load->model('Products_model');
    date_default_timezone_set('America/Monterrey');
	}

	// ======================================
	// GET ALL PRODUCTS MERADO LIBRE
	// ======================================
	public function index_get(){
    try{
      $products = $this->functions->curl_get('https://api.mercadolibre.com/items/MLM1332597552?include_attributes=all');
      $data = array(
        'success'=> TRUE,
        'data' => $products
      );
      $this->response($data,REST_Controller::HTTP_OK); 
    }catch(e){
      $this->response($this->functions->format_response(FALSE,' Por el momento el servicio no esta disponible'), REST_Controller::HTTP_BAD_REQUEST); 
    }
  }

}
/* End of file Users.php */
/* Location: ./application/controllers/Mercadolibre.php */
