<?php

namespace App\Models;

use CodeIgniter\Model;

class SesionModel extends Model
{
    public function actualizar_session($opcion)
    {
        // Instanciamos el servicio de sesión de CI4
        $session = session();

        switch ($opcion)
        {
            case 0:
                // Destruye toda la sesión por completo (equivalente a sess_destroy)
                $session->destroy();
                break;

            case 1:
                // Elimina las variables específicas de la sesión una por una (equivalente a unset_userdata)
                $session->remove([
                    'datossistema',
                    'sesionexiste',
                    'datossesionusuario',
                    'formaccion',
                    'sesion',
                    'datosseguridad',
                    'datos',
                    'moduloactual'
                ]);
                break;

            case 2:
            case 3:
                // Opciones reservadas o futuras (por ahora sin acción, tal como lo tenías)
                break;
        }
    }
}