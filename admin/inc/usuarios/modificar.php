<?php
$usuarios = new Clases\Usuarios();

$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');

$usuarios->set("cod", $cod);
$usuario = $usuarios->view();

if (isset($_POST["agregar"])) {
    $usuarios->set("cod", $usuario["cod"]);
    $usuarios->set("nombre", $funciones->antihack_mysqli(isset($_POST["nombre"]) ? $_POST["nombre"] : ''));
    $usuarios->set("apellido", $funciones->antihack_mysqli(isset($_POST["apellido"]) ? $_POST["apellido"] : ''));
    $usuarios->set("doc", $funciones->antihack_mysqli(isset($_POST["doc"]) ? $_POST["doc"] : ''));
    $usuarios->set("email", $funciones->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : ''));
    $usuarios->set("password", $funciones->antihack_mysqli(isset($_POST["password"]) ? $_POST["password"] : ''));
    $usuarios->set("postal", $funciones->antihack_mysqli(isset($_POST["postal"]) ? $_POST["postal"] : ''));
    $usuarios->set("direccion", $funciones->antihack_mysqli(isset($_POST["direccion"]) ? $_POST["direccion"] : ''));
    $usuarios->set("barrio", $funciones->antihack_mysqli(isset($_POST["barrio"]) ? $_POST["barrio"] : ''));
    $usuarios->set("localidad", $funciones->antihack_mysqli(isset($_POST["localidad"]) ? $_POST["localidad"] : ''));
    $usuarios->set("provincia", $funciones->antihack_mysqli(isset($_POST["provincia"]) ? $_POST["provincia"] : ''));
    $usuarios->set("pais", $funciones->antihack_mysqli(isset($_POST["pais"]) ? $_POST["pais"] : ''));
    $usuarios->set("telefono", $funciones->antihack_mysqli(isset($_POST["telefono"]) ? $_POST["telefono"] : ''));
    $usuarios->set("celular", $funciones->antihack_mysqli(isset($_POST["celular"]) ? $_POST["celular"] : ''));
    $usuarios->set("invitado", $funciones->antihack_mysqli(isset($_POST["invitado"]) ? $_POST["invitado"] : '0'));
    $usuarios->set("vendedor", $funciones->antihack_mysqli(isset($_POST["vendedor"]) ? $_POST["vendedor"] : '0'));
    $usuarios->set("plan", $funciones->antihack_mysqli(isset($_POST["plan"]) ? $_POST["plan"] : ''));
    $usuarios->set("fecha", $funciones->antihack_mysqli(isset($_POST["fecha"]) ? $_POST["fecha"] : date("Y-m-d")));

    $usuarios->edit();
    $funciones->headerMove(URL . "/index.php?op=usuarios");
}
?>

<div class="col-md-12 ">
    <h4>Usuarios</h4>
    <hr/>
    <form method="post" class="row">
        <label class="col-md-4">
            Nombre:<br/>
            <input type="text" name="nombre" value="<?= $usuario['nombre']; ?>"/>
        </label>
        <label class="col-md-4">
            Apellido:<br/>
            <input type="text" name="apellido" value="<?= $usuario['apellido']; ?>"/>
        </label>
        <label class="col-md-4">
            DNI/CUIT/CUIL:<Br/>
            <input type="text" name="doc" value="<?= $usuario['doc']; ?>"/>
        </label>
        <label class="col-md-4">
            Email:<br/>
            <input type="text" name="email" value="<?= $usuario['email']; ?>"/>
        </label>
        <label class="col-md-4">
            Contraseña:<br/>
            <input type="text" name="password" value="<?= $usuario['password']; ?>"/>
        </label>
        <label class="col-md-4">
            Código Postal:<br/>
            <input type="text" name="postal" value="<?= $usuario['postal']; ?>"/>
        </label>
        <label class="col-md-4">
            Dirección:<br/>
            <input type="text" name="direccion" value="<?= $usuario['direccion']; ?>"/>
        </label>
        <label class="col-md-4">
            Barrio:<br/>
            <input type="text" name="barrio" value="<?= $usuario['barrio']; ?>"/>
        </label>
        <label class="col-md-4">Provincia:<br/>
            <select name="provincia" id="provincia" required>
                <option value="" selected disabled>Provincia</option>
                <?php $funciones->provincias() ?>
            </select>
        </label>
        <label class="col-md-4">Localidad:<br/>
            <select name="localidad" id="localidad" required>
                <option value="" selected disabled>Localidad</option>
            </select>
        </label>
        <label class="col-md-4">
            Telefono:<br/>
            <input type="text" name="telefono" value="<?= $usuario['telefono']; ?>"/>
        </label>
        <label class="col-md-4">
            Celular:<br/>
            <input type="text" name="celular" value="<?= $usuario['celular']; ?>"/>
        </label>
        <label class="col-md-2">
            Vendedor:<br/>
            <select name="vendedor">
                <option selected disabled>Seleccionar</option>
                <option value="1" <?php if ($usuario['vendedor'] == 1) {
                    echo 'selected';
                } ?>>Si
                </option>
                <option value="0" <?php if ($usuario['vendedor'] == 0) {
                    echo 'selected';
                } ?>>No
                </option>
            </select>
        </label>
        <label class="col-md-2">
            Plan:<br/>
            <select name="plan">
                <option selected disabled>Seleccionar</option>
                <option value="1" <?php if ($usuario['plan'] == 1) {
                    echo 'selected';
                } ?>>Básico
                </option>
                <option value="2" <?php if ($usuario['plan'] == 2) {
                    echo 'selected';
                } ?>>Medio
                </option>
                <option value="3" <?php if ($usuario['plan'] == 3) {
                    echo 'selected';
                } ?>>Completo
                </option>
            </select>
        </label>
        <div class="clearfix"></div>
        <br/>
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Crear Usuarios"/>
        </div>
    </form>
</div>
