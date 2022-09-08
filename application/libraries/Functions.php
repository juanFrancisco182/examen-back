<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Functions{

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('Common_model');
	}
	


	//==========================================================
    // 	PERMITE HACER PETICIONES DESDE UN ORIGEN PREDETERMINADO
    //==========================================================
	public function cors(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Authorization");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Allow: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
	}

	// ============================================
	// FORMAT GENERAL RESPONSE
	// ============================================
	public function format_response($success,$message,$data = null){
		if($data == null){
			return array(
				'success'  	=> 	$success,
				'msg' 	=>	$message
			);
		}else{
			return array(
				'success'  	=> 	$success,
				'msg' 	=>	$message,
				'data'	  	=> 	$data
			);
		}
	}


	//==========================================================
	// 	FUNCIÓN PARA VER SI EXISTE UN REGISTRO 
	//==========================================================
	function exist_row( $table , $data , $field , $database = null ) {
			return  $this->CI->Common_model->check_row( $table , $data, $field, $database );
  }
    
	//==========================================================
	// 	FUNCIÓN PARA CREAR UN NUEVO REGISTRO
	//==========================================================
	function create_record ( $table , $data, $database = null ){
			return  $this->CI->Common_model->insert( $table , $data , $database  );
   }

	//==========================================================
	// 	FUNCIÓN PARA CREAR MULTIPLES REGISTROS
	//==========================================================
	function create_multi_records( $table , $data ){
			return  $this->CI->Common_model->multi_insert( $table , $data  );
  }
    
    //==========================================================
    // 	FUNCIÓN PARA EDITAR UN REGISTRO
    //==========================================================
	function update_record ( $table , $data , $id , $fieldName){
		return $this->CI->Common_model->update( $table , $data , $id ,$fieldName );
	}
	
	// ===================================================
	// Función para Eliminar permanentemente un registro
	// ===================================================
	function delete_record ( $table , $rules ){
		$dbResult = $this->CI->Common_model->delete_record( $table , $rules );
		return $dbResult;
	}

	//========================================================
	// 	OBTENER IMAGEN ACTUAL de cualquier tabla por id
	//========================================================
	function get_image($table ,$model_id, $field_name){
		$dbResult =$this->CI->Common_model->get_image( $table ,$model_id, $field_name );
		return $dbResult;
	}

    //==========================================================
    // 	VALIDA LOS DATOS DE LOS FORMULARIOS
    //==========================================================
	function validate_data( $data , $form ){
		$this->CI->load->library('form_validation');
		$this->CI->form_validation->set_data( $data );
		if( $this->CI->form_validation->run( $form ) )  { return array( 'err' => FALSE );  }
		return array(
			'err' => TRUE,
			'message' => 'Hay errores en el envio de información',
			'errors' =>$this->CI->form_validation->get_errores_arreglo(),
		);
	}
    
    //==========================================================
    // 	LIMPIA EL NOMBRE DE CARACTERES ESPECIALES Y ESPACIOS
    //==========================================================
	public  function normalize_string ( $str = '' ){
		$str = strip_tags( $str ); 
		$str = preg_replace('/[\r\n\t ]+/', ' ', $str );
		$str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str) ;
		$str = strtolower( $str );
		$str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
		$str = htmlentities( $str, ENT_QUOTES, "utf-8");
		$str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str );
		$str = str_replace(' ', '_', $str );
		$str = rawurlencode( $str );
		$str = str_replace('%', '_', $str );
		return $this->remove_accent( $str );
	}
    
    //==========================================================
    // 	LIMPIA EL NOMBRE DE ACENTOS
    //==========================================================
	function remove_accent( $chain ) {
		$not_allowed= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitted= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$text = str_replace( $not_allowed , $permitted , $chain );
		return $text;
	}

	//===============================================
	//  VALIDA SI LA IMAGEN TIENE UN FORMATO VALIDO
	//===============================================
	public function is_image( $image ){
		$isImage = FALSE;
		$size = getimagesize( $image ); 
		switch ($size['mime']) { 
			case "image/jpeg": 
			$isImage = TRUE;
			break; 
			case "image/png": 
			$isImage = TRUE;
			break; 
			case "image/gif": 
			$isImage = TRUE;
			break; 
		} 
		return  array(
			'is_image'	=>$isImage,
			'type' 		=> $size['mime']
		);
	}

	//===============================================
	//  VALIDA SI EL ARCHIVO ES UN PDF
	//===============================================
	public function is_pdf( $file ){
		$isPdf = FALSE;
		$mime = mime_content_type( $file );
		switch( $mime ){
			case "application/pdf";
			$isPdf = TRUE;
		}
		return array(
			'is_pdf'=>$isPdf,
			'type' =>$mime
		);
	}

	
	//========================================================
	// 	ENVIO GET MEDIANTE CURL
	//========================================================
	public function curl_get( $url ){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL , $url ); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt($ch, CURLOPT_TIMEOUT, 500);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                                                                  
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
					'Content-Type: application/json')                                                                      
		);
		set_time_limit(0);   
		$content = curl_exec( $ch );
		curl_close( $ch );
		return json_decode( $content );
	}

	//========================================================
	// 	ENVIO POST MEDIANTE POST
	//========================================================
	public function curl_post($url , $params){
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL , $url );  
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt( $ch, CURLOPT_TIMEOUT , 3 );
		curl_setopt( $ch, CURLOPT_POST , 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS , $params );
		$content = curl_exec( $ch );
		curl_close( $ch );
		return json_decode( $content );
	}
	//========================================================
	// 	ENVIO POST MEDIANTE POST
	//========================================================
	public function curl_put($url , $params){
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL , $url );  
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt( $ch, CURLOPT_TIMEOUT , 3 );
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt( $ch, CURLOPT_POSTFIELDS , $params );
		$content = curl_exec( $ch );
		curl_close( $ch );
		return json_decode( $content );
	}
	

	

	

	
	
	

	//==========================================================
    // SUBE UN ARCHIVO LOCALMENTE
	//==========================================================
	public function upload_file( $file,$dir,$folder,$name="",$sub_folder = "") { 

		$file_ext = $file;
		$extension = pathinfo($file_ext['name'], PATHINFO_EXTENSION);
		$time = time();
		if($name != ''){
			$file_name = $name."_".rand ( 10000 , 99999 )."_".$time.".".$extension."";
		}else{
			$file_name = "".$folder."_".rand ( 10000 , 99999 )."_".$time.".".$extension."";
		}


		if($sub_folder != ''){
			$dir =  $dir.$folder.'/'.$sub_folder.'/' ;
		}else{
			$dir =  $dir.$folder.'/';
		}

		if(!file_exists($dir)){
			mkdir($dir,0777,true);
			if(file_exists($dir)){
				if(move_uploaded_file($file['tmp_name'],$dir.$file_name)){
					$result = array(
						'err'		 =>FALSE,
						'file'  =>$file_name,
						'msg'=>'Archivo guardado correctamente.'
					);
					return $result ;
				}else{
					$result = array(
						'err'	=> TRUE,
						'file'  =>$file_name,
						'msg'=>'No se pudo subir la imagen.'
					);
					return $result ;
				}
			}
		}else{
			if(move_uploaded_file($file['tmp_name'],$dir.$file_name)){
				$result = array(
					'err'		 =>FALSE,
					'file'  =>$file_name,
					'msg'=>'Archivo guardado correctamente.'
				);
				return $result ;
			}else{
				$result = array(
					'err'	=> TRUE,
					'file'  =>$file_name,
					'msg'=>'No se pudo subir la imagen.'
				);
				return $result ;
			}
		}
	}

	//==========================================================
    // BORRA UN ARCHIVO LOCALMENTE
	//==========================================================
	public function delete_file($path){
		$path = $path;

		if (file_exists($path)){
			if(unlink($path)){
				$result = array(
					'err'		=>FALSE,
					'msg'	=>'Se ha borrado archivo.'
				);
				return $result;
			}
		}else{
			$result = array(
				'err'		=>TRUE,
				'msg'	=>'Se ha producido un error al tratar de borrar el archivo.'
			);
			return $result;
		}
	}

	//==========================================================
    // ACTUZALIZA UN ARCHIVO LOCALMENTE
	//==========================================================
	public function update_file($file,$dir,$id,$table,$field,$folder,$name='',$sub_folder=''){
		if($sub_folder == ''){

			$success =  $this->upload_file($file,$dir,$folder,$name);

		}else{
			$success =  $this->upload_file($file,$dir,$folder,$name,$sub_folder);
			$folder = $folder."/".$sub_folder;
		}
		
	
		if(!$success['err']){
			$path  = $this->get_image($table,$id,$field);
			$result = $this->delete_file( $dir.$folder."/".$path );
			$result['file'] = $success['file'];
			return $result ;

		}

		$result = array(
			'err'		=>TRUE,
			'message'	=>'Se ha producido un error al tratar de subir la imagen'
		);

		return $result;

	}
	
	function format_decimales($amount){
	
		$vdate = strrpos($amount,'.');
			
		if($vdate===false)
		{
			$amount = $amount.'.00';
		}
		else
		{
			$vnumero = explode('.',$amount);
			if(strlen($vnumero[1])==2)
			{$amount = $amount;}
			elseif(strlen($vnumero[1])>2)
			{$amount = $vnumero[0].'.'.substr($vnumero[1],0,2);}
			elseif(strlen($vnumero[1])==1)
			{$amount = $vnumero[0].'.'.$vnumero[1].'0';}
			//elseif(strlen($vnumero[1])==2)
			//{$amount = $vnumero[0].'.'.$vnumero[1].'00';}
			//elseif(strlen($vnumero[1])==3)
			//{$amount = $vnumero[0].'.'.$vnumero[1].'0';}
		}
		return $amount;
	}
}
	



