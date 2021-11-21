<?php
namespace Simplecode\Facades;

use Simplecode\Session\Session as SessionSession;

/**
 * @method static string previousUrl() Return _previousUrl
 * @method static void setPreviousUrl(string $url)
 * @method static void set(string $key, $value) Set value to session
 * @method static mixed get(string $key) get value from session
 * @method static mixed remove(string $key) Remove an item from the session, returning its value. 
 * @method static string getId() Get the current session ID
 * @method static void regenerate() Get the current session ID
 * @method static string token() Get the current token
 * 
 */
class Session{

    /**
     * Session instance
     *
     * @var SessionSession
     */
    protected static $instance;

    public static function __callStatic($name, $arguments)
    {
        $session= static::getInstance();
        return $session->{$name}(...$arguments);
    }
    /**
     * Return session instance
     *
     * @return SessionSession
     */
    private static function getInstance(){
        return new SessionSession;
    }
}