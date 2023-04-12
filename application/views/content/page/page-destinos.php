<?php
    //echo json_encode($destinos);
?>


<style>
.destino{
    box-shadow: 1px 1px 1px black;
    position: relative;
    overflow: hidden;
    margin-top: 10px;
    margin-bottom: 10px;
}
.destino .imagen img{
    width: 100%;
    height: 210px;
    cursor: pointer;
    -moz-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}
.destino:hover img{
    -moz-transform: scale(1.1);
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    width: 100%;
}
.destino .capa {
    position: absolute;
    top: 0px;
    left: 0px;
    background-color: rgba(0,0,0,0.3);
    width: 100%;
    height: 100%;
}
.destino .titulo{
    position: absolute;
    top: 40px;
    right: 20px;
    color: white;
    font-size: 18px;
    text-transform: uppercase;
    text-align: right;
}
.destino .titulo .div-header{
    padding-bottom: 5px;
    margin-bottom: 15px;
    border-bottom: 1px solid white;
}
.destino .titulo a{
    color: white;
    font-size: 14px;
    padding-left: 10px;
    padding-right: 10px;
    border: 1px solid white;
}

</style>
<div style="font-size: 30px;text-align: center;background-color: #f1f1f1;">
    
    <?=($language=='es')?'Nuestros Destinos':'Our Destinations';?> 
</div>
<div class="container">
    <div class="row">
        <?php
            if (!empty($destinos)) {
                foreach($destinos as $destino){
                        $d_nombre = $destino['descripcion_destino'];
                        $d_imagen = $destino['imagen_slider'];
                        $d_url    = $destino['url_destino'];
                    echo "
                    <div class='col-12 col-md-6 col-xl-4'>
                        <div class='destino'>
                            <div class='imagen'>
                                <img src='$d_imagen'>
                            </div>
                            <a href='$d_url'><div class='capa'>
                            </div></a>
                            <div class='titulo'>
                                <div class='div-header'>$d_nombre</div>
                                <a href='$d_url'>".($language=='es'?'Entrar':'Access')."</a>
                            </div>
                        </div>
                    </div>
                    ";
                    }
            }
        ?>
    </div>
</div>

