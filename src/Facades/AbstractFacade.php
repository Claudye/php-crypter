<?php 
namespace Simplecode\Facades;

use Simplecode\DI\Mediator;

abstract class AbstractFacade{

    protected static $instance ;

    protected static function call(string $name, $arguments){
      $container = Mediator::mediator();
      return $container->call(static::$instance,$name, $arguments) ; 
    }
    
}