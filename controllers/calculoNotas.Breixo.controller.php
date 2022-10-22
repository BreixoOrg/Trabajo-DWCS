<?php

$data = [];

$data['titulo'] = "Trabajo-DWCS";
$data['div_titulo'] = "Cálculo de Notas";

if(isset($_POST['Enviar'])){
    var_dump($_POST);
    $data['input'] = sanitizarInput($_POST);
    $data['errores'] = checkForm($_POST);
    
    if(count($data['errores']) == 0){
        
    }
}

function sanitizarInput($post){
    return filter_var_array($post,FILTER_SANITIZE_SPECIAL_CHARS);
}

function checkForm($post){
    
    $errores = [];
    
    if(empty($post['textAreaU'])){
        $errores['errores'] = "Este campo no puede estar vacío";
    }
    else{
        $json = json_decode($post['textAreaU'], true);
        if(json_last_error() !== JSON_ERROR_NONE){
            $errores['errores'] = 'El formato del JSON no es correcto';
        }
        else{
            $err_msg = "";
            
            foreach ($errores as $asignatura => $clase) {
                
                if(empty($asignatura)){
                    $err_msg .= "El nombre de la asignatura no puede estar vacío<br />";
                }
                
                if(!is_array($clase)){
                    $err_msg .= "El módulo '".htmlentities($clase)."' no tiene un array de alumnos<br />"; 
                }
                else{
                    foreach($clase as $alumno => $notas){
                        if(empty($alumno)){
                            $err_msg .= "El nombre de un alumno/a no puede estar vacío<br />";
                        }
                        if(!is_array($notas)){
                            $err_msg .= "El/La alumno/a ".htmlentities($alumno)." no tiene un array de notas asociado<br />"; 
                        }
                        else{
                            foreach ($notas as $nota) {
                                if(!is_numeric($nota)){
                                    $err_msg .= "En la asignatura de ".htmlentities($asignatura).", ". ucfirst(htmlentities($alumno)." tiene una nota no numérica<br />");
                                }
                                else{
                                    if($nota < 0 || $nota > 10){
                                        $err_msg .= "En la asignatura de ".htmlentities($asignatura).", ". ucfirst(htmlentities($alumno)." tiene una nota superior a 10 o inferior a 0<br />");
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $errores['errores'] = $err_msg;
        }
    }
    
    
    return $errores;
}


include 'views/templates/header.php';
include 'views/calculoNotas.Breixo.view.php';
include 'views/templates/footer.php';