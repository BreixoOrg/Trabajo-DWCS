<?php

$data = [];

$data['titulo'] = "Trabajo-DWCS Cálculo de Notas";
$data['div_titulo'] = "RESULTADO";

if(isset($_POST['Enviar'])){
    
    $data['input'] = sanitizarInput($_POST);
    $data['errores'] = checkForm($_POST);
    
    if(count($data['errores']) == 0){
        $json = json_decode($_POST['textAreaU'], true);
        $data['repruebanPasanCurso'] = repruebanPasanCurso($json);
        $data['tablaMedias'] = calcularMediaSuspensosAprobadosNotaMaxNotaMin($json);
    }
}

//Devuelve un array con cada alumno y sus notas en las asignaturas que cursa
function repruebanPasanCurso($json){
    
    $matriz = [];
    
    foreach($json as $asignatura => $alumnos){
        
        foreach ($alumnos as $nombre => $notas) {
            
            $notaMediaPorAsignatura = 0;
            
            foreach ($notas as $nota) {
                $notaMediaPorAsignatura += $nota;
            }
            $notaMediaPorAsignatura = $notaMediaPorAsignatura / count($notas);
            
            if(!key_exists($nombre, $matriz)){
                $matriz[$nombre] = array();
            }
            
            $matriz[$nombre] += [$asignatura => $notaMediaPorAsignatura];
            
        }
        
    }
    
    return $matriz;
    
}

//Para llevar a cabo el ejercicio para saber si un alumno aprueba o no hace la media de las notas que tiene
function calcularMediaSuspensosAprobadosNotaMaxNotaMin($json){
    
    $matriz = [];
    
    foreach($json as $asignatura => $alumnos){
        
        $matriz[$asignatura] = [];
        
        $matriz[$asignatura]['media'] = 0;
        $matriz[$asignatura]['suspensos'] = 0;
        $matriz[$asignatura]['aprobados'] = 0;
        $matriz[$asignatura]['max'] = ['alumno' => "" ,'nota' => -1];
        $matriz[$asignatura]['min'] = ['alumno' => "" ,'nota' => 11];
        
        $sumaMediasClase = 0;
        
        foreach ($alumnos as $nombre => $notas) {
            $mediaAlumno = 0;
            
            foreach ($notas as $nota) {
                $mediaAlumno += $nota;
            }
            $mediaAlumno = $mediaAlumno / count($notas);
            
            if($mediaAlumno < 5){
                $matriz[$asignatura]['suspensos']++;
            }
            else{
                $matriz[$asignatura]['aprobados']++;
            }
            
            $sumaMediasClase += $mediaAlumno;
            
            if($mediaAlumno > $matriz[$asignatura]['max']['nota']){
                $matriz[$asignatura]['max']['nota'] = $mediaAlumno;
                $matriz[$asignatura]['max']['alumno'] = $nombre;
            }
            else{
                
                if($mediaAlumno < $matriz[$asignatura]['min']['nota']){
                    $matriz[$asignatura]['min']['nota'] = $mediaAlumno;
                    $matriz[$asignatura]['min']['alumno'] = $nombre;
                }
                
            }
            
        }
        
        $matriz[$asignatura]['media'] = $sumaMediasClase / count($alumnos);
        
    }
    
    return $matriz;
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
            
            foreach ($json as $asignatura => $clase) {
                
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
                                    $err_msg .= "En la asignatura de ".htmlentities($asignatura).", ". ucfirst(htmlentities($alumno)." tiene una nota NO numérica<br />");
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
            if(!empty($errores['errores'])){
                $errores['errores'] = $err_msg;
            }
        }
    }
    
    
    return $errores;
}


include 'views/templates/header.php';
include 'views/calculoNotas.Breixo.view.php';
include 'views/templates/footer.php';