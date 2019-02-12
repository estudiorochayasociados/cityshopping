<?php
$pedidos = new Clases\Pedidos();
$estado  = isset($_GET["estado"]) ? $_GET["estado"] : '';
$filter  = '';
if ($estado != '') {
    $filter = array("estado = $estado");
}
$data = $pedidos->list($filter,"","");
?>
<div class="mt-20">
    <div class="col-lg-12 col-md-12">
        <h4>
            Pedidos
            <div class='col-md-2 pull-right'>
                <form method="get">
                    <input type="hidden" name="op" value="pedidos" />
                    <input type="hidden" name="accion" value="ver" />
                    <select name="estado"  onchange="this.form.submit()">
                        <option value="4" <?php if ($estado == 4) {echo "selected";}?>>Enviado</option>
                        <option value="3" <?php if ($estado == 3) {echo "selected";}?>>Rechazo</option>
                        <option value="2" <?php if ($estado == 2) {echo "selected";}?>>Aprobado</option>
                        <option value="1" <?php if ($estado == 1) {echo "selected";}?>>Pendiente</option>
                        <option value="0" <?php if ($estado == 0) {echo "selected";}?>>Carrito no cerrado</option>
                    </select>
                </form>
            </div>
        </h4>
        <hr/>
        <?php
if (is_array($data)) {
    foreach ($data as $pedido) {
        echo '<p>';
        echo '<a class="btn btn-info btn-block text-left" data-toggle="collapse" href="#collapseExample' . $pedido["id"] . '" role="button" aria-expanded="false" aria-controls="collapseExample' . $pedido["id"] . '"> ORDEN DE COMPRA N°: ' . $pedido["cod"] . ' <span class="pull-right">' . $pedido["fecha"] . '</span></a>';
        echo '<div class="collapse" id="collapseExample' . $pedido["id"] . '">';
        echo '<div class="card card-body">';
        echo $pedido["pedido"];
        echo $pedido["detalle"];
        echo '</div>';
        echo '</div>';
        echo '</p>';
    }
}
?>
    </div>
</div>
<?php
if (isset($_GET["borrar"])) {
    $pedidos->set("id", $funciones->antihack_mysqli(isset($_GET["borrar"]) ? $_GET["borrar"] : ''));
    $pedidos->delete();
    $funciones->headerMove(URL . "/index.php?op=pedidos");
}
?>

