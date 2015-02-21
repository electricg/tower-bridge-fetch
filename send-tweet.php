<?php

require_once 'twitter-php/src/twitter.class.php';

$consumerKey = '7VO8w8rx6iydRmw6j7Wu48eWZ';
$consumerSecret = 'IlrXYzX29WQ7Y1m6d8RhH001HRaXHi0z8aZ5U3tfcowXUM7WGs';
$accessToken = '3024106517-mVoVCV128s9WIDwJy1Sj9fixm8mbnAr6lcPDmJb';
$accessTokenSecret = 'xOYbL90NR5hoGxT28hbkrkJ1UzFD9j9dBsCydhxHjW0kW';

$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

try {
  $tweet = $twitter->send('Test 1');

} catch (TwitterException $e) {
  echo 'Error: ' . $e->getMessage();
}

?>