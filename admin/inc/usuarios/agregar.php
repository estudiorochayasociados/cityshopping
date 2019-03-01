<?php
$usuarios = new Clases\Usuarios();

if (isset($_POST["agregar"])) {
    $cod = substr(md5(uniqid(rand())), 0, 10);

    $usuarios->set("cod", $cod);
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
    $usuarios->set("fecha", $funciones->antihack_mysqli(isset($_POST["fecha"]) ? $_POST["fecha"] : date("Y-m-d")));

    $usuarios->add();

    $funciones->headerMove(URL . "/index.php?op=usuarios");
}
?>

<div class="col-md-12 ">
    <h4>
        Usuarios
    </h4>
    <hr/>
    <form method="post" class="row">
        <label class="col-md-4">
            Nombre:<br/>
            <input type="text" name="nombre" />
        </label>
        <label class="col-md-4">
            Apellido:<br/>
            <input type="text" name="apellido" />
        </label>
        <label class="col-md-4">
            DNI/CUIT/CUIL:<Br/>
            <input type="text" name="doc" />
        </label>
        <label class="col-md-4">
            Email:<br/>
            <input type="text" name="email" />
        </label>
        <label class="col-md-4">
            Contraseña:<br/>
            <input type="text" name="password" />
        </label>
        <label class="col-md-4">
            Código Postal:<br/>
            <input type="text" name="postal" />
        </label>
        <label class="col-md-4">
            Dirección:<br/>
            <input type="text" name="direccion" value="" />
        </label>
        <label class="col-md-4">
            Barrio:<br/>
            <input type="text" name="barrio" value="" />
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
            <input type="text" name="telefono" />
        </label>
        <label class="col-md-4">
            Celular:<br/>
            <input type="text" name="celular" />
        </label>
        <label class="col-md-2">
            Vendedor:<br/>
            <select name="vendedor">
                <option selected disabled>Seleccionar</option>
                <option value="1">Si</option>
                <option value="0">No</option>
            </select>
        </label>
        <div class="clearfix">
        </div><br/>
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Crear Usuarios" />
        </div>
    </form>
</div>
