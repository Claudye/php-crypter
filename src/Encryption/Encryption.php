<?php
namespace Simplecode\Encryption;

use Simplecode\Encryption\OpensslEncryption;
/**
 * Facede for encrypting data
 * @author Claude Fassinou <dev.claudy@gmail.com>
 */
class Encryption{
    

    /**
     * Encypt a data
     *
     * @param string $text
     * @return  string|null
     */
    public static function encrypt(string $text, string $algo_method="AES-128-CBC", string $token=null):?string{
        $openssl = static::openssl();
        $openssl->algo($algo_method);
        if (isset($token)) {
            $openssl->token($token);
        }
        $openssl->data($text);
        $openssl->encrypt();
        return  $openssl->getEncrypt();
        
        
    }

    /**
     * Decrypt a encryp data
     *
     * @param string $encryptText
     * @return string|false
     */
    public static function decrypt(string $encryptText){
        $openssl = static::openssl();
        return $openssl->decrypt($encryptText);
    }

    /**
     * Return an instance of OpensslEncryption
     *
     * @return OpensslEncryption
     */
    private static function openssl():OpensslEncryption{
        return new OpensslEncryption;
    }

}