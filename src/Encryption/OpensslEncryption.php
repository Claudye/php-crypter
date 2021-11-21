<?php

namespace Simplecode\Encryption;

use Simplecode\Facades\Session;

/**
 * Encrypt data class
 * @author Claude Fassinou <dev.claudy@gmail.com>
 */
class OpensslEncryption
{

    /**
     * encrypt
     * 
     * @var string
     */
    protected $encrypt;
    /**
     *  Data to encrypt
     * @var string
     */
    protected $data;

    /**
     * Default algo  method
     * @var string
     */
    protected $algo = "AES-128-CBC";

    /**
     * Le token
     * @var string
     */
    protected $token;

    /**
     * Disjonction au niveau des bits des drapeaux OPENSSL_RAW_DATA et OPENSSL_ZERO_PADDING.
     * @var int
     */
    protected $options = OPENSSL_RAW_DATA;

    /**
     *  Pseudo random string of byte.
     * @var string
     */
    protected $inivect;

    /**
     * Le tag d'authentification passé par référence
     * @var string
     */
    protected $tag = null;

    /**
     * Données additionnelles d'authentification.
     * @var string
     */
    protected $aad;


    /**
     * La longueur du tag d'authentification
     * @var string
     */
    protected $tag_length = 16;

    /**
     *  Available cipher methods
     * @var array
     */
    protected $cipher_algo = [];

    public function __construct()
    {
        $this->cipher_algo = openssl_get_cipher_methods();

        $this->inivect($this->algo);
        $this->token = Session::token();

    }


    /**
     * Set data to encrypt
     *
     * @param  string  $data 
     *
     * @return  $this
     */
    public function data(string $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Encrypte data
     *
     * @return string
     */
    public function encrypt()
    {
        $this->encrypt = base64_encode($this->stronglyDataEncrypted());
        return $this->encrypt;
    }

    /**
     * Décrypte les données
     *
     * @param string $ciphertext
     * @return string!false
     */
    public function decrypt(string $stronglyDataEncrypted = '')
    {
       
        $c = base64_decode($stronglyDataEncrypted);
       
        $pseudoRandomBytesString = substr($c, 0, $this->ivlen());
       
        $hmac = substr($c, $this->ivlen(), $sha2len = 32);
        $ciphertext_raw = substr($c, $this->ivlen() + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $this->algo, $this->token, $this->options, $pseudoRandomBytesString);
        //hasmac concern decrypt data
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $this->token, $as_binary = true);
        if (hash_equals($hmac, $calcmac))
        {
            return $original_plaintext;
        }
        return false;
    }

    /**
     *  Generate a pseudo-random string of bytes.
     *
     * @param  string  $inivect_algo pseudo-random string
     *
     * @return  self
     */
    public function inivect(string $inivect_algo)
    {
        //random binary string
        $this->inivect = openssl_random_pseudo_bytes($this->ivlen($inivect_algo));

        return $this;
    }

    /**
     * Get the value of encrypt
     * @var string
     */
    public function getEncrypt()
    {
        return $this->encrypt;
    }

    /**
     * Set la méthode de cipher
     *
     * @param  string  $algo  La méthode de cipher
     *
     * @return  self
     */
    public function algo(string $algo)
    {
        $this->algo = $algo;

        return $this;
    }
    /**
     * Set token for encryption
     *
     * @param string $token
     * @return $this
     */
    public function token(string $token){
        $this->token = $token;

        return $this;
    }

    /**
     * Cipher algo iv length
     *
     * @param string|null $algo
     * @return integer
     */
    private function ivlen(string $algo =null):int{
        return openssl_cipher_iv_length($algo ?? $this->algo);
    }

    /**
     * Encrypt data with openssl_encryp methode
     *  returns a raw or base64 encoded string
     * @return string|false 
     */
    private function dataEncrypWithOpenssEncrypt(){
        return openssl_encrypt($this->data, $this->algo, (string)$this->token, $this->options, $this->inivect);
    }
    /**
     * Return pseudo random string
     *
     * @return string
     */
    private function pseudoRandomBytesString(){
        if ($this->inivect==null) {
           return openssl_random_pseudo_bytes($this->ivlen());
        }
        return $this->inivect;
    }
    /**
     * // Generate a hash key value using HMAC method
     *
     * @return string|false
     */
    private function hasMac(){
        return hash_hmac('sha256', $this->dataEncrypWithOpenssEncrypt(), (string)$this->token, $as_binary = true);
    }

    /**
     * Return Strongly encrypted data
     *
     * @return string
     */
    private function stronglyDataEncrypted(){
        return $this->pseudoRandomBytesString() . $this->hasMac() . $this->dataEncrypWithOpenssEncrypt();
    }
}
