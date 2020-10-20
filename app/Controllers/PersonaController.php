<?php

namespace App\Controllers;

require(__DIR__ . '/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Persona.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Persona;

if (!empty($_GET['action'])) { //PersonaController.php?action=create
    PersonaController::main($_GET['action']);
}

class PersonaController
{

    static function main($action)
    {
        if ($action == "create") {
            PersonaController::create();
        } else if ($action == "edit") {
            PersonaController::edit();
        } else if ($action == "searchForID") {
            PersonaController::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            PersonaController::getAll();
        }  else if ($action == "activate") {
            PersonaController::activate();
        } else if ($action == "inactivate") {
            PersonaController::inactivate();
        }
    }

    static public function create()
    {
        try {
            $arrayPersona = array();
            $arrayPersona['nombres'] = $_POST['nombres'];
            $arrayPersona['apellidos'] = $_POST['apellidos'];
            $arrayPersona['tipoDocumento'] = $_POST['tipoDocumento'];
            $arrayPersona['documento'] = $_POST['documento'];
            $arrayPersona['correo'] = $_POST['correo'];
            $arrayPersona['telefono'] = $_POST['telefono'];
            $arrayPersona['rol'] = 'Cliente';
            $arrayPersona['direccion'] = $_POST['direccion'];
            $arrayPersona['estado'] = 'activo';

            if (!Persona::PersonaRegistrada($arrayPersona['documento'])) {
                $Persona = new Persona ($arrayPersona);
                if ($Persona->create()) {
                    header("Location: ../../views/modules/persona/index.php?respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/persona/create.php?respuesta=error&mensaje=Usuario ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

}