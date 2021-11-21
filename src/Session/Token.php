<?php
namespace Simplecode\Session;

class Token{

    /**
     * path
     * @var string
     */
    protected $key;
    /**
     * @var string
     */
    protected $token;

    public function __construct(string $key)
    {
        $this->key = $key ;
        $this->generate() ;
    }
    public function generate(){
        
       $this->token=base64_encode($this->key);
       return $this ;
    }

    /**
     * Get the value of token
     *
     * @return  string
     */ 
    public function getToken():string
    {
        return $this->token;
    }

    /**
     * Retourne la chaine de token
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getToken();
    }

    /**
     * Check if token matched
     *
     * @param string $encode
     * @return boolean
     */
    public function tokenMatched(string $encode):bool{
        return base64_decode($encode)==$this->key ? true : false ;
    }
}