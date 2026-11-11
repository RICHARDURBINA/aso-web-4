<?php

namespace App\Controllers;

class MenuController extends BaseController
{
    //=============================================================================================================
    // Cerrar formulario / Centro de página
    //=============================================================================================================
    public function cerrar_formulario()
    { 
        // En CI4 las vistas se retornan directamente
        return view('centropagina/index');
    }

    //=============================================================================================================
    // Cargar Menú Principal del Sistema
    //=============================================================================================================
    public function menu()
    {        
        // Instanciamos la sesión en CI4
        $session = session();
        
        // Obtenemos los datos de la sesión del usuario
        $sesionusuario = $session->get('datossesionusuario');

        // Validación de seguridad por si intentan entrar por URL sin iniciar sesión
        if (empty($sesionusuario)) {
            return redirect()->to(base_url('LoginController/login'));
        }

        // Preparamos el arreglo para pasarlo a la vista
        $arreglo = array('Model_usuario' => $sesionusuario["Model_usuario"]);
        
        // Retornamos la vista cargando los datos del usuario
        return view('menu/index', $arreglo); 
    }   
}