<?php

/**
 * history class, reads or writes history data of contests
 * 
 * @author oli
 */
class history {
    
    private $conn;
    private $contestId;
    private $winnerName;
    private $judgeScore;
    
    public function __construct() {
        $this->conn = new Db();
    }
    
    public function getHistory() {
        $sql = "SELECT * FROM history ORDER BY name, judge_score DESC";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    public function saveHistory() {
        $sql = "INSERT INTO history SET winner_name = '" . $this->conn->escape($this->winnerName) . "', judge_score = " . $this->judgeScore;
        $this->conn->query($sql);
    }
    
    public function setJudgeScore($judgeScore) {
        $this->judgeScore = $judgeScore;
    }
    
    public function setWinnerName($winnerName) {
        $this->winnerName = $winnerName;
    }
    
}
