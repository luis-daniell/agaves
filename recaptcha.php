<?php

include("keys.php");

if($_POST['google-response-token'])
{
    $googleToken = $_POST['google-response-token'];

    

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => SECRET_KEY, 'response' => $googleToken)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $arrResponse = json_decode($response, true);

    $name = $_POST['nombre'];
      $email = $_POST['correo'];
      $phone = $_POST['telefono'];
      $message = $_POST['mensaje']; 

// Verifica el correcto formato de email

  
    if($arrResponse['success'] && ($arrResponse['score'] && $arrResponse['score'] > 0.5))
    {

      //datos para el correo
      $destinatario = "contacto@entreagaves.mx";
      $asunto = "Contacto de Entre Agaves";

      $content="De: $name \n\nTelefono: $phone \n\nEmail: $email \n\nMensaje: $message";
      $mailheader = "From: $email \r\n";

      mail($destinatario, $asunto, $content, $mailheader) or die("Error al enviar!");
      
      echo "<div style='background-color: rgb(241 245 249); margin-top: 10px; width: 75%;'><p style ='color: green; font-weight: 400;'>El correo electrónico se ha enviado exitosamente</p> </div>";
      
    }

    else
    {
      echo "<div style='background-color:  rgb(241 245 249); margin-top: 10px; width: 75%;'><p style ='color: red; font-weight: 400;'>Error! No se pudo enviar el correo electrónico</p> </div>";
      
  }

}

?>
