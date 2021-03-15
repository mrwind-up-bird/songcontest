<?php

/**
 * class judge
 * handles judge stuff
 * 
 * @author oli
 * 
 */
class Judge {
    
    private $judgeName;
    private $judgeType;
    private $judgeTypeId;
    
    public function __construct($judge) {
        $this->judgeName = $judge['judgeName'];
        $this->judgeType = $judge['judgeType'];
        $this->judgeTypeId = $judge['judgeTypeId'];
    }
    
    /**
     * returns judge name
     * 
     * @return string name
     */
    public function getName() : String {
        return $this->judgeName;
    }
    
    public function getType() : String {
        return $this->judgeType;
    }
    
    
    /**
     * calculated the judge score based on their behavior
     * 
     * @param object contestant
     * @return float calculated contestant score
     */
    public function calcJudgeScore($contestant) : int {
        switch($this->judgeTypeId) {
            case(1000):             // random
                $score = rand(1,10);
                break;
            case(2000):             // mean
                $score = $contestant->getScore() < 90 ? 2 : 10;
                break;
            case(3000):             // honest
                // tabelle implementieren
                $score = 1;
                break;
            case(4000);             // rock
                if($contestant->getGenreId() == 4000) {
                    switch($s = $contestant->getScore()*10):
                        case($s < 500):
                            $score = 5;
                            break;
                        case($s > 500 && $s < 749):
                            $score = 8;
                            break;
                        default:
                            $score = 10;
                    endswitch;
                }
                else {
                    $score = rand(1,10);
                }
                break;
            case(5000):             // friendly
                switch($s = $contestant->getScore()*10):
                    case($s <= 30):
                        $score = 7;
                        break;
                    default: 
                        $score = 8;
                endswitch;
                if($contestant->isSick()) {
                    $score++;
                }
                break;
        }
        return $score;
    }
}