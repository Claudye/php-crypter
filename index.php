<?php
    use Simplecode\Encryption\Encryption;
    require 'vendor/autoload.php';
    session_start();
    // Encrypt the text "The only limit of a developer is his imagination" <br> <br>
    $encrypt=Encryption::encrypt("The only limit of a developer is his imagination");

    //You store the encrypted data in a file or in a database <br>
    //After you want to use it again on your site <br>
    //Get your text: $ encrypt and then decrypt it <br>
    $decrypt = Encryption::decrypt($encrypt); 

   //Et c'est tout ! <br>