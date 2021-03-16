<?php
print "<pre>";
    require_once 'conf.php';
    

    include('class/contestant.php');
    include('class/judge.php');
    include('class/contest.php');


class game {
    
    private $c;
        
        public function startGame($config) {
            try {
                $this->c = Contest::getInstance();
                $this->c->setConfig($config);    
            } catch (Exception $ex) {
                print_r($ex->getMessage());
                print_r($ex->getTrace());
            }

            $this->c->startContest();
            print "Game started";
        }
        
        public function playRound() {
            for($i=0;$i<$this->c->getRoundCount();++$i) {
                print "Runde: " . $i;
                $this->c->nextRound($i);
            }
            $this->c->finalRound();
        }
}



$g = new game();
$g->startGame($config);
$g->playRound();
