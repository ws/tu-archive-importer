<pre>
<?php

date_default_timezone_set('GMT+0');

$directory = "tweets/";
$files = glob($directory . "*.js");

$tweets = Array();
	
foreach($files as $file)
{

	$str_data = file_get_contents($file);
	$str_data = substr($str_data, 32);
	
	$data = json_decode($str_data);
	
	foreach ($data as $tweet) {
		$currentTweet = array(
			'post_id'	 => $tweet->id_str,
			'author_username'     => $tweet->user->screen_name,
			'author_fullname'     => $tweet->user->name,
			'author_avatar'       => $tweet->user->profile_image_url_https,
			'is_protected'	=> $tweet->user->protected,
			'author_user_id'      => $tweet->user->id_str,
			'user_id'	 => $tweet->user->id_str,
			'post_text'	   => (string)$tweet->text,
			'pub_date'	=> gmdate("Y-m-d H:i:s", strToTime($tweet->created_at)),
			'source'	  => (string)$tweet->source,
			'geo'	   => $tweet->geo,
			'network'	 => 'twitter'
		);

		if (isset($tweet->in_reply_to_post_id) && isset($tweet->in_reply_to_user_id)){
			$currentTweet['in_reply_to_post_id'] = (string)$tweet->in_reply_to_status_id_str;
			$currentTweet['in_reply_to_user_id'] = (string)$tweet->in_reply_to_user_id_str;
		}

		$tweets[] = $currentTweet;
	}
}

print_r($tweets);



?>
</pre>
