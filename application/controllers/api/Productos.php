<?php 
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Productos extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->functions->cors();
    $this->load->model('Products_model');
    date_default_timezone_set('America/Monterrey');
	}

	// ======================================
	// GET ALL PRODUCTS
	// ======================================
	public function index_get(){
      $data = $this->Products_model->get_products();
      if(!$data['success']){
        $this->response($data,REST_Controller::HTTP_BAD_REQUEST); 
      }
      $this->response($data,REST_Controller::HTTP_OK); 
    }

  // ============================================
  // CREATE PRODUCT 
  // ============================================
  public function index_post(){
    $params = $this->post();// GET PARAMS
    $validation = $this->functions->validate_data( $params , 'create_product'); // Validación de datos recibidos del post
    
    if( $validation['err'] ) { $this->response( $validation , REST_Controller::HTTP_BAD_REQUEST ); }

    if( $this->functions->exist_row('products',$params['nombre_producto'],'nombre_producto')){ // verifica si el nombre del producto ya existe en la base de datos
      $this->response($this->functions->format_response(FALSE,'Ya existe un producto con el nombre '.$params['nombre_producto'].''), REST_Controller::HTTP_BAD_REQUEST); 
    }
    $params['fecha_registro_producto'] = date('Y/m/d');
    $inserted =  $this->functions->create_record('products',$params); //inserta un nuevo registro

    if(!$inserted['success']){ $this->response($inserted, REST_Controller::HTTP_BAD_REQUEST); } // Verifica que se inserto correctamente
   
    $this->response($inserted, REST_Controller::HTTP_OK); 
  }

  //==========================================================
  // UPDATE PRODUCT
	//==========================================================
  public function index_put(){
    $params = $this->put();// GET PARAMS
    $id = $this->uri->segment(3);

    $validation = $this->functions->validate_data( $params , 'create_product'); // Valida que la información del formulario este correcta
    if( !$this->functions->exist_row('products',$id,'id_producto')){ // verifica si el existe un producto con el id recibido  
      $this->response($this->functions->format_response(FALSE,' El producto con ID '.$id.' no existe'), REST_Controller::HTTP_BAD_REQUEST); 
    }
    $data = $this->Products_model->get_productById($id);
    if($data->nombre_producto !=$params['nombre_producto']){
      if( $this->functions->exist_row('products',$params['nombre_producto'],'nombre_producto')){ // verifica si el nombre del producto ya existe en la base de datos
        $this->response($this->functions->format_response(FALSE,'Ya existe un producto con el nombre '.$params['nombre_producto'].''), REST_Controller::HTTP_BAD_REQUEST); 
      }
    }
   

    if( $validation['err'] ) { $this->response( $validation , REST_Controller::HTTP_BAD_REQUEST ); }

    $params['fecha_actualizacion_producto'] = date('Y/m/d H:i:s');
    $this->functions->update_record( 'products' , $params , $id ,'id_producto');
    $this->response($this->functions->format_response(TRUE,'Datos Actualizados'), REST_Controller::HTTP_OK); 
}

  // ============================================
  // 
  // ============================================
  public function index_delete(){
    $id = $this->uri->segment(3);

    if( !$this->functions->exist_row('products',$id,'id_producto')){ // verifica si el existe un producto con el id recibido  
      $this->response($this->functions->format_response(FALSE,' El producto con ID '.$id.' no existe'), REST_Controller::HTTP_BAD_REQUEST); 
    }

    $deleted  = $this->functions->delete_record( 'products' , array('id_producto'=> $id) );

    if(!$deleted['success']){
      $this->response($this->functions->format_response(FALSE,' El producto con ID '.$id.' no se elimino'), REST_Controller::HTTP_BAD_REQUEST); 
    }

    $this->response($this->functions->format_response(TRUE,'Se elimino el producto con ID '.$id.' Correctamente',), REST_Controller::HTTP_OK); 
  }
}
/* End of file Users.php */
/* Location: ./application/controllers/Products.php */
