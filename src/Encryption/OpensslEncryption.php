<?php

/**
 * 
 * The construction of this class is entirely inspired by the documentation of php itself.
 *  References are at this link: https://www.php.net/manual/fr/function.openssl-encrypt.php
 * 
 */

namespace PHPCrypter\Encryption;

use PHPCrypter\Token;

/**
 * Encrypt data class
 * 
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * 
 * @license MIT
 */
class OpensslEncryption
{

    /**
     * Encrypted data
     * 
     * @var string
     */
    protected $encrypt;
    /**
     *  Data to  be encrypted
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
     *  Bitwise disjunction of the OPENSSL_RAW_DATA and OPENSSL_ZERO_PADDING flags.
     * @var int
     */
    protected $options = OPENSSL_RAW_DATA;

    /**
     *  Pseudo random string of byte.
     * @var string
     */
    protected $inivect;

    /**
     * The authentication tag passed by reference
     * @var string
     */
    protected $tag = null;

    /**
     * Additional authentication data.
     * @var string
     */
    protected $aad;


    /**
     * The length of the authentication tag
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
        $this->token = (string) Token::token();
    }


    /**
     * Set data to be encrypted
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
     * Create and return encrypted data
     *
     * @return string
     */
    public function encrypt()
    {
        $this->encrypt = base64_encode($this->stronglyDataEncrypted());
        return $this->encrypt;
    }

    /**
     * Decrypt previously encrypted data
     *
     * @param string $ciphertext
     * @return string|false
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
        if (hash_equals($hmac, $calcmac)) {
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
     * Set the cipher method
     *
     * @param  string  $algo  the cipher method
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
    public function token($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Cipher algo iv length
     *
     * @param string|null $algo
     * @return integer
     */
    private function ivlen(string $algo = null)
    {
        return openssl_cipher_iv_length($algo ?? $this->algo);
    }

    /**
     * Encrypt data with openssl_encryp methode
     *  returns a raw or base64 encoded string
     * @return string|false 
     */
    private function dataEncrypWithOpenssEncrypt()
    {
        return openssl_encrypt($this->data, $this->algo, $this->token, $this->options, $this->inivect);
    }
    /**
     * Return pseudo random string
     *
     * @return string
     */
    private function pseudoRandomBytesString()
    {
        if ($this->inivect == null) {
            return openssl_random_pseudo_bytes($this->ivlen());
        }
        return $this->inivect;
    }
    /**
     * // Generate a hash key value using HMAC method
     *
     * @return string|false
     */
    private function hasMac()
    {
        return hash_hmac('sha256', $this->dataEncrypWithOpenssEncrypt(), $this->token, $as_binary = true);
    }

    /**
     * Return Strongly encrypted data
     *
     * @return string
     */
    private function stronglyDataEncrypted()
    {
        return $this->pseudoRandomBytesString() . $this->hasMac() . $this->dataEncrypWithOpenssEncrypt();
    }
}
