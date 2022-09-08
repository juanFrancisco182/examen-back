<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}
	
	
	//========================================
	// Obtiene el id del uid enviado 
	//======================================== 
	public function get_id( $uid, $table ){
		/*$this->db->select( 'id' );
		$this->db->where( 'uid' , $uid );
		return $this->db->get( $table );*/

		$sql = "SELECT id 
		FROM ". $table ."
		WHERE uid = ?";

		return $this->db->query($sql,array($uid));
		
	}
	
	//==========================================================
	// INSERTA UN REGISTRO EN UNA TABLE
	//==========================================================
	public function insert( $table , $data ,$database=null){
        $success = $this->db->insert( $table , $data );
		if( $success ){
			$result = array(
				'success' => TRUE,
				'msg' => 'Registro insertado correctamente',
				'id' => $this->db->insert_id()	
			);
		}else{
			$result = array(
				'success' =>FALSE ,
				'msg' => 'Error al insertar ',
				'error'=> $this->db->_error_message(),
				'error_num' => $this->db->_error_number() 
			);
		}
		return $result;
    }
    
    //==========================================================
    // INSERTAR REGISTROS MASIVAMENTE
    //==========================================================
    public function multi_insert( $table , $data ){
        $success = $this->db->insert_batch( $table , $data );
		if( $success ){
			$result = array(
				'success' => TRUE,
				'msg' => 'Registros insertados correctamente',
			);
		}else{
			$result = array(
				'success' =>FALSE ,
				'msg' => 'Error al insertar ',
				'error'=> $this->db->_error_message(),
				'error_num' => $this->db->_error_number() 
			);
		}
		return $result;
    }

	//========================================
	// Actualiza registros segun la tabla 
	//========================================
	public function update( $table , $data , $id ,$fieldName){
        $this->db->where($fieldName, $id );
		$this->db->update( $table , $data );
		if( $this->db->affected_rows() > 0 ){
			$result = array(
				'success' => TRUE,
				'msg' => 'Registro actualizado correctamente'
			);
		}else{
			$result = array(
				'success' => FALSE,
				'msg' => 'No se actualizo el registro'
			);
		}
		return $result;
	}

	//========================================
	// Elimina un registros segun la tabla 
	//========================================
	public function delete_record( $table , $rules ){
		$this->db->delete($table, $rules); 
		if( $this->db->affected_rows() > 0 ){
			$result = array(
				'success' => TRUE,
				'msg' => 'Registro Eliminado correctamente'
			);
		}else{
			$result = array(
				'success' => FALSE,
				'msg' => 'El registro no se elimino'
			);
		}
		return $result;
	}
   
	//========================================
	// Cecar si existe un registro
	//========================================
	public function check_row( $table , $data, $field, $database  ){
		if($database != null){
			$db2 = $this->load->database( $database, TRUE);
			$sql = "SELECT * FROM  ".$table. " WHERE  ".$field." = '" .$data."'";
			$query = $db2->query($sql);
	
		}else{
			$sql = "SELECT * FROM  ".$table. " WHERE  ".$field." = '" .$data."'";
			$query = $this->db->query($sql);
		}
		if( $query->num_rows() > 0 ){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// ============================================
	// TRUNCATE TABLE
	// ============================================
	function deletedTable($table){
		$SQL = 'truncate  '.$table.'  ';
		$query = $this->db->query($SQL);
		return TRUE;
	}

}

/* End of file Common_model.php */
/* Location: ./application/models/Common_model.php */
