<?php
include_once '../data/sesionData.php';

class SesionBusiness
{
    private $sesionData;

    public function __construct()
    {
        $this->sesionData = new SesionData();
    }

    public function autenticarUsuario($username, $password)
    {
        // Llama al método de SesionData para obtener los datos del usuario
        $sesion = $this->sesionData->verificarUsuario($username);

        if ($sesion && password_verify($password, $sesion['tbsesionusuariocontrasenia'])) {
            // Verifica si el usuario está activo
            if ($sesion['tbsesionusuarioestado'] == 1) {
                // Retornar los datos de la sesión, incluyendo el rol
                return $sesion;
            } else {
                return null; // Usuario inactivo
            }
        } else {
            return null; // Credenciales inválidas
        }
    }
}
