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
    include('class/db.php');

    $action = strlen(filter_input(INPUT_POST, 'action')) ? filter_input(INPUT_POST, 'action') : filter_input(INPUT_GET, 'action');
    $round  = strlen(filter_input(INPUT_POST, 'data')) ? filter_input(INPUT_POST, 'data') : filter_input(INPUT_GET, 'data');

    switch($action) {
        case("startGame"):
            // start game
            try {
                $c = Contest::getInstance();
                $c->setConfig($config);
                $_SESSION["contest"] = serialize($c);
            } catch (Exception $ex) {
                print json_encode($ex->getMessage());
                die();
            }
            $c = unserialize($_SESSION["contest"]);
            $c->startContest();
            $judges = array();
            foreach($c->getJudges() AS $j) {
                $judges[] = array("name" => $j->getName(), "type" => $j->getType());
            }
            $contestants = array();
            foreach($c->getContestants() AS $cc) {
                $contestants[] = array("name" => $cc->getName(), "genre" => $cc->getGenre(), "score" => $cc->getScore());
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
                $contestants[] = array("name" => $cc->getName(), 
                                       "genre" => $cc->getGenre(), 
                                       "overallPoints" => $cc->getContestScoreFromJudges(),
                                       "points" => $cc->getRoundScoreFromJudges($round));
            }
            $roundwinner = array();
            foreach($c->getRoundWinner($round) AS $rw => $rs) {
                $roundwinner[] = array("contestantname" => $rw, "roundpoints" => $rs);
            }
            print json_encode(array("contestants" => $contestants, "roundwinner" => $roundwinner));
            $_SESSION["contest"] = serialize($c);
            break;
        case("endGame"):
            // ende
            $c = unserialize($_SESSION["contest"]);
            print json_encode($c->finalRound());
            $_SESSION["contest"] = serialize($c);
            break;
        case("history"):
            $c = unserialize($_SESSION["contest"]);
            print json_encode($c->getHistory());
            break;
    }
?>
