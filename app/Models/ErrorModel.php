<?php

namespace App\Models;

use CodeIgniter\Model;

class ErrorModel extends Model
{
    public function consultar_error($id_error, $msn_error)
    {
        switch ($id_error) {
            case '-1':
                // ERROR NO CONTROLADO
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "Error no controlado comuniquese con el administrador del sistema"
                ];
            case '0':
                // ERROR DE BASE DE DATOS
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => $msn_error
                ];
                
            case '1':
                // NO EXITE PERMISO DE ACCIONES PARA EL USUARIO EN ESTE SERVICIO
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "No exiten permisos a ninguna acción de este servicios asocioadas al rol del usuario para este módulo (seguridad.consultar_permiso_acciones_servicios)"
                ];            
                
            case '2':
                // NO EXISTE SERVICIOS PARA LAS SECCIONES
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "No exiten servicios asocioadas al rol del usuario para este módulo (seguridad.consultar_servicio_modulo_rol)"
                ];            
                
            case '3':
                // NO EXISTE SECCIONES PARA EL MODULO
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "No exiten secciones asocioadas al rol del usuario para este módulo (seguridad.consultar_seccion_modulo_rol)"
                ];            
                
            case '4':
                // NO EXISTE CONFIGURACION PARA ESTE SITIO WEB
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "Error al consultar datos de la configuración del sitio web (seguridad.consultar_configuracion)"
                ];            
                
            case '5':
                // NO EXISTE SERVICIO EN LA BASE DE DATOS
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "Error al consultar servicios existentes en la base de datos (seguridad.consultar_servicio)"
                ];            
                
            case '6':
                // NO EXISTE SERVICIO_ACCION EN LA BASE DE DATOS
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "Error al consultar servicios y acciones existentes en la base de datos (seguridad.consultar_servicio_accion)"
                ];  
                
            case '7':
                // NO EXISTE ROL CON SITIOWEBEMPRESASUCURSAL EN LA BASE DE DATOS
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "Error al consultar rol asociados al sitio web empresa sucursalen la base de datos (seguridad.consultar_rol_con_sitiowebempresasucursal)"
                ]; 
                
            case '8':
                // NO EXISTE ROL CON SITIOWEBEMPRESASUCURSAL EN LA BASE DE DATOS
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "Error al obtener el código (idrolsitiowebempresasucursal)"
                ];   
                
            case '9':
                // NO EXISTE LA OPERACIÓN REQUERIDA POR EL CONTROLADOR
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "Error al obtener la operación requerida por el controlador"
                ];   
                
            case '10':
                // NO EXISTE ROL CON SITIOWEBEMPRESASUCURSAL EN LA BASE DE DATOS
                return [
                    'urlcontroler' => "LoginController",
                    'urlaction' => "index",
                    'urlaltcontroler' => "LoginController",
                    'urlaltaction' => "index",
                    'iderror' => "000",
                    'label' => "Volver a inicio de sesión",
                    'msn' => "Error al consultar rol asociados al sitio web empresa sucursalen la base de datos (seguridad.consultar_rol_sin_sitiowebempresasucursal)"
                ]; 
                
            default:
                return [];
        }
    }
}