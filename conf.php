<?php


/**
 * global configuration
 */

$config = (object) array(
    'database' => (object) array(
        'dbHost' => 'localhost',
        'dbUser' => 'songcontest',
        'dbPass' => '_r(D>S,uXx4B',
        'dbName' => 'songcontest',
        'dbPort' => 3306,
    ),
    'genres' => array(
        1000 => 'Rock',
        2000 => 'Country',
        3000 => 'Pop',
        4000 => 'Disco',
        5000 => 'Jazz',
        6000 => 'The Blues',
    ),
    'contestants' => array(
        'John','Elrond','Galadriel','Maze','Lucifer','Billy','Karen','Donald','Marry','Liv','Steven','Terry','Claudio','Ivanka','Maik','Sarah'
    ),
    'judges' => array(
        1 => array('judgeName' => 'Dieter',
                   'judgeTypeId' => 1000,
            ),
        2 => array('judgeName' => 'Mareike',
                   'judgeTypeId' => 2000,
            ),
        3 => array('judgeName' => 'Detlef',
                   'judgeTypeId' => 3000,
            ),
        4 => array('judgeName' => 'Bruce',
                   'judgeTypeId' => 4000,
            ),
        5 => array('judgeName' => 'Maite',
                   'judgeTypeId' => 5000,
            )
    ),
    'judgeTypes' => array(
        1000 => 'MeanJudge',
        2000 => 'FriendlyJudge',
        3000 => 'RandomJudge',
        4000 => 'HonestJudge',
        5000 => 'RockJudge',
    ),
    'global' => (object) array(
        'title' => 'Innogames Song Contest',
        'author' => 'Oliver Baer',
        'contestantsCount' => 10,
        'judgesCount' => 3,
        'ContestTotalRounds' => 6,
    )
);