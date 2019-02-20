<?php

$estado = isset($_GET["estado"]) ? $_GET["estado"] : '';
$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';

$cod_usuario = $_SESSION['usuarios']['cod'];

$filterPedidosAgrupados = array("usuario = '" . $cod_usuario . "' GROUP BY cod");
$pedidosArrayAgrupados = $pedido->list($filterPedidosAgrupados, "", "");

$filterPedidosSinAgrupar = array("usuario = '" . $cod_usuario . "'");
$pedidosArraySinAgrupar = $pedido->list($filterPedidosSinAgrupar, "", "");
?>

<div class="row">
    <?php if (empty($pedidosArrayAgrupados)):
        echo "<h4>No hay pedidos todavía.</h4>";
    else: ?>
        <?php foreach ($pedidosArrayAgrupados as $key => $value):
            $precioTotal = 0;
            $fecha = explode(" ", $value["fecha"]);
            $fecha1 = explode("-", $fecha[0]);
            $fecha1 = $fecha1[2] . '-' . $fecha1[1] . '-' . $fecha1[0] . '-';
            $fecha = $fecha1 . $fecha[1];

            $usuario->set("cod", $value["usuario"]);
            $usuarioData = $usuario->view();
            if ($value["detalle"] != "Envio-Seleccion") {
                $pagaCon = $value["detalle"];
            }

            $empresa->set("cod", $value["empresa"]);
            $empresaData = $empresa->view();

            ?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading">
                    <h5 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value["cod"] ?>"
                           aria-expanded="false" aria-controls="collapse<?= $value["cod"] ?>" class="collapsed">
                            Pedido <?= $value["cod"] ?>
                            <span class="hidden-xs hidden-sm">- Fecha <?= $fecha ?></span>
                            <?php if ($value["estado"] == 0): ?>
                                <span style="padding:5px;font-size:13px;margin-top:-3px;border-radius: 10px;"
                                      class="btn-primary pull-right">
                            Estado: Carrito no cerrado
                             </span>
                            <?php elseif ($value["estado"] == 1): ?>
                                <span style="padding:5px;font-size:13px;margin-top:-3px;border-radius: 10px;"
                                      class="btn-warning pull-right">
                            Estado: Pendiente
                             </span>
                            <?php elseif ($value["estado"] == 2): ?>
                                <span style="padding:5px;font-size:13px;margin-top:-3px;border-radius: 10px;"
                                      class="btn-success pull-right">
                            Estado: Aprobado
                             </span>
                            <?php elseif ($value["estado"] == 3): ?>
                                <span style="padding:5px;font-size:13px;margin-top:-3px;border-radius: 10px;"
                                      class="btn-info pull-right">
                            Estado: Enviado
                             </span>
                            <?php elseif ($value["estado"] == 4): ?>
                                <span style="padding:5px;font-size:13px;margin-top:-3px;border-radius: 10px;"
                                      class="btn-danger pull-right">
                            Estado: Rechazado
                             </span>
                            <?php endif; ?>
                        </a>
                    </h5>
                </div>
                <div id="collapse<?= $value["cod"] ?>" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <table class="table table-striped table-responsive table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>
                                    Producto
                                </th>
                                <th>
                                    Cantidad
                                </th>
                                <th class="hidden-xs hidden-sm">
                                    Precio
                                </th>
                                <th>
                                    Precio Final
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($pedidosArraySinAgrupar as $key2 => $value2):
                                if ($value2['cod'] == $value["cod"]):
                                    unset($productosVar);
                                    unset($productosAdi);
                                    if (strpos($value2["producto"], '|||')) {
                                        $productoExp = explode("|||", $value2["producto"]);
                                        $productoMostrar = $productoExp[0];
                                        $productosOpciones = unserialize($productoExp[1]);

                                        if (!empty($productosOpciones[0])) {
                                            $productosVar = explode(",", $productosOpciones[0]);
                                        }

                                        if (!empty($productosOpciones[1])) {
                                            $productosAdi = $productosOpciones[1];
                                        }

                                        //var_dump($productosAdi);
                                    } else {
                                        $productoMostrar = $value2["producto"];
                                    }

                                    $precioUnitarioTotal = '$ ' . $value2["precio"] * $value2["cantidad"];

                                    if ($value2["detalle"] == "Envio-Seleccion") {
                                        $visibleC = 'style="visibility:hidden;"';
                                        $visibleP = '';

                                        if ($value2["precio"] == 0) {
                                            $visibleP = 'style="visibility:hidden;"';
                                            $precioUnitarioTotal = "Sin cargo";
                                            $productoMostrar = '<b>Entrega:</b> ' . $productoMostrar;
                                        }
                                    } else {
                                        $visibleC = '';
                                        $visibleP = '';
                                    }

                                    ?>
                                    <tr>
                                        <td><?= $productoMostrar ?></td>
                                        <td <?= $visibleC ?>><?= $value2["cantidad"] ?></td>
                                        <td <?= $visibleP ?>>$<?= $value2["precio"] ?></td>
                                        <td><?= $precioUnitarioTotal ?></td>
                                        <?php $precioTotal = $precioTotal + ($value2["precio"] * $value2["cantidad"]); ?>
                                    </tr>
                                    <?php if (isset($productosVar)) { ?>
                                    <tr>
                                        <td><b>+ Variante:</b> <?= $productosVar[1] ?></td>
                                        <td></td>
                                        <td>$<?= $productosVar[0] ?></td>
                                        <td>$<?= $productosVar[0] ?></td>
                                        <?php $precioTotal = $precioTotal + $productosVar[0]; ?>
                                    </tr>
                                <?php }
                                    if (isset($productosAdi)) {
                                        foreach ($productosAdi as $item) {
                                            $productosAdiExp = explode(",", $item);
                                            ?>
                                            <tr>
                                                <td><b>+ Adicional:</b> <?= $productosAdiExp[1] ?></td>
                                                <td></td>
                                                <td>$<?= $productosAdiExp[0] ?></td>
                                                <td>$<?= $productosAdiExp[0] ?></td>
                                                <?php $precioTotal = $precioTotal + $productosAdiExp[0]; ?>
                                            </tr>
                                        <?php }
                                    }
                                endif;
                            endforeach; ?>
                            <tr>
                                <td><b>TOTAL DE LA COMPRA</b></td>
                                <td></td>
                                <td></td>
                                <td><b>$<?= $precioTotal ?></b></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-striped table-responsive table-hover">
                            <thead class="thead-dark">
                            <th>
                                Restaurante
                            </th>
                            <th>
                                Teléfono
                            </th>
                            <th>
                                Dirección
                            </th>
                            <th>
                                Tiempo de entrega
                            </th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <?= $empresaData["titulo"] ?>
                                </td>
                                <td>
                                    <?= $empresaData["telefono"] ?>
                                </td>
                                <td>
                                    <?= $empresaData["direccion"] ?> • <?= $empresaData["ciudad"] ?> • <?= $empresaData["provincia"] ?>
                                </td>
                                <td>
                                    <?= $empresaData["tiempoEntrega"] ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-striped table-responsive table-hover">
                            <thead class="thead-dark">
                            <th>
                                Usuario
                            </th>
                            <th>
                                Teléfono
                            </th>
                            <th>
                                Dirección
                            </th>
                            <th>
                                Paga con
                            </th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <?= $usuarioData["nombre"] . ' ' . $usuarioData["apellido"] ?>
                                </td>
                                <td>
                                    <?= $usuarioData["telefono"] ?>
                                </td>
                                <td>
                                    <?= $usuarioData["direccion"] ?> • <?= $usuarioData["localidad"] ?> • <?= $usuarioData["provincia"] ?>
                                </td>
                                <td>
                                    <?= $pagaCon ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                    </div>
                </div>
            </div>
        <?php endforeach;
    endif; ?>
</div><!-- End row -->

<script>
    function eliminar(id) {
        $('#' + id + ' input:first').attr('type', 'hidden');
        $('#' + id + ' input:first').attr('value', 'eliminado');
        $('#' + id + ' .col-md-10').append('<h5 class="alert alert-danger" style="margin-top: 0;padding: 10px;margin-bottom: 0;">Eliminado</h5>');
        $('#' + id + ' button').hide();
    }
</script>