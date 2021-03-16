<?php
    session_start();
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

    function json_encode_obj($item) { 
        if(!is_array($item) && !is_object($item)) {   
            return json_encode($item);   
        } 
        else {   
            $pieces = array();   
            foreach($item as $k=>$v) {   
                $pieces[] = "\"$k\":".json_encode_objs($v);   
            }   
            return '{'.implode(',',$pieces).'}';   
        }   
    }   
    
    $action = strlen(filter_input(INPUT_POST, 'action')) ? filter_input(INPUT_POST, 'action') : filter_input(INPUT_GET, 'action');
    $round  = strlen(filter_input(INPUT_POST, 'data')) ? filter_input(INPUT_POST, 'data') : filter_input(INPUT_GET, 'data');
    
    switch($action) {
        case("startGame"):
            // start game
            try {
                $c = Contest::getInstance();
                $c->setConfig($config);
            } catch (Exception $ex) {
                print json_encode($ex->getMessage());
                break;
            }
            $c->startContest();
            $judges = array();
            foreach($c->getJudges() AS $j) {
                $judges[] = array("name" => $j->getName(), "type" => $j->getType());
            }
            $contestants = array();
            foreach($c->getContestants() AS $cc) {
                $contestants[] = array("name" => $cc->getName(), "genre" => $cc->getGenre());
            }
            $return = array("judges" => $judges, "contestants" => $contestants);
            print json_encode($return);
            $_SESSION["contest"] = serialize($c);
            break;
        case("nextRound"):
            // next round
            $c = unserialize($_SESSION["contest"]);
            $c->nextRound($round);
            $judges = array();
            $contestants = array();
            foreach($c->getContestants() AS $cc) {
                $contestants[] = array("name" => $cc->getName(), "genre" => $cc->getGenre(), "points" => $cc->getContestScoreFromJudges());
            }
            $roundwinner = array();
            foreach($c->getRoundWinner($round) AS $rw => $rs) {
                $roundwinner[] = array("contestantname" => $rw, "roundpoints" => $rs);
            }
            
            print json_encode(array("contestants" => $contestants, "roundwinner" => $roundwinner));
            break;
        case("endGame"):
            // ende
            break;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
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
