# PHP Crypter
Secure the data of your websites by encrypting them. They will be decrypted only in your applications with your secret key

# How to install ?

  ## With composer

  * Firstly you need composer 
  * Run the command `composer require claudye/php-crypter:dev-master`

  ## Clone or download from github
  * Clone or download from  [github](https://github.com/Claudye/php-crypter)
  * Be sure you have [composer](https://getcomposer.org/) installed
  * Goto the root of your project and open there a shell (terminal)
  * Run `composer install`
  
# Usage
  When php crypter is successful installed, please import the Encryption class like :

  `use PHPCrypter\Encryption\Encryption;`

  * To encrypt a data, you use `Encryption::encrypt(string $text, string $algo_method="AES-128-CBC", string $token=null)`
  This method requires the data to be encrypted, other arguments are optional. It returns encrypted data that you can store or write somewhere for reuse
  * To decrypt the encrypted information later you can use the method
  `Encryption::decrypt(string $data_encrypted)`
  This method will use the generated key for you to decrypt the data which was encrypted. This key must be secret

# Example
 <pre>
 <code>

  use PHPCrypter\Encryption\Encryption;
  //You can define your key any where you want 

  //define("ENC_TOKEN_PATH", "your/dir/example");

  require 'vendor/autoload.php';
  // Encrypt the text "The only limit of a developer is his imagination" <br> <br>
  $encrypt = Encryption::encrypt("The only limit of a developer is his imagination");

  //You store the encrypted data in a file or in a database, or any where you can reuse it <br>
  //After you want to use it again on your site <br>
  //Get your text: $encrypt and then decrypt it <br>
  $decrypt = Encryption::decrypt($encrypt); 

  //All right ! <br>

</code>
</pre>

# Change encryption key path!

 It is possible to change the encryption key path (file or directory) where you want to store the secret key! It's a good idea to choose a very secure path

# Information
The encryption method used by default is : AES-128-CBC
[Find all the methods here](https://www.php.net/manual/fr/function.openssl-get-cipher-methods.php)

### Attention!
**When your data is encrypted with a key, only this key can decrypt it, so be careful not to lose your keys or change your keys carelessly.**