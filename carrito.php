<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funcion = new Clases\PublicFunction();
$template->set("title", TITULO . " | Carrito");
$template->set("description", "Carrito");
$template->set("keywords", "Carrito");
$template->set("body", "cart-page");
$template->set("favicon", FAVICON);
$template->themeInit();
//Clases
$empresa = new Clases\Empresas();
$productos = new Clases\Productos();
$categorias = new Clases\Categorias;
$imagenes = new Clases\Imagenes;
$carrito = new Clases\Carrito();
$envios = new Clases\Envios();

$carro = $carrito->return();
$carroEnvio = $carrito->checkEnvio();
$countCarrito = count($carrito->return());

if ($countCarrito == 0) {
    $funcion->headerMove(URL . '/index');
}
?>
<!--================================
        START BREADCRUMB AREA
    =================================-->
<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?= URL ?>/index">Inicio</a>
                        </li>
                        <li class="active">
                            <a href="#">Carrito</a>
                        </li>
                    </ul>
                </div>
                <h1 class="page-title">Carrito</h1>
            </div>
            <!-- end /.col-md-12 -->
        </div>
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
</section>
<!--================================
    END BREADCRUMB AREA
=================================-->

<!--================================
        START DASHBOARD AREA
=================================-->
<section class="cart_area section--padding2 bgcolor">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Producto</th>
                                <th class="hidden-xs" scope="col">Precio</th>
                                <th class="hidden-xs" scope="col">Cantidad</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_GET["remover"])) {
                                $carrito->destroy();
                                $funcion->headerMove(URL . "/productos");
                            }

                            $i = 0;
                            $precio = 0;
                            foreach ($carro as $key => $carroItem) {
                                $precio += ($carroItem["precio"] * $carroItem["cantidad"]);
                                $opciones = @implode(" - ", $carroItem["opciones"]);
                                if ($carroItem["id"] == "Envio-Seleccion" || $carroItem["id"] == "Metodo-Pago") {
                                    $clase = "text-bold";
                                    $none = "hidden";
                                } else {
                                    $clase = '';
                                    $none = "";
                                }
                                $productos->set("cod", $carroItem['id']);
                                $pro = $productos->view();
                                $imagenes->set("cod", $pro['cod']);
                                $img = $imagenes->view();
                            ?>
                                <tr>
                                    <td scope="row">
                                        <a href="<?= URL ?>/carrito.php?remover=<?= $key ?>">
                                            <span class="lnr lnr-cross"></span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="media hidden-xs">
                                            <div class="media-body">
                                                <h6><?= mb_strtoupper($carroItem["titulo"]); ?></h6>
                                            </div>
                                        </div>
                                        <div class="d-md-none text-left">
                                            <?= mb_strtoupper($carroItem["titulo"]); ?>
                                            <p class="<?= $none ?>">Precio: <?= "$" . number_format($carroItem["precio"], 2, ",", "."); ?></p>
                                            <p class="<?= $none ?>">Cantidad: <?= $carroItem["cantidad"]; ?></p>
                                        </div>
                                    </td>
                                    <td class="hidden-xs">
                                        <p class="<?= $none ?>"><?= "$" . number_format($carroItem["precio"], 2, ",", "."); ?></p>
                                    </td>
                                    <td class="hidden-xs">
                                        <p class="<?= $none ?>"><?= $carroItem["cantidad"]; ?></p>
                                    </td>

                                    <td>
                                        <p><?php
                                            if ($carroItem["precio"] != 0) {
                                                echo "$" . number_format(($carroItem["precio"] * $carroItem["cantidad"]), 2, ",", ".");
                                            } else {
                                                if ($carroItem['id'] == "Metodo-Pago") {
                                                    echo "";
                                                } else {
                                                    echo "";
                                                }
                                            }
                                            ?>
                                        </p>
                                    </td>
                                </tr>
                            <?php
                                $i++;
                            }
                            ?>
                            <tr>
                                <td scope="row">
                                </td>
                                <td>
                                    <div class="media hidden-xs">
                                    </div>
                                    <div class="d-md-none text-left">
                                    </div>
                                </td>
                                <td class="hidden-xs"></td>
                                <td class="hidden-xs"></td>

                                <td> $<?= number_format($precio, 2, ",", "."); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="<?= URL . '/pagar' ?>">
                    <button style="width: 100%;" class="btn btn-lg btn-success">Finalizar pedido</button>
                </a>
            </div>
            <!-- end .row -->
        </div>
        <!-- end .container -->
</section>
<!--================================
        END DASHBOARD AREA
=================================-->
<?php
$template->themeEnd();
?>