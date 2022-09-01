<?php
namespace PHPCrypter\Encryption;

use PHPCrypter\Encryption\OpensslEncryption;
/**
 * Facade for encrypting data
 * @author Claude Fassinou <dev.claudy@gmail.com>
 */
class Encryption{
    

    /**
     * Encypt a data given, with $algo_method (algorithm method given)
     *
     * @param string $data Data to encrypt
     * @param string $algo_method Algorithm metho for encrypting
     * @param string|null $token Token or encryption key
     * @return string|null
     */
    public static function encrypt($data, $algo_method="AES-128-CBC",$token=null){
        $openssl = static::openssl();
        $openssl->algo($algo_method);
        if (isset($token)) {
            $openssl->token($token);
        }
        $openssl->data($data);
        $openssl->encrypt();
        return  $openssl->getEncrypt();
        
        
    }

    /**
     * Decrypt a encrypted data
     *
     * @param string $encryptText
     * @return string|false
     */
    public static function decrypt($encryptText){
        $openssl = static::openssl();
        return $openssl->decrypt($encryptText);
    }

    /**
     * Return an instance of OpensslEncryption
     *
     * @return OpensslEncryption
     */
    private static function openssl(){
        return new OpensslEncryption;
    }

}