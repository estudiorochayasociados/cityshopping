<?php
$pedidos = new Clases\Pedidos();
$usuario = new Clases\Usuarios();
$estado  = isset($_GET["estado"]) ? $_GET["estado"] : '';
$filter  = '';
if ($estado != '') {
    $filter = array("estado = $estado");
}
$data = $pedidos->list($filter,"","");

$filterPedidosAgrupados = array("cod != '' GROUP BY cod");
$pedidosArrayAgrupados = $pedidos->list($filterPedidosAgrupados, "", "");
$pedidosArraySinAgrupar = $pedidos->list("", "", "");

?>
<div class="mt-20">
    <div class="col-lg-12 col-md-12">
        <h4>Pedidos</h4>
        <hr/>
    </div>
</div>


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
                            $usuario->set("cod", $value["usuario"]);
                            $usuarioData = $usuario->view();
                            ?>
                            <div class="card">
                                <a data-toggle="collapse" href="#collapse<?= $value["cod"] ?>" aria-expanded="false" aria-controls="collapse<?= $value["cod"] ?>" class="collapsed color_a">
                                    <div class="card-header bg-info" role="tab" id="heading">
                                        <span style="color:#fff" class="text-uppercase">Pedido <?= $value["cod"] ?></span>
                                        <span class="hidden-xs hidden-sm blanco"  style="color:#fff">- Fecha <?= $fecha ?></span>
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
                                                        <td><b>TOTAL DEL PEDIDO</b></td>
                                                        <td class="hidden-xs"></td>
                                                        <td class="hidden-xs"></td>
                                                        <td><b>$<?= $precioTotal ?></b></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped table-hover hidden-xs">
                                                    <thead class="thead-dark">
                                                    <th width="40%">
                                                        Usuario
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
                                                            <?= $usuarioData["nombre"] . ' ' . $usuarioData["apellido"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $usuarioData["direccion"] ?> • <?= $usuarioData["localidad"] ?> • <?= $usuarioData["provincia"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $usuarioData["telefono"] ?>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <p class="visible-xs">
                                                    <b>Usuario: </b><?= $usuarioData["nombre"] ?> <br>
                                                    <b>Dirección: </b> <?= $usuarioData["direccion"] ?>, <?= $usuarioData["localidad"] ?>, <?= $usuarioData["provincia"] ?><br>
                                                    <b>Teléfono: </b> <?= $usuarioData["telefono"] ?>
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
                                        <hr>
                                        <b>CAMBIAR ESTADO: </b><br>
                                        <a href="<?= CANONICAL ?>&estado=1&cod=<?= $value['cod'] ?>" class="btn btn-warning">Pendiente</a>
                                        <a href="<?= CANONICAL ?>&estado=2&cod=<?= $value['cod'] ?>" class="btn btn-success">Aprobado</a>
                                        <a href="<?= CANONICAL ?>&estado=3&cod=<?= $value['cod'] ?>" class="btn btn-info">Enviado</a>
                                        <a href="<?= CANONICAL ?>&estado=4&cod=<?= $value['cod'] ?>" class="btn btn-danger">Rechazado</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
    </div>
</div>
<?php
if (isset($_GET["borrar"])) {
    $pedidos->set("id", $funciones->antihack_mysqli(isset($_GET["borrar"]) ? $_GET["borrar"] : ''));
    $pedidos->delete();
    $funciones->headerMove(URL . "/index.php?op=pedidos");
}
?>

