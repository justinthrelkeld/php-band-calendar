<?php
require_once (dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/wall/dev-ical.com.inc');

function parseArrayToObject($array) {
    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
        foreach ($array as $name => $value) {
            $name = strtolower(trim($name));
            if (!empty($name)) {
                $object->$name = $value;
            }
        }
    }
    return $object;
}

$eventsList = array();
try {
    $conn = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        # Prepare the query ONCE
    $statement = $conn->prepare("SELECT  `id`, `title`, `time`, `address`, `description` FROM `events` ORDER BY `time` DESC ");
    $statement->execute();
    $eventsList = $statement->fetchAll(PDO::FETCH_ASSOC);
    unset($statement);
} catch(PDOException $e) {
    //echo 'Error: ' . $e->getMessage();
    die("Error (0)");
}
foreach ($eventsList as $key => $value) {
    $eventsList[$key]['date'] = date('F j', $eventsList[$key]['time']); 
    $eventsList[$key]['time'] = date('g:ia', $eventsList[$key]['time']);
}
$eventsObject = json_encode($eventsList);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="js/jquery-ui-1.10.1.custom.js" type="text/javascript"></script>
    <script src="js/jquery.smooth-scroll.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvloktPgM55YJWxAggRuTFD_vO9HkllhY&sensor=true"></script>
    <script type="text/javascript" src="js/calendar.js"></script>
    <script type="text/javascript">
        var eventsList = JSON.parse('<?php echo $eventsObject ?>');
        //alert(eventsList[0].time);
    </script>
</head>
<body onload="">
    <?php 
        echo '<pre>';
        print_r ($eventsList);
        print ($eventsObject);
        echo '</pre>';
    ?>
    <section id="eventcalendar">
        <?php 
        foreach ($eventsList as $key => $value) {
            echo '<article id="event-' . $eventsList[$key]['id'] . '">'."\r\n";
            echo '<h3><a href="#" id="eventlink-' . $eventsList[$key]['id'] . '">' . $eventsList[$key]['title'] . '</a></h3>'."\r\n";
            echo '<span>' . $eventsList[$key]['date'] . '</span><br />'."\r\n";
            echo '<span>' . $eventsList[$key]['time'] . '</span>'."\r\n";
            echo '</article>';
        }
        ?>
    </section>
</body>
</html>