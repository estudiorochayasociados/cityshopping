<?php $filterCrearEmpresa = array("cod_usuario = '" . $_SESSION['usuarios']['cod'] . "'");
$existeEmpresa = $empresa->list($filterCrearEmpresa, "", "");
$borrarImg = $funcion->antihack_mysqli(isset($_GET["borrarImg"]) ? $_GET["borrarImg"] : '');
if ($borrarImg != '') {
    $imagenes->set("id", $borrarImg);
    $imagenes->delete();
    $funcion->headerMove(URL . "/panel?op=empresa#collapse4");
}
?>
<div class="dashboard-area">
    <div class="dashboard_contents">
        <div class="container">
            <div class="">
                <?php
                if (!empty($existeEmpresa)):
                    ?>
                    <div>
                        <?php if (isset($_POST["modificarEmpresa"])):

                            $titulo = $funcion->antihack_mysqli(!empty($_POST["tituloEmpresa"]) ? $_POST["tituloEmpresa"] : $empresaData['titulo']);
                            $desarrollo = $funcion->antihack_mysqli(!empty($_POST["desarrolloEmpresa"]) ? $_POST["desarrolloEmpresa"] : $empresaData['desarrollo']);
                            $telefono = $funcion->antihack_mysqli(!empty($_POST["telefonoEmpresa"]) ? $_POST["telefonoEmpresa"] : $empresaData['telefono']);
                            $email = $funcion->antihack_mysqli(!empty($_POST["emailEmpresa"]) ? $_POST["emailEmpresa"] : $empresaData['email']);
                            $provincia = $funcion->antihack_mysqli(!empty($_POST["provinciaEmpresa"]) ? $_POST["provinciaEmpresa"] : $empresaData['provincia']);
                            $ciudad = $funcion->antihack_mysqli(!empty($_POST["ciudadEmpresa"]) ? $_POST["ciudadEmpresa"] : $empresaData['ciudad']);
                            $barrio = $funcion->antihack_mysqli(!empty($_POST["barrioEmpresa"]) ? $_POST["barrioEmpresa"] : $empresaData['barrio']);
                            $direccion = $funcion->antihack_mysqli(!empty($_POST["direccionEmpresa"]) ? $_POST["direccionEmpresa"] : $empresaData['direccion']);
                            $postal = $funcion->antihack_mysqli(!empty($_POST["postalEmpresa"]) ? $_POST["postalEmpresa"] : $empresaData['postal']);
                            $delivery = $funcion->antihack_mysqli(isset($_POST["deliveryEmpresa"]) ? $_POST["deliveryEmpresa"] : $empresaData['delivery']);
                            $tiempoEntrega = $funcion->antihack_mysqli(isset($_POST["tiempoEntregaEmpresa"]) ? $_POST["tiempoEntregaEmpresa"] : $empresaData['tiempoEntrega']);

                            if ($direccion != $empresaData['direccion'] || $ciudad != $empresaData['ciudad'] || $provincia != $empresaData['provincia']):
                                $ubicacionEmpresa = $direccion . '+' . $ciudad . '+' . $provincia;
                                $ubicacionEmpresa = str_replace("-", "+", $funcion->normalizar_link($ubicacionEmpresa));

                                $jsonEmpresa = json_decode(file_get_contents('https://geocoder.api.here.com/6.2/geocode.json?app_id=Nkd7zJVtg6iaOyaQoEvK&app_code=HTkK8DlaV14bg6RDCA-pQA&searchtext=' . $ubicacionEmpresa));
                                $empresaLongitud = $jsonEmpresa->Response->View[0]->Result[0]->Location->DisplayPosition->Longitude;
                                $empresaLatitud = $jsonEmpresa->Response->View[0]->Result[0]->Location->DisplayPosition->Latitude;
                                $coordenadas = $empresaLatitud . ',' . $empresaLongitud;
                            else:
                                $coordenadas = $empresaData['coordenadas'];
                            endif;

                            $empresa->set("id", $empresaData['id']);
                            $empresa->set("cod", $empresaData['cod']);
                            $empresa->set("fecha", $empresaData['fecha']);
                            $empresa->set("cod_usuario", $empresaData['cod_usuario']);
                            $empresa->set("titulo", $titulo);
                            $empresa->set("desarrollo", $desarrollo);
                            $empresa->set("telefono", $telefono);
                            $empresa->set("email", $email);
                            $empresa->set("provincia", $provincia);
                            $empresa->set("ciudad", $ciudad);
                            $empresa->set("barrio", $barrio);
                            $empresa->set("direccion", $direccion);
                            $empresa->set("postal", $postal);
                            $empresa->set("delivery", $delivery);
                            $empresa->set("tiempoEntrega", $tiempoEntrega);
                            $empresa->set("coordenadas", $coordenadas);

                            if (isset($_POST["enviosEmpresa1"])) {
                                $envio->set("cod_empresa", $empresaData['cod']);
                                $envio->delete();
                                for ($i = 0; $i < count($_POST["enviosEmpresa1"]); $i++) {
                                    if (!empty($_POST["enviosEmpresa1"][$i])) {
                                        $cod_envios = substr(md5(uniqid(rand())), 0, 10);
                                        $envio1 = $funcion->antihack_mysqli(!empty($_POST["enviosEmpresa1"][$i]) ? $_POST["enviosEmpresa1"][$i] : '');
                                        $envio2 = $funcion->antihack_mysqli(!empty($_POST["enviosEmpresa2"][$i]) ? $_POST["enviosEmpresa2"][$i] : '');

                                        $envio->set("cod", $cod_envios);
                                        $envio->set("titulo", $envio1);
                                        $envio->set("precio", $envio2);
                                        $envio->set("cod_empresa", $empresaData['cod']);

                                        $envio->add();
                                    }
                                }
                            } else {
                                $cod_envios = substr(md5(uniqid(rand())), 0, 10);
                                $envio1 = "Retiro en sucursal";
                                $envio2 = 0;

                                $envio->set("cod", $cod_envios);
                                $envio->set("titulo", $envio1);
                                $envio->set("precio", $envio2);
                                $envio->set("cod_empresa", $empresaData['cod']);

                                $envio->deleteAll();
                                $envio->add();
                            }

                            if (!empty($_FILES["logoEmpresa"]["name"])):
                                //logo
                                $imgInicio = $_FILES["logoEmpresa"]["tmp_name"];
                                $tucadena = $_FILES["logoEmpresa"]["name"];
                                $partes = explode(".", $tucadena);
                                $dom = (count($partes) - 1);
                                $dominio = $partes[$dom];
                                $prefijo = substr(md5(uniqid(rand())), 0, 10);
                                if ($dominio != ''):
                                    $destinoFinal = "assets/archivos/" . $prefijo . "." . $dominio;
                                    move_uploaded_file($imgInicio, $destinoFinal);
                                    chmod($destinoFinal, 0777);
                                    $destinoRecortado = "assets/archivos/recortadas/a_" . $prefijo . "." . $dominio;

                                    $zebra->source_path = $destinoFinal;
                                    $zebra->target_path = $destinoRecortado;
                                    $zebra->jpeg_quality = 80;
                                    $zebra->preserve_aspect_ratio = true;
                                    $zebra->enlarge_smaller_images = true;
                                    $zebra->preserve_time = true;

                                    if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED)):
                                        unlink($destinoFinal);
                                    endif;

                                    $empresa->set("logo", str_replace("../", "", $destinoRecortado));
                                endif;
                            //logo
                            else:
                                $empresa->set("logo", $empresaData['logo']);
                            endif;
                            if (!empty($_FILES["portadaEmpresa"]["name"])):
                                //portada

                                $imgInicio = $_FILES["portadaEmpresa"]["tmp_name"];
                                $tucadena = $_FILES["portadaEmpresa"]["name"];
                                $partes = explode(".", $tucadena);
                                $dom = (count($partes) - 1);
                                $dominio = $partes[$dom];
                                $prefijo = substr(md5(uniqid(rand())), 0, 10);
                                if ($dominio != ''):
                                    $destinoFinal = "assets/archivos/" . $prefijo . "." . $dominio;
                                    move_uploaded_file($imgInicio, $destinoFinal);
                                    chmod($destinoFinal, 0777);
                                    $destinoRecortado = "assets/archivos/recortadas/a_" . $prefijo . "." . $dominio;

                                    $zebra->source_path = $destinoFinal;
                                    $zebra->target_path = $destinoRecortado;
                                    $zebra->jpeg_quality = 80;
                                    $zebra->preserve_aspect_ratio = true;
                                    $zebra->enlarge_smaller_images = true;
                                    $zebra->preserve_time = true;

                                    if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED)):
                                        unlink($destinoFinal);
                                    endif;

                                    $empresa->set("portada", str_replace("../", "", $destinoRecortado));
                                endif;
                            //portada
                            else:
                                $empresa->set("portada", $empresaData['portada']);
                            endif;
                            if (!empty($_FILES["filesEmpresa"]["name"])):
                                //galeria
                                $count = 0;
                                foreach ($_FILES['filesEmpresa']['name'] as $f => $name) {
                                    $imgInicio = $_FILES["filesEmpresa"]["tmp_name"][$f];
                                    $tucadena = $_FILES["filesEmpresa"]["name"][$f];
                                    $partes = explode(".", $tucadena);
                                    $dom = (count($partes) - 1);
                                    $dominio = $partes[$dom];
                                    $prefijo = substr(md5(uniqid(rand())), 0, 10);
                                    if ($dominio != '') {
                                        $destinoFinal = "assets/archivos/" . $prefijo . "." . $dominio;
                                        move_uploaded_file($imgInicio, $destinoFinal);
                                        chmod($destinoFinal, 0777);
                                        $destinoRecortado = "assets/archivos/recortadas/a_" . $prefijo . "." . $dominio;

                                        $zebra->source_path = $destinoFinal;
                                        $zebra->target_path = $destinoRecortado;
                                        $zebra->jpeg_quality = 80;
                                        $zebra->preserve_aspect_ratio = true;
                                        $zebra->enlarge_smaller_images = true;
                                        $zebra->preserve_time = true;

                                        if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED)) {
                                            unlink($destinoFinal);
                                        }

                                        $imagenesEmpresa->set("cod", $empresaData['cod']);
                                        $imagenesEmpresa->set("ruta", str_replace("../", "", $destinoRecortado));
                                        $imagenesEmpresa->add();
                                    }

                                    $count++;
                                }
                                //galeria
                            endif;

                            $empresa->edit();
                            $funcion->headerMove(URL . '/panel?op=empresa');
                        endif;
                        ?>

                        <div class="dashboard_title_area">
                            <div class="dashboard__title">
                                <h3>Datos de la empresa</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="post" class="setting_form">
                                    <div class="information_module">
                                        <div class="information_module">
                                            <a class="toggle_title" href="#collapse1" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse1">
                                                <h4>Modificar datos
                                                    <span class="lnr lnr-chevron-down"></span>
                                                </h4>
                                            </a>

                                            <div class="information__set toggle_module collapse show" id="collapse1">
                                                <div class="information_wrapper form--fields">
                                                    <p>
                                                        Completa los siguientes campos:
                                                    </p>
                                                    <div class="form-group">
                                                        <label>Nombre de la empresa</label>
                                                        <input class="text_field" value="<?php if (!empty($empresaData['titulo'])) {
                                                            echo $empresaData['titulo'];
                                                        } ?>" name="tituloEmpresa" id="tituloEmpresa" type="text"
                                                               placeholder="Ej. Restaurante Argentino">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Descripción de la empresa</label>
                                                        <textarea class="wysihtml5 form-control" name="desarrolloEmpresa"
                                                                  placeholder="Breve descripción ..."
                                                                  style="height: 200px;">
                                                             <?php if (!empty($empresaData['desarrollo'])) {
                                                                 echo $empresaData['desarrollo'];
                                                             } ?>
                                                         </textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-xs-6">
                                                            <div class="form-group">
                                                                <label>Teléfono</label>
                                                                <input type="text" value="<?php if (!empty($empresaData['telefono'])) {
                                                                    echo $empresaData['telefono'];
                                                                } ?>" id="telefonoEmpresa" name="telefonoEmpresa" class="text_field"
                                                                       placeholder="Ej. 111 123456">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-xs-6">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" value="<?php if (!empty($empresaData['email'])) {
                                                                    echo $empresaData['email'];
                                                                } ?>" id="emailEmpresa" name="emailEmpresa" class="text_field"
                                                                       placeholder="Ej. ventas@mirestaurante.com">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dashboard_setting_btn">
                                                        <button type="submit" name="modificarEmpresa" class="btn btn--round btn--md">Modificar Datos
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end /.information_wrapper -->
                                            </div>
                                            <!-- end /.information__set -->
                                        </div>
                                        <!-- end /.information_module -->
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-12">
                                <form method="post" class="setting_form">
                                    <div class="information_module">
                                        <div class="information_module">
                                            <a class="toggle_title" href="#collapse2" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse2">
                                                <h4>Datos de envío
                                                    <span class="lnr lnr-chevron-down"></span>
                                                </h4>
                                            </a>

                                            <div class="information__set toggle_module collapse show" id="collapse2">
                                                <div class="information_wrapper form--fields">
                                                    <p>
                                                        Completa los datos sobre la forma de envío y su costo:
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <h4>¿Cuentan con delivery?</h4>
                                                                <select name="deliveryEmpresa" class="form-control">
                                                                    <option selected disabled>Seleccionar</option>
                                                                    <option value="1" <?php if ($empresaData['delivery'] == 1) {
                                                                        echo 'selected';
                                                                    } ?>>Si
                                                                    </option>
                                                                    <option value="0" <?php if ($empresaData['delivery'] == 0) {
                                                                        echo 'selected';
                                                                    } ?>>No
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <h4>Tiempo de entrega</h4>
                                                                <input type="text" value="<?= $empresaData['tiempoEntrega'] ?>" id="tiempoEntregaEmpresa" name="tiempoEntregaEmpresa" class="text_field"
                                                                       placeholder="Ej. 35">
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <?php foreach ($enviosArray as $key => $value) { ?>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Descripción</label>
                                                                    <input type="text" value="<?= $value['titulo'] ?>" id="enviosEmpresa1" name="enviosEmpresa1[]" class="text_field"
                                                                           placeholder="Ej. Envío zona centro">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Costo</label>
                                                                    <input type="number" value="<?= $value['precio'] ?>" id="enviosEmpresa2" name="enviosEmpresa2[]" class="text_field"
                                                                           placeholder="Ej. 50">
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <a class="MasCampos col-md-12" href="#" id="mascamposEnvios"><i
                                                                    class="icon_plus_alt"></i> Agregar más campos</a>
                                                    </div>
                                                    <div class="dashboard_setting_btn">
                                                        <button type="submit" name="modificarEmpresa" class="btn btn--round btn--md">Modificar Datos
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end /.information_wrapper -->
                                            </div>
                                            <!-- end /.information__set -->
                                        </div>
                                        <!-- end /.information_module -->
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-12">
                                <form method="post" class="setting_form">
                                    <div class="information_module">
                                        <div class="information_module">
                                            <a class="toggle_title" href="#collapse3" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse3">
                                                <h4>Datos de ubicación
                                                    <span class="lnr lnr-chevron-down"></span>
                                                </h4>
                                            </a>

                                            <div class="information__set toggle_module collapse show" id="collapse3">
                                                <div class="information_wrapper form--fields">
                                                    <p>
                                                        Completa los datos sobre la ubicación de tu empresa:
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Provincia</label>
                                                                <select class="form-control" name="provinciaEmpresa" id="provinciaEmpresa">
                                                                    <option value="" selected disabled>Seleccionar provincia</option>
                                                                    <option value="Córdoba" <?php if ($empresaData['provincia'] == 'Córdoba') {
                                                                        echo 'selected';
                                                                    } ?>>Córdoba
                                                                    </option>
                                                                    <option value="Buenos Aires" <?php if ($empresaData['provincia'] == 'Buenos Aires') {
                                                                        echo 'selected';
                                                                    } ?>>Buenos Aires
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Ciudad</label>
                                                                <select class="form-control" name="ciudadEmpresa" id="ciudadEmpresa">
                                                                    <option value="" selected disabled>Seleccionar ciudad</option>
                                                                    <option value="San Francisco" <?php if ($empresaData['ciudad'] == 'San Francisco') {
                                                                        echo 'selected';
                                                                    } ?>>San Francisco
                                                                    </option>
                                                                    <option value="Gran Buenos Aires Zona Sur" <?php if ($empresaData['ciudad'] == 'Gran Buenos Aires Zona Sur') {
                                                                        echo 'selected';
                                                                    } ?>>Gran Buenos Aires Zona Sur
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Barrio</label>
                                                                <input type="text" value="<?php if (!empty($empresaData['barrio'])) {
                                                                    echo $empresaData['barrio'];
                                                                } ?>" id="barrioEmpresa" name="barrioEmpresa" class="form-control"
                                                                       placeholder="Ej. Las Rosas">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Dirección</label>
                                                                <input type="text" value="<?php if (!empty($empresaData['direccion'])) {
                                                                    echo $empresaData['direccion'];
                                                                } ?>" id="direccionEmpresa" name="direccionEmpresa" class="form-control"
                                                                       placeholder="Ej. Urquiza 555">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Código Postal</label>
                                                                <input type="text" value="<?php if (!empty($empresaData['postal'])) {
                                                                    echo $empresaData['postal'];
                                                                } ?>" id="postalEmpresa" name="postalEmpresa" class="form-control"
                                                                       placeholder="Ej. 2400">
                                                            </div>
                                                        </div>
                                                    </div><!--End row -->
                                                    <div class="dashboard_setting_btn">
                                                        <button type="submit" name="modificarEmpresa" class="btn btn--round btn--md">Modificar Datos
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end /.information_wrapper -->
                                            </div>
                                            <!-- end /.information__set -->
                                        </div>
                                        <!-- end /.information_module -->
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-12">
                                <form method="post" class="setting_form" enctype="multipart/form-data">
                                    <div class="information_module">
                                        <div class="information_module">
                                            <a class="toggle_title" href="#collapse4" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse4">
                                                <h4>Imágenes de tu empresa
                                                    <span class="lnr lnr-chevron-down"></span>
                                                </h4>
                                            </a>

                                            <div class="information__set toggle_module collapse show" id="collapse4">
                                                <div class="information_wrapper form--fields">
                                                    <p>
                                                        Logo y demás imágenes de tu empresa.:
                                                    </p>
                                                    <div class="form-group">
                                                        <h3>Logo</h3>
                                                        <label>Logo de tu empresa</label><br/>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <?php if ($empresaData['logo'] != '') { ?>
                                                                    <img src="<?= URL; ?>/<?= $empresaData['logo']; ?>" width="100%"/>
                                                                <?php } else { ?>
                                                                    <img src="<?= URL; ?>/assets/archivos/sin_imagen.jpg" width="100%"/>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <br/>
                                                            <div class="col-md-12 mt-15">
                                                                <input class="input-imagen" type="file" id="logoEmpresa" name="logoEmpresa"/>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <hr/>
                                                    <div class="form-group">
                                                        <h3>Portada</h3>
                                                        <label>Portada de tu empresa</label><br/>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <?php if ($empresaData['portada'] != '') { ?>
                                                                    <img src="<?= URL; ?>/<?= $empresaData['portada']; ?>" width="100%"/>
                                                                <?php } else { ?>
                                                                    <img src="<?= URL; ?>/assets/archivos/sin_imagen.jpg" width="100%"/>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <br/>
                                                            <div class="col-md-12 mt-15">
                                                                <input class="input-imagen" type="file" id="portadaEmpresa" name="portadaEmpresa"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <hr/>
                                                    <div class="form-group">
                                                        <h3>Galería</h3>
                                                        <label>Galería de fotos de tu empresa</label><br/>
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <?php if (!empty($imagenesArrayEmpresa)) {
                                                                    foreach ($imagenesArrayEmpresa as $key => $value): ?>
                                                                        <?php
                                                                        echo "<div class='col-md-2 mb-20 mt-20'>";
                                                                        echo "<div style='height: 200px; background: url('".URL . '/' . $value['ruta']."') no-repeat center center/cover;'></div>"
                                                                        echo "<img src='".URL .'/'. $value["ruta"] . "' width='100%'  class='mb-20' />";
                                                                        echo "<a href='" . URL . "/panel?op=empresa&cod=" . $value["cod"] . "&borrarImg=" . $value["id"] . "' class='btn btn-primary'>BORRAR IMAGEN</a>";
                                                                        echo "<div class='clearfix'></div>";
                                                                        echo "</div>";
                                                                        ?>
                                                                    <?php endforeach;
                                                                } else { ?>
                                                                    <div class="col-md-2">
                                                                        <img src="<?= URL; ?>/assets/archivos/sin_imagen.jpg" width="100%"/>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <br/>
                                                        <div class="form-group mt-15">
                                                            <input class="input-imagen" type="file" id="filesEmpresa" name="filesEmpresa[]" multiple="multiple"/>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="dashboard_setting_btn">
                                                        <button type="submit" name="modificarEmpresa" class="btn btn--round btn--md">Modificar Datos
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end /.information_wrapper -->
                                            </div>
                                            <!-- end /.information__set -->
                                        </div>
                                        <!-- end /.information_module -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                else:
                    ?>
                    <div class="col-md-offset-3 col-md-6">
                        <div class="box_style_2">
                            <div id="confirm">
                                <i class="icon-shop-1"></i>
                                <h3>¡Completá los datos de tu empresa y empezá a vender!</h3>
                            </div>
                            <a href="<?= URL ?>/crear_empresa" class="btn_full">Crear Empresa</a>
                        </div>
                    </div>

                <?php
                endif; ?>
            </div>
        </div>
        <!-- end /.container -->
    </div>
</div>