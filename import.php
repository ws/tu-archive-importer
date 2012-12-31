<pre>
<?php

$directory = "tweets/";
$files = glob($directory . "*.js");


foreach($files as $file)
{

	$str_data = file_get_contents($file);
	$str_data = substr($str_data, 32);
	
	$data = json_decode($str_data,true);

	$parsed_tweet = array(
                    'post_id'             => $data->id,
                    'author_username'     => $data->user->screen_name,
                    'author_fullname'     => $data->user->name,
                    'author_avatar'       => $data->user->profile_image_url_https,
                    'is_protected'        => $data->user->protected,
                    'author_user_id'      => (string)$data->user->id,
                    'user_id'             => (string)$data->user->id,
                    'post_text'           => (string)$data->text,
                    'pub_date'            => gmdate("Y-m-d H:i:s", strToTime($data->created_at)),
                    'in_reply_to_post_id' => (string)$data->in_reply_to_status_id,
                    'in_reply_to_user_id' => (string)$data->in_reply_to_user_id,
                    'source'              => (string)$data->source,
                    'favorited'           => (string)$data->favorited,
                    'place'               => (string)$data->place->full_name,
                    'network'             => 'twitter'
    );

}



?>
</pre>