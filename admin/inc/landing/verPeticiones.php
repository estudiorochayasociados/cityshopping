<?php
$landing = new Clases\Landing();
$landingRequests = new Clases\LandingRequests();
$cod = isset($_GET["cod"]) ? $_GET["cod"] : '0';
$filter = array();
$landingRequestsArray = $landingRequests->list(["landing_cod = '$cod'"]);
$landing->set("cod", $cod);
$landingData = $landing->view();
$landingRequests->set("landingCod", $cod);

$winner = $landingRequests->searchWinner();
if (isset($_POST["winner"])) {
    $ganador = $landingRequests->selectWinner();
    $landingRequests->set("id", $ganador['id']);
    $landingRequests->updateWinner();
    $funciones->headerMove(URL . '/index.php?op=landing&accion=verPeticiones&cod=' . $cod);
}
if (isset($_POST["reset"])) {
    $landingRequests->resetWinner();
    $ganador = $landingRequests->selectWinner();
    $landingRequests->set("id", $ganador['id']);
    $landingRequests->updateWinner();
    $funciones->headerMove(URL . '/index.php?op=landing&accion=verPeticiones&cod=' . $cod);
}
?>
<div class="mt-20">
    <div class="col-lg-12 col-md-12">
        <form method="post">
            <h4>
                Peticiones
                <?php
                if (!empty($winner)&&!empty($landingRequestsArray)) {
                    ?>
                    <button name="reset" type="submit" class="btn btn-warning pull-right ml-10">
                        REINICIAR GANADOR
                    </button>
                    <?php
                } else {
                    ?>
                    <button name="winner" type="submit" class="btn btn-success pull-right">
                        SELECCIONAR GANADOR
                    </button>
                    <?php
                }
                ?>
            </h4>
        </form>
        <br>
        <?php
        if (!empty($winner)) {
            ?>
            <div class="alert alert-success">
                <h2>Ganador/a:</h2><br>
                <b>Nombre: </b><?= $winner['nombre'] . ' ', $winner['apellido'] ?><br>
                <b>Email: </b><?= $winner['email'] ?><br>
                <b>Celular: </b><?= $winner['celular'] ?><br>
                <b>DNI: </b><?= $winner['dni'] ?>
            </div>
            <?php
        }
        ?>
        <hr/>
        <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
        <hr/>
        <table class="table  table-bordered  ">
            <thead>
            <th>
                Landing
            </th>
            <th>
                Nombre
            </th>
            <th>
                Apellido
            </th>
            <th>
                Celular
            </th>
            <th>
                Email
            </th>
            <th>
                Dni
            </th>
            <th>
                Fecha
            </th>
            </thead>
            <tbody>
            <?php
            if (is_array($landingRequestsArray)) {
                for ($i = 0; $i < count($landingRequestsArray); $i++) {
                    echo "<tr>";
                    echo "<td>" . strtoupper($landingData["titulo"]) . "</td>";
                    echo "<td>" . strtoupper($landingRequestsArray[$i]["nombre"]) . "</td>";
                    echo "<td>" . strtoupper($landingRequestsArray[$i]["apellido"]) . "</td>";
                    echo "<td>" . strtoupper($landingRequestsArray[$i]["celular"]) . "</td>";
                    echo "<td>" . strtoupper($landingRequestsArray[$i]["email"]) . "</td>";
                    echo "<td>" . strtoupper($landingRequestsArray[$i]["dni"]) . "</td>";
                    echo "<td>" . strtoupper($landingRequestsArray[$i]["fecha"]) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
