<pre>
<?php



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

$db = new Db(true);

$db->query("SELECT * FROM history");
print_r($db->getResult());