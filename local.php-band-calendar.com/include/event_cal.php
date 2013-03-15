<?php
if(!defined('allow')){die('Direct access not premitted');}

require_once (dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wall/php-band-calendar.inc');

$currentTime = time();
$eventsList = array();
try {
	$conn = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	# Prepare the query ONCE
	$statement = $conn->prepare("SELECT `id`, `title`, `time`, `address`, `description` FROM `events` WHERE `time` >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");

	$statement->execute();
	$eventsList = $statement->fetchAll(PDO::FETCH_ASSOC);
	unset($statement);
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		die("Error (0)");
}
$eventsCount = count($eventsList);
for ($i = 0; $i < $eventsCount; $i++) {
	$eventsList[$i]['date'] = date('F j Y', $eventsList[$i]['time']); 
	$eventsList[$i]['time'] = date('g:ia', $eventsList[$i]['time']);
	//$eventsList[$i]['count'] = $i;

}
//echo '<pre>';
//print_r ($eventsList);
//echo '</pre>';
if (!empty($eventsList[0]['title'])) { ?>
	<script type="text/javascript">
		var eventsList = null;
		var eventsList = JSON.parse('<?php echo json_encode($eventsList) ?>');
		//alert(eventsList[0].time);
	</script>
	<?php
		for ($i = 0; $i < $eventsCount; $i++) {
			echo '<article class="event" id="event-' . $i . '">'."\r\n";
			echo '<h3><a href="#" class="eventlink" id="eventlink-' . $i . '">' . $eventsList[$i]['title'] . '</a></h3>'."\r\n";
			echo '<span>' . $eventsList[$i]['date'] . '</span>'."\r\n";
			echo '<span>' . $eventsList[$i]['time'] . '</span>'."\r\n";
			echo '<address>' . $eventsList[$i]['address'] . '</address>'."\r\n";
			echo '</article>';
		};
	} else { ?>
		<article class="event">
			<h3>Sorry, no up comming events listable.</h3>
		</article>
	<?php 
	};
?>
<div id="map_canvas" class="hidden"></div>