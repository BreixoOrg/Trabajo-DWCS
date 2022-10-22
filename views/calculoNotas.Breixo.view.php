<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $data['titulo']; ?></h1>

</div>

<!-- Content Row -->

<div class="row">

    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo']; ?></h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <form method="post" action="./?sec=calculoNotas.Breixo">
                    <div class="mb-3">
                        <label for="textAreaU">Introduzca su JSON</label>
                        <textarea class="form-control" id="textAreaU" name="textAreaU" rows="10" placeholder="<?php echo isset($data['input']['textAreaU']) ? $data['input']['textAreaU'] : '' ?>"></textarea>
                    </div>
                    <p class="text-danger"><?php echo isset($data['errores']['errores']) ? $data['errores']['errores']: '' ?></p>
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="Enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>

