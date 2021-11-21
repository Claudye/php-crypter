# PHP Crypter
Secure the data of your sites by encrypting them. They will be decrypted only in your applications

## How to use ?
  
You just have to include the file `vendor/autoload.php` in the file (s) you want to use Encrypt
Then to encrypt a data you use `Encryption::encrypt(string $data, string $cipher_method,string $token)` and to decrypt later you use the method : `Encryption::decrypt()`
 * Les deux méthodes prennent les mêmes arguments (3 arguments)
   1- Le texte à inclure
   2- La méthode de cryptage (AES-128-CBC est choisie par défaut)
   3- Le token ou le mot de passe
 * Vous pouvez passer le texte à crypter uniquement à ces deux méthodes mais dans ce cas rassurez-vous d'avoir démarré la session
   avec session_start() ou bien avec La façade Sessison::start() qui est venue avec ce php-crypter.
#### Exemple
 <pre> <code>
   use Simplecode\Facades\Session;
   use Simplecode\Encryption\Encryption;
   Session::start();
    require 'vendor/autoload.php'; <br>
    // Encrypt the text "The only limit of a developer is his imagination" <br> <br>
    $encrypt=Encryption::encrypt("The only limit of a developer is his imagination"); <br>
    //You store the encrypted data in a file or in a database <br>
    //After you want to use it again on your site <br>
    //Get your text: $ encrypt and then decrypt it <br>
    $decrypt = Encryption::encrypt($encrypt); <br>
   //Et c'est tout ! <br>
</code> </pre>
## Information
The encryption method used by default is : AES-128-CBC
[Find all the methods here](https://www.php.net/manual/fr/function.openssl-get-cipher-methods.php)