<?php

    /**
     * innogames song contest
     * 
     * @author oli
     */

    /**
     * load config
     * 
     * treat conf.php as wrapper for storing config data everywhere, just asure the syntax is correct
     */
    require_once 'conf.php';
    
    /**
     * load class stuff
     * 
     * @todo autoloader
     */
    include('class/contestant.php');
    include('class/judge.php');
    include('class/contest.php');
    
    
    class game {
        
        public function startGame() {
            try {
                $c = Contest::getInstance();
                $c->setConfig($config);    
            } catch (Exception $ex) {
                print_r($ex->getMessage());
                print_r($ex->getTrace());
            }

            $c->startContest();
            print "Game started";
        }
        
        public function playRound() {
            for($i=0;$i<$c->getRoundCount();++$i) {
                $c->nextRound($i);
            }
            print_r($c);
            $c->finalRound();
        }
        
    }    
?>