<?php

$estado = isset($_GET["estado"]) ? $_GET["estado"] : '';
$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';

$cod_usuario = $_SESSION['usuarios']['cod'];

$filterPedidosAgrupados = array("usuario = '" . $cod_usuario . "' GROUP BY cod");
$pedidosArrayAgrupados = $pedido->list($filterPedidosAgrupados, "", "");

$filterPedidosSinAgrupar = array("usuario = '" . $cod_usuario . "'");
$pedidosArraySinAgrupar = $pedido->list($filterPedidosSinAgrupar, "", "");
?>
<section>
    <div class="dashboard_contents">
        <div class="container">
            <div class="row">
                <?php if (empty($pedidosArrayAgrupados)):
                    ?>
                    <div class="col-md-12">
                        <div class="dashboard_title_area">
                            <div class="dashboard__title">
                                <h3>No realizaste una compra.</h3>
                            </div>
                        </div>
                    </div>
                <?php
                else: ?>
                    <div class="col-md-12">
                        <?php foreach ($pedidosArrayAgrupados as $key => $value): ?>
                            <?php $usuario->set("cod", $value["usuario"]); ?>
                            <?php $usuarioData = $usuario->view(); ?>
                            <?php $precioTotal = 0; ?>
                            <?php $fecha = explode(" ", $value["fecha"]); ?>
                            <?php $fecha1 = explode("-", $fecha[0]); ?>
                            <?php $fecha1 = $fecha1[2] . '-' . $fecha1[1] . '-' . $fecha1[0] . '-'; ?>
                            <?php $fecha = $fecha1 . $fecha[1]; ?>
                            <?php
                            $empresa->set("cod", $value["empresa"]);
                            $empresaData = $empresa->view();
                            ?>
                            <div class="card">
                                <a data-toggle="collapse" href="#collapse<?= $value["cod"] ?>" aria-expanded="false" aria-controls="collapse<?= $value["cod"] ?>" class="collapsed color_a">
                                    <div class="card-header bg-info" role="tab" id="heading">
                                        <span class="blanco">Pedido <?= $value["cod"] ?></span>
                                        <span class="hidden-xs hidden-sm blanco">- Fecha <?= $fecha ?></span>
                                        <?php if ($value["estado"] == 0): ?>
                                            <span style="padding:5px;font-size:13px;margin-top:-5px;border-radius: 10px;"
                                                  class="btn-danger pull-right">
                            Estado: Carrito no cerrado
                             </span>
                                        <?php elseif ($value["estado"] == 1): ?>
                                            <span style="padding:5px;font-size:13px;margin-top:-5px;border-radius: 10px;"
                                                  class="btn-warning pull-right">
                            Estado: Pago pendiente
                             </span>
                                        <?php elseif ($value["estado"] == 2): ?>
                                            <span style="padding:5px;font-size:13px;margin-top:-5px;border-radius: 10px;"
                                                  class="btn-success pull-right">
                            Estado: Pago aprobado
                             </span>
                                        <?php elseif ($value["estado"] == 3): ?>
                                            <span style="padding:5px;font-size:13px;margin-top:-5px;border-radius: 10px;"
                                                  class="btn-primary pull-right">
                            Estado: Pago enviado
                             </span>
                                        <?php elseif ($value["estado"] == 4): ?>
                                            <span style="padding:5px;font-size:13px;margin-top:-5px;border-radius: 10px;"
                                                  class="btn-danger pull-right">
                            Estado: Pago rechazado
                             </span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                                <div id="collapse<?= $value["cod"] ?>" class="collapse" role="tabpanel"
                                     aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-striped table-hover">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th>
                                                            Producto
                                                        </th>
                                                        <th class="hidden-xs">
                                                            Cantidad
                                                        </th>
                                                        <th class="hidden-xs">
                                                            Precio
                                                        </th>
                                                        <th>
                                                            Precio Final
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($pedidosArraySinAgrupar as $key2 => $value2): ?>
                                                        <?php if ($value2['cod'] == $value["cod"]): ?>
                                                            <tr>
                                                                <td><?= $value2["producto"] ?>
                                                                    <p class="visible-xs">Cantidad: <?= $value2["cantidad"] ?></p>
                                                                    <p class="visible-xs">Precio: $<?= $value2["precio"] ?></p>
                                                                </td>
                                                                <td class="hidden-xs"><?= $value2["cantidad"] ?></td>
                                                                <td class="hidden-xs">$<?= $value2["precio"] ?></td>
                                                                <td>$<?= $value2["precio"] * $value2["cantidad"] ?></td>
                                                                <?php $precioTotal = $precioTotal + ($value2["precio"] * $value2["cantidad"]); ?>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <tr>
                                                        <td><b>TOTAL DE LA COMPRA</b></td>
                                                        <td class="hidden-xs"></td>
                                                        <td class="hidden-xs"></td>
                                                        <td><b>$<?= $precioTotal ?></b></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped table-hover hidden-xs">
                                                    <thead class="thead-dark">
                                                    <th width="40%">
                                                        Empresa
                                                    </th>
                                                    <th width="50%">
                                                        Dirección
                                                    </th>
                                                    <th width="10%">
                                                        Teléfono
                                                    </th>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <?= $empresaData["titulo"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $empresaData["direccion"] ?> • <?= $empresaData["ciudad"] ?> • <?= $empresaData["provincia"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $empresaData["telefono"] ?>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <p class="visible-xs">
                                                    <b>Empresa: </b><?= $empresaData["titulo"] ?> <br>
                                                    <b>Dirección: </b> <?= $empresaData["direccion"] ?>, <?= $empresaData["ciudad"] ?>, <?= $empresaData["provincia"] ?><br>
                                                    <b>Teléfono: </b> <?= $empresaData["telefono"] ?>
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <span style="font-size:16px">
                    <b class="mb-10">FORMA DE PAGO:</b>
                        <br class="visible-xs">
                        <?php if ($value["tipo"] == 0): ?>
                            Transferencia bancaria
                        <?php elseif ($value["tipo"] == 1): ?>
                            Efectivo
                        <?php elseif ($value["tipo"] == 2): ?>
                            Tarjeta de crédito o débito
                        <?php endif; ?>
                </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php
                endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
    function eliminar(id) {
        $('#' + id + ' input:first').attr('type', 'hidden');
        $('#' + id + ' input:first').attr('value', 'eliminado');
        $('#' + id + ' .col-md-10').append('<h5 class="alert alert-danger" style="margin-top: 0;padding: 10px;margin-bottom: 0;">Eliminado</h5>');
        $('#' + id + ' button').hide();
    }
</script>