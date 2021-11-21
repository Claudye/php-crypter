# Crypter
Secure the data of your sites by encrypting them. They will be decrypted only in your applications

## Utilisation
You just have to include the file `vendor/autoload.php` in the file (s) you want to use Encrypt
Then to encrypt a data you use `Encryption::encrypt(string $data, string $cipher_method,string $token)` and to decrypt later you use the method : `Encryption::decrypt()`
#### Exemple
<code><?php <br>
    use Simplecode\Encryption\Encryption; <br>
    require 'vendor/autoload.php'; <br>
    //Crypter le texte "La seule limite d'un développeur c'est son imagination" <br>
    $encrypt=Encryption::encrypt("La seule limite d'un développeur c'est son imagination"); <br>

    //Vous stcokez dans un fichier ou dans une base la donnée encrypté <br>
    //Après vous souhaitez l'utiliser encore sur votre site <br>
    //Récupérez votre texte : $encrypt et puis décrypter le <br>
    $decrypt = Encryption::encrypt($encrypt); <br>

   //Et c'est tout ! <br>
</code>
## Information
La méthode de cryptage utilisée par défaut est : AES-128-CBC
[Retrouvez toutes les méthodes ici](https://www.php.net/manual/fr/function.openssl-get-cipher-methods.php)