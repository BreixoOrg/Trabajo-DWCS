<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $data['titulo']; ?></h1>

</div>

<!-- Content Row -->

<div class="row">
            
            <!-- RESULTADO -->
            
            <?php  if(isset($data['tablaMedias'])){ ?>
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo']; ?></h6>                                    
                    </div>

                    <!-- TABLA DE NOTAS -->
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Módulo</th>
                                    <th>Media</th>
                                    <th>Aprobados</th>
                                    <th>Suspensos</th>
                                    <th>Máximo</th>
                                    <th>Mínimo</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php

                                    foreach ($data['tablaMedias'] as $asignatura => $datos) {

                                        echo '<tr>';

                                        echo '<th class="font-weight-light">'. ucfirst($asignatura).'</th>';
                                        echo '<th class="font-weight-light">'. number_format($datos['media'],2,',','.').'</th>';
                                        echo '<th class="font-weight-light">'.$datos['aprobados'].'</th>';
                                        echo '<th class="font-weight-light">'.$datos['suspensos'].'</th>';

                                        echo '<th class="font-weight-light">'.$datos['max']['alumno'].': '. number_format($datos['max']['nota'], 2, ',', '.').'</th>';
                                        echo '<th class="font-weight-light">'.$datos['min']['alumno'].': '.number_format($datos['min']['nota'], 2, ',', '.').'</th>';

                                        echo '</tr>';
                                    }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                
                    <!-- TABLA TODO APROBADO -->

                    <div class="col-lg-6 col-12">
                        <div class="alert alert-success">
                            <ol>
                                <?php 

                                    foreach($data['repruebanPasanCurso'] as $nombre => $asignaturas){

                                        $asignaturasSuspensas = 0;
                                        foreach ($asignaturas as $nota) {

                                            if($nota < 5){
                                                $asignaturasSuspensas++;
                                            }

                                        }

                                        if(!$asignaturasSuspensas != 0){
                                            echo '<li>'. strtoupper($nombre).'</li>';
                                        }

                                    }

                                ?>
                            </ol>
                        </div>
                    </div>


                    <!-- TABLA QUEDA UNA O MAS SUSPENSAS -->

                    <div class="col-lg-6 col-12">
                        <div class="alert alert-warning">
                            <ol>
                                <?php 

                                    foreach($data['repruebanPasanCurso'] as $nombre => $asignaturas){

                                        $asignaturasSuspensas = 0;
                                        foreach ($asignaturas as $nota) {

                                            if($nota < 5){
                                                $asignaturasSuspensas++;
                                            }

                                        }

                                        if($asignaturasSuspensas > 0){
                                            echo '<li>'. strtoupper($nombre).'</li>';
                                        }

                                    }

                                ?>
                            </ol>
                        </div>
                    </div>
                
                

                    <!-- TABLA QUEDA SOLO UNA SUSPENSA -->

                    <div class="col-lg-6 col-12">
                        <div class="alert alert-info">
                            <ol>
                                <?php 

                                    foreach($data['repruebanPasanCurso'] as $nombre => $asignaturas){

                                        $asignaturasSuspensas = 0;
                                        foreach ($asignaturas as $nota) {

                                            if($nota < 5){
                                                $asignaturasSuspensas++;
                                            }

                                        }

                                        if($asignaturasSuspensas == 1){
                                            echo '<li>'. strtoupper($nombre).'</li>';
                                        }

                                    }

                                ?>
                            </ol>
                        </div>
                    </div>


                    <!-- TABLA QUEDAN DOS O MAS SUSPENSAS -->

                    <div class="col-lg-6 col-12">
                        <div class="alert alert-danger">
                            <ol>
                                <?php 

                                    foreach($data['repruebanPasanCurso'] as $nombre => $asignaturas){

                                        $asignaturasSuspensas = 0;
                                        foreach ($asignaturas as $nota) {

                                            if($nota < 5){
                                                $asignaturasSuspensas++;
                                            }

                                        }

                                        if($asignaturasSuspensas >= 2){
                                            echo '<li>'. strtoupper($nombre).'</li>';
                                        }

                                    }

                                ?>
                            </ol>
                        </div>
                    </div>
            
            <?php } ?>
                    
        <div class="col-12">  
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <form method="post" action="./?sec=calculoNotas.Breixo">
                    <div class="mb-3">
                        <label for="textAreaU">Introduzca su JSON</label>
                        <textarea class="form-control" id="textAreaU" name="textAreaU" rows="10"><?php echo isset($data['input']['textAreaU']) ? $data['input']['textAreaU'] : '' ?></textarea>
                    </div>
                    <p class="text-danger"><?php echo isset($data['errores']['errores']) ? $data['errores']['errores']: '' ?></p>
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="Enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
</div>

