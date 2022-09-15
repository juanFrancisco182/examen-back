<?php 
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Usuarios extends REST_Controller {
CONST APIURL = 'https://reqres.in/api';
	public function __construct()
	{
		parent::__construct();
		$this->functions->cors();
    $this->load->model('Usuarios_model');
	}

  // ======================================
	// Obtener Usuarios
	// ======================================
	public function index_get(){
    $data = $this->Usuarios_model->get_usuarios();
    if(!$data['success']){
      $this->response($data,REST_Controller::HTTP_BAD_REQUEST); 
    }
    $this->response($data,REST_Controller::HTTP_OK); 
  }


	// ======================================
	// Importar Usuarios
	// ======================================
	public function importUsers_get(){
    try{
      $usersTemp = array();
      $currentpage = 1;
      $lastPage =1;
      while($currentpage == $lastPage ){
        $users = $this->functions->curl_get('https://reqres.in/api/users?page='.$currentpage.'');

        foreach($users->data as $user ){
          if( !$this->functions->exist_row('usuarios',$user->id,'id')){ // verifica si el nombre del producto ya existe en la base de datos
           array_push($usersTemp , $user);
          }
        }
        $currentpage ++;
        $lastPage = $users->total_pages;
      }
    
      if(count($usersTemp) > 0){
      $result =   $this->functions->create_multi_records('usuarios',$usersTemp);
      $this->response($result,REST_Controller::HTTP_OK); 
      }else{
        $this->response($this->functions->format_response(FALSE,'No hay Usuarios para registrar'), REST_Controller::HTTP_BAD_REQUEST); 
      }
    }catch(e){
      $this->response($this->functions->format_response(FALSE,' Por el momento el servicio no esta disponible'), REST_Controller::HTTP_BAD_REQUEST); 
    }
  }


  // ============================================
  // CREAR USUARIO
  // ============================================
  public function index_post(){
    $params  = $this->post(); 
    $validation = $this->functions->validate_data( $params , 'create_user'); // Validación de datos recibidos del post
    if( $validation['err'] ) { $this->response( $validation , REST_Controller::HTTP_BAD_REQUEST ); }
    
    $apiResult = $this->functions->curl_post('https://reqres.in/api/users',$params);
    if($apiResult->id){
      $data = array(
        'email' => $params['email'],
        'first_name' => $params['name'],
        'last_name' => $params['last_name'],
        'job' => $params['job'],
        'id' => $apiResult->id,
      );
      $inserted =  $this->functions->create_record('usuarios',$data); //inserta un nuevo registro

      if(!$inserted['success']){ $this->response($inserted, REST_Controller::HTTP_BAD_REQUEST); } // Verifica que se inserto correctamente
     
      $this->response($inserted, REST_Controller::HTTP_OK); 
    }else{
      $this->response($this->functions->format_response(FALSE,'No se registro el usuario'), REST_Controller::HTTP_BAD_REQUEST); 
    }
 
   
  }

  // ============================================
  // ACTUALIZAR USUARIO
  // ============================================
  public function index_put(){
    $params = $this->put();// GET PARAMS
    $id = $this->uri->segment(3);
    if( !$this->functions->exist_row('usuarios',$id,'id')){ // verifica si el existe un usuario con el id recibido  
      $this->response($this->functions->format_response(FALSE,'El usuario con el ID '.$id.' no existe'), REST_Controller::HTTP_BAD_REQUEST); 
    }
    $validation = $this->functions->validate_data( $params , 'create_user'); // Validación de datos recibidos del post
    if( $validation['err'] ) { $this->response( $validation , REST_Controller::HTTP_BAD_REQUEST ); }
    
    $apiResult = $this->functions->curl_put('https://reqres.in/api/users/'.$id.'',$params); 
    if($apiResult->updatedAt){
      $data = array(
        'email' => $params['email'],
        'first_name' => $params['name'],
        'job' => $params['job'],
        'last_name' => $params['last_name'],
      );
      $updated = $this->functions->update_record( 'usuarios' , $data , $id ,'id');
      if(!$updated['success']){ $this->response($updated, REST_Controller::HTTP_BAD_REQUEST); } // Verifica que se inserto correctamente
     
      $this->response($updated, REST_Controller::HTTP_OK); 
    }else{
      $this->response($this->functions->format_response(FALSE,'No se Actualizo el usuario'), REST_Controller::HTTP_BAD_REQUEST); 
    }
 
   
  }
 
 

 

}
/* End of file Users.php */
/* Location: ./application/controllers/Usuarios.php */
