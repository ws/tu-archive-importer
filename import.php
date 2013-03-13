#!/usr/bin/php
<?php

// Instead of messing around with SQL statements myself
require_once 'meekrodb.2.1.class.php';
DB::$user = 'root';
DB::$password = 'root';
DB::$dbName = 'thinkup';

$directory = "tweets/";
$files = glob($directory . "*.js");

echo "Running...";

foreach($files as $file)
{

	$str_data = file_get_contents($file);
	$str_data = substr($str_data, 32);
	
	$data = json_decode($str_data);
	
	foreach ($data as $tweet) {
		$parsed_tweet = array(
	                    'post_id'             => $tweet->id,
	                    'author_username'     => $tweet->user->screen_name,
	                    'author_fullname'     => $tweet->user->name,
	                    'author_avatar'       => $tweet->user->profile_image_url_https,
	                    'is_protected'        => $tweet->user->protected,
	                    'author_user_id'      => (string)$tweet->user->id,
	                    'post_text'           => (string)$tweet->text,
	                    'pub_date'            => gmdate("Y-m-d H:i:s", strToTime($tweet->created_at)),
	                    'in_reply_to_post_id' => (string)$tweet->in_reply_to_status_id,
	                    'in_reply_to_user_id' => (string)$tweet->in_reply_to_user_id,
	                    'source'              => (string)$tweet->source,
	                    'place'               => (string)$tweet->place->full_name,
	                    'network'             => 'twitter'
	    );

		DB::insert('tu_posts', $parsed_tweet);

    }

}

$db->close();

echo "Finished!";

?>