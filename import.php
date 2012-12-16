<?php

include_once 'config.php';

$tweets_dir = $IMPORTER['directory'] . "data/js/tweets/";

$scan = scandir($tweets_dir);

for ($i=0; $i<count($scan); $i++) {

	if ($scan[$i] != '.' && $scan[$i] != '..') { // Check to make sure it's not a silly filename

		

	}

}  


?>