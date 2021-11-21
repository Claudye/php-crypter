<?php
namespace Simplecode\Session;

use Simplecode\Contracts\SessionInterface;

class Session implements SessionInterface{

    
    public function regenerate($destroy = false)
    {
        $_SESSION= array();
        if ($destroy) {
            session_destroy();
        }

        return $this->start();
        
    }
    public function token()
    {
        $token = new Token($this->getId());
        return $token->getToken();
    }
    public function put($key, $value = null)
    {
        if (is_string($key) && strlen($key)>1) {
            $_SESSION[$key]= $value;
        }

        if (is_array($key)) {
           $_SESSION= array_merge($_SESSION,$key);
        }
    }
    public function pull($key, $default = null)
    {
        
    }
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }
    }
    public function has($key)
    {
        if ($this->exists($key)) {
            if (is_array($key)) {
                for ($i=0; $i < count($key); $i++) { 
                    if (is_null($_SESSION[$key[$i]])) return false; 
                }
                return true;
            }
            
            return !is_null($_SESSION[$key]);
         }
    }
    public function remove($key)
    {
        if ($this->has($key)) {
           unset($_SESSION[$key]);
        }

        return;
    }
    /**
     * @inheritDoc
     *
     */
    public function exists($key)
    {
        return isset($_SESSION[$key]);
    }
    /**
     * Return all section values
     *
     * @return array
     */
    public function all()
    {
        return $_SESSION;
    }
    public function save()
    {
        
    }
    public function getId()
    {
        return session_id();
    }

    public function getName()
    {
        
    }

    /**
     * @inheritDoc
     *
     * @return boolean
     */
    public function isStarted():bool
    {
        if ( php_sapi_name() !== 'cli' ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        }
        return FALSE;
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function start()
    {
        if (!$this->isStarted()) {
           return session_start();
        }

        return FALSE;
    }

    public function setName($name)
    {
        
    }

    public function setId($id)
    {
        
    }

    public function flush()
    {
        
    }
    public function regenerateToken()
    {
        $this->regenerate();
    }

    public function invalidate()
    {
        
    }

    public function migrate($destroy = false)
    {
        
    }
    /**
     * Return _previousUrl
     *
     * @return string
     */
    public function previousUrl(){
        return array_key_exists("_previousUrl",$_SESSION) ? $_SESSION['_previousUrl'] : '';
    }
    /**
     * Set previous url
     *
     * @param string $url
     * @return void
     */
    public function setPreviousUrl($url)
    {
        $_SESSION['_previousUrl'] = $url ;
    }

    public function forget($keys)
    {
        
    }
    /**
     * Set value to session
     * @return void
     */
    public function set(string $name, $value){
        $_SESSION [$name] = $value;
    }
}