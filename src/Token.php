<?php

namespace PHPCrypter;

use PHPCrypter\Contracts\KeyNotFoundExceptioninterface;
/**
 * Generate the token
 */
class Token
{
    /**
     * path
     * @var string
     */
    protected $key;
    /**
     * @var string
     */
    protected $token;

    /**
     * The path where key will be stored
     *
     * @var string
     */
    protected $token_path = __DIR__;

    public function __construct()
    {
        $this->generate();
    }

    /**
     * Generate encryption token
     *
     * @return self
     */
    public function generate()
    {
        $this->setKeyPath()->createKey();
        $this->token = base64_encode($this->key);
        return $this;
    }

    /**
     * Get the value of token
     *
     * @return  string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Return the token
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getToken();
    }

    /**
     * Return a Token class instance
     *
     * @return self
     */
    public static function token()
    {
        return new static;
    }

    /**
     * Set key path where key will be stored
     *
     * @return self
     */
    private function setKeyPath()
    {
        if (defined('ENC_TOKEN_PATH')) {
            if (!file_exists($token_path = constant('ENC_TOKEN_PATH'))) {
                throw new KeyNotFoundExceptioninterface("Failed to open stream: No such file or directory, $token_path", 1);
            }
            $this->token_path = $token_path;
        }

        return $this;
    }

    /**
     * Create key
     *
     * @return void
     */
    private function createKey()
    {
        /**
         * Create token key
         */
        $createFileKey =  function ($randomString, $filename) {
            $key = "";
            //Get key if exist
            if (is_file($filename)) {
                $key = file_get_contents($filename);
            }
            //Create key if not exist
            if (strlen($key) < 32) {
                file_put_contents($filename, base64_encode($randomString));
            }
        };

        $count = 64;
        $randomString = bin2hex(random_bytes($count));

        $randomString;
        //File path
        $this->token_path = is_file($this->token_path) ? $this->token_path : rtrim($this->token_path, '/') . "/enc_key.txt";

        $createFileKey($randomString, $this->token_path);
        //Get key
        $this->key = file_get_contents($this->token_path);
    }
}
