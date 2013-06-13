#!/usr/bin/env php
<?php

// Instead of messing around with SQL statements myself
require_once 'meekrodb.2.1.class.php';
DB::$user = 'root';
DB::$password = 'root';
DB::$dbName = 'thinkup';

// Change this if you changed your posts table prefix
$table_name = 'tu_posts';

// Twitter user ID (number, can be found in the tweet archive)
$userid = '';

$directory = "tweets/";
$files = glob($directory . "*.js");

echo "Pulling existing tweets...\n";

$existingdb = DB::query("SELECT post_id FROM " . $table_name . " WHERE author_user_id=%i AND network='twitter'", $userid);
foreach ($existingdb as $tweet) {
	$existing[$tweet['post_id']] = true;
}
unset($existingdb);

echo "Running...";

foreach($files as $file)
{

	$str_data = file_get_contents($file);
	$str_data = substr($str_data, 32);
	
	$data = json_decode($str_data);
	
	foreach ($data as $tweet) {
		$parsed_tweet = array(
			'post_id'             	=> $tweet->id_str,
			'author_username'     	=> $tweet->user->screen_name,
			'author_fullname'     	=> $tweet->user->name,
			'author_avatar'       	=> $tweet->user->profile_image_url_https,
			'is_protected'        	=> $tweet->user->protected,
			'author_user_id'      	=> (string)$tweet->user->id,
			'post_text'           	=> (string)$tweet->text,
			'pub_date'            	=> gmdate("Y-m-d H:i:s", strToTime($tweet->created_at)),
			'source'              	=> (string)$tweet->source,
			'network'             	=> 'twitter',
			'author_follower_count' => '0'
		);

		if (isset($tweet->place->full_name)) {
			$parsed_tweet['place'] = (string)$tweet->place->full_name;
		}

		if (isset($tweet->in_reply_to_status_id)) {
			$parsed_tweet['in_reply_to_post_id'] = (string)$tweet->in_reply_to_status_id;
		}

		if (isset($tweet->in_reply_to_user_id)) {
			$parsed_tweet['in_reply_to_user_id'] = (string)$tweet->in_reply_to_user_id;
		}

		// Check to see if a tweet with the specific id already exists
		if (!isset($existing[$tweet->id_str])) {
			DB::insert($table_name, $parsed_tweet);
		}
	}
}

echo "Finished!";

?>

