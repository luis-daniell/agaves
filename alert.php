<?php 
// Ingresa tu clave secreta.....
define("RECAPTCHA_V3_SECRET_KEY", '6LdFjQIfAAAAAFX6Zv8L91Z66XoYnsJhoojPWa1y');

$token = $_POST['token'];
$action = $_POST['action'];
 
// call curl to POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$arrResponse = json_decode($response, true);
 
// verificar la respuesta
if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
    // Si entra aqui, es un humano, puedes procesar el formulario
	$name = $_POST['nombre'];
    $email = $_POST['correo'];
    $phone = $_POST['telefono'];
    $message = $_POST['mensaje']; 

    //datos para el correo
    $destinatario = "contacto@entreagaves.mx";
    $asunto = "Contacto de Entre Agaves";

    $content="De: $name \n\nTelefono: $phone \n\nEmail: $email \n\nMensaje: $message";
    $mailheader = "From: $email \r\n";

    //enviando mensaje
    mail($destinatario, $asunto, $content, $mailheader) or die("Error!");
    
    header("Refresh: 1; url=index.html");
    /*echo '<script>alert("Mensaje envia exitosamente")</script>'; */
     echo "Mensaje enviado exitosamente"; 
} else {
    // Si entra aqui, es un robot....
	echo "Lo siento, parece que eres un Robot";
}
?>