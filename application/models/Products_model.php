<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
    }
    
    //========================================================
    // 	OBTENER Productos
    //========================================================
    function get_products(){
        
      $this->db->select('P.id_producto, P.nombre_producto, P.descripcion_producto, P.precio_producto,P.fecha_registro_producto,P.fecha_actualizacion_producto');
      $this->db->from('products P');
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
/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */