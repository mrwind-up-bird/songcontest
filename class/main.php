<?php

/**
 * main class handles everything belongs to the base 
 * 
 * @author oli
 * 
 */
include('/class/contest.php');


abstract class aContest implements iContest {
    
    private static $_instance = [];
    
    final public static function getInstance() : iContest {
        self::$_instances[static::class] = self::$_instances[static::class] ?? new static();
        return self::$_instances[static::class];
         
    }
}