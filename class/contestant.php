<?php

/**
 * class contestant
 * handles all the stuff of the contestants
 * 
 * @autor oli 
 */

class contestant {
    
    private $name;

    private $genre;
    private $genreId;
    private $score;

    private $isSick = false;
    
    private $contestScoreFromJudges = [];
    private $roundContestScoreFromJudges = [];
    
    /**
     * constructor
     * 
     * @param int $id
     * @param string $name
     * @param string $genre
     * @param string $genreId
     */
    public function __construct($id, $name, $genre, $genreId) {
        $this->id   = $id;
        $this->name = $name;

        $this->genre = $genre;
        $this->genreId = $genreId;
        $this->score = $this->calculateScore();
    }
    
    /**
     * simple returns the name of contestant from config array
     * 
     * @return string name
     */
    public function getName() : string {
        return $this->name;
    }
    
    /**
     * fetches the contestant genre
     * 
     * @return string genre
     */
    public function getGenre() : string {
        return $this->genre;
    }
    
    /**
     * gets the genre id
     * 
     * @return int
     */
    public function getGenreId() : int {
        return $this->genreId;
    }
    
    /**
     * gets the score of contestant
     * 
     * @return float score
     */
    public function getScore() : float {
        return $this->score;
    }
        
    /**
     * return if sick or not
     * 
     * @return bool
     */
    public function getSickStatus() : bool {
        return $this->isSick ? 1 : 0;
    }
    
    /**
     * get contest score or summarized overall score
     * 
     * @param bool $all
     * @return float
     */
    public function getContestScoreFromJudges($all = false) : float {
        return $this->contestScoreFromJudges;
    }
    
    /**
     * sets current round score
     * 
     * @param float $score
     */
    public function setContestScoreFromJudges($score) {
        array_push($this->contestScoreFromJudges,$score);
    }
    
    /**
     * setter roundscore
     * 
     * @param int $s
     */
    public function setRoundScoreFromJudges($r,$s) {
        $this->roundContestantScoreFromJudges[$r] = $s;
    }
    
    /**
     * gets the certain round score of contestant
     * 
     * @param int $r
     * @return array
     */
    public function getRoundScoreFromJudges($r) : array {
        return isset($this->roundContestantScoreFromJudges[$r]) ? $this->roundContestantScoreFromJudges[$r] : array();
    }
    
    /**
     * calculate score
     *
     * @return float score
     */
    private function calculateScore() : float {
        //return $this->isSick() ? $this->score = round((rand(1,1000)/10)/2) : rand(1,1000)/10;
        return $this->score = rand(1,1000)/10;
    }
    
    /**
     * checks if combetant is sick by 5% chance
     * 
     * @return boolean
     */
    public function isSick() : bool {
        return $this->isSick = rand(1,100) < 5 ? true : false;
    }
    
}
