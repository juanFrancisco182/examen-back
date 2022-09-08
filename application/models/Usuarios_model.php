<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
    }
    
    //========================================================
    // 	OBTENER USUARIOS 
    //========================================================
    function get_usuarios(){
        
      $this->db->select('U.id, U.email, U.first_name, U.last_name,U.avatar');
      $this->db->from('usuarios U');
      $query = $this->db->get();
      if($query->num_rows() > 0 ){
          $result = array(
              'success' => TRUE,
              'msg' => 'Datos encontrados',
              'data' => $query->result()
          );
      }else{
          $result = array(
              'success' => FALSE,
              'msg' => 'No hay datos'
          );
      }
      return $result;
    }

   
  }