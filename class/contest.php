<?php

/**
 * interface singleton stuff
 * 
 * @author oli
 */
interface iContest {
    public static function getInstance(): iContest;
}


/**
 * contest itself
 * 
 * @author oli
 * 
 */
final class Contest implements iContest {

    private static $_instances = [];

    private $config;
    
    private $contestants        = array();
    private $judges             = array();
    
    private $rounds             = array();
    private $roundWinner        = array();
    
    private $roundCount  = 0;
    
    private $inputStream;

    /**
     * singleton stuff
     * 
     * @return \Contest
     */
    final public static function getInstance() : iContest {
        self::$_instances[static::class] = self::$_instances[static::class] ?? new static();
        return self::$_instances[static::class];
    }
    
    /**
     * gets the input stream
     * 
     * @todo implements as a class with better handlers...
     * 
     * @return object       stream
     * @throws Exception    to be implemented
     */
    public function getStream() : object {
        $inputStream = file_get_contents("php://input");
        try {
            if (0 == strlen($inputStream)){
                throw new Exception('Input stream is empty', 0);
            }
            if (false === ($inputStreamObj = json_decode($inputStream))){
                throw new Exception(sprintf('Failed to decode <<%s>>', $inputStream), 1);
            }
        } catch (Exception $ex) {
            return $ex;
        }
        return $this->inputStream = $inputStreamObj;        
    }
    
    /**
     * constructor stuff
     */
    public function __constructor() {
        $this->getStream();
    }
    
    /**
     * set config 
     * 
     * @param object $config
     */
    public function setConfig($config) {
        $this->config = $config;
    }
    
    /**
     * gets x unique contestants with their unique genre
     * x is defined in conf.php
     * 
     * @return array Object of Contestants
     */
    public function getContestants() : Array {
        $contestantNames = $this->config->contestants;
        $contestantGenres = $this->config->genres;
        
        if(empty($this->contestants)) {
            for($i=0;$i<$this->config->global->contestantsCount;$i++) {
                $cContestantId = array_rand($contestantNames);
                $cContestantGenreId = array_rand($contestantGenres);

                $this->contestants[] = new contestant($cContestantId,$contestantNames[$cContestantId],$contestantGenres[$cContestantGenreId],$cContestantGenreId);

                // this is if every contestant has a different score in every genre, not only in the one randomly created during the start of the contest
                //$this->contestants[] = new contestant($contestantNames[$cContestantId],$this->config->genres);

                // throw out already used names
                unset($contestantNames[$cContestantId]);
            }
        }        
        return $this->contestants;
    }
    
    /**
     * select x judges from judges array
     * x is defined in conf.php
     * 
     * @return array judges
     */
    public function getJudges() : Array {
        $judges = $this->config->judges;
        
        if(empty($this->judges)) {
            for($i=0;$i<$this->config->global->judgesCount;$i++) {

                // get a random judge from array
                $judgeId = array_rand($judges);

                // adds the id of the type
                $judges[$judgeId]['judgeType'] = $this->config->judgeTypes[$judges[$judgeId]['judgeTypeId']];
                $this->judges[] = new Judge($judges[$judgeId]);

                // here we go again, remove already used judge from array
                unset($judges[$judgeId]); 
            }            
        }
        return $this->judges;
    }
    
    /**
     * randomize rounds
     * 
     * @return array 
     */
    public function initializeRounds() : Array {
        $k = array_keys($this->config->genres);
        shuffle($k);
        foreach($k as $kk) {
            $this->rounds[$kk] = $this->config->genres[$kk];
        }
        return $this->rounds;
    }
    
    /**
     * fetches the number of rounds
     * 
     * @return int
     */
    public function getRoundCount() : int {
        return $this->roundCount = $this->config->global->ContestTotalRounds;
    }
    
    /**
     * and here we go!!
     * 
     * maybe this is a good point to save :)
     * 
     */
    public function startContest() {
        $this->getContestants();
        $this->getJudges();
    }
    
    /**
     * round and round it goes
     * 
     * @param int round
     */
    public function nextRound($round) {
        if($round <= 6) {
            foreach($this->contestants AS $c) {
                $s = array();
                foreach($this->judges AS $j) {
                    $rs = $j->calcJudgeScore($c);
                    $c->setContestScoreFromJudges($rs);
                    $s[] = $rs;
                }
                $c->setRoundScoreFromJudges($round,$s);
            }
        }
        else {
            $this->finalRound();
        }
    }
    
    /**
     * gets the winner for given round
     * 
     * @param int $round
     * @return array
     */
    public function getRoundWinner($round) : array {
        $result = array();
        $this->roundWinner = array();

        foreach($this->contestants AS $c) {
            $result[$c->getName()] = array_sum($c->getRoundScoreFromJudges($round));
        }
        $highestScore = max($result);
        foreach($result AS $k => $v) {
            if($v < $highestScore) {
                continue;
            }
            $this->roundWinner[$k] = $v;
        }
        return $this->roundWinner;
    }
    
    /**
     * final round, calculate overall winner
     * 
     * 
     * @return array
     */
    public function finalRound() {
        $result = array();
       
        foreach($this->contestants AS $c) {
           $result[$c->getName()] = array("score" => $c->getContestScoreFromJudges(true), "genre" => $c->getGenre());
        }
        $highestScore = max($result);
        foreach($result AS $k => $v) {
            if($v < $highestScore) {
                continue;
            }
            $finalRound[] = array("name" => $k, "score" => $v["score"], "genre" => $v["genre"]);
        }
        $this->saveHistory($finalRound);
        return $finalRound;
    }
    
    /**
     * saves the winner of the last round
     * 
     */
    public function saveHistory($data) {
       $db = new Db($this->config->database, true);
       $contest_id = md5(time());
       foreach($data AS $v) {
           $stmt = "INSERT INTO history (name,score,contest,genre) VALUES ('" . $db->escape($v["name"]) . "'," . $v["score"] . ",'" . $db->escape($contest_id) . "','" . $db->escape($v["genre"]) . "');";
           $db->query($stmt);
       }
    }
    
    /**
     * fetches history
     * 
     * @return array
     */
    public function getHistory() {
        $db = new Db($this->config->database, true);
        $stmt = "SELECT name, score, count(contest) as cc, sum(score) as sc FROM history GROUP BY name ORDER BY score DESC, sc ASC;";
        $r = $db->query($stmt);
        
        return $db->getResult();
    }
    
}