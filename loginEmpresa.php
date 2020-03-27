<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$usuarios = new Clases\Usuarios();

//Clases
//Productos
$cod = isset($_POST["cod"]) ? $_POST["cod"] : '';
$email = isset($_POST["email"]) ? $_POST["email"] : '';
$password = isset($_POST["password"]) ? $_POST["password"] : '';

$usuarios->set("cod", $cod);
$usuarios->set("email", $email);
$usuarios->set("password", $password);

$template->set("title", '');
$template->set("description", '');
$template->set("keywords", '');
$template->set("favicon", '');

$template->themeInit();

$usuarios->login();
$funciones->headerMove(URL);

?>

<?php
$template->themeEnd();
?>