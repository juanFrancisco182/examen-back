<?php
if( ! defined('BASEPATH') ) exit('No direct script access allowed');

$config = array(

	//========================================================
	// 	VALIDACION REGISTRO DE PRODUCTO
	//========================================================
	'create_product'=> array(
		array( 'field'=>'nombre_producto', 'label'=>'Nombre del Producto','rules'=>'trim|required|max_length[30]' ),
		array( 'field'=>'precio_producto', 'label'=>'Precio del Producto','rules'=>'trim|required' ),
    array( 'field'=>'descripcion_producto', 'label'=>'Precio del Producto','rules'=>'trim|required' ),
	),
  	//========================================================
	// 	VALIDACION REGISTRO DE PRODUCTO
	//========================================================
	'create_user'=> array(
		array( 'field'=>'name', 'label'=>'Nombre ','rules'=>'trim|required' ),
		array( 'field'=>'job', 'label'=>'Trabajo','rules'=>'trim|required' ),
    array( 'field'=>'email', 'label'=>'Email','rules'=>'trim|required|valid_email' ),
    array( 'field'=>'last_name', 'label'=>'Apellidos','rules'=>'trim|required' ),
    
	),
);

?>
