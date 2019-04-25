<?php

function send_future_posts() {
  $url = 'https://webhook.site/1a231019-d232-4fa1-84b3-45e21c27aafb';
  $posts = json_encode(future_posts());

  wp_remote_post(
    $url, array(
      'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
      'body'        => $posts,
      'method'      => 'POST',
      'data_format' => 'body',
    )
  );
}

function future_posts() {
  $args = array(
    'post_status' => 'future',
    'post_type' => 'any',
    'per_page' => 5
  );
  $query = new WP_Query( $args );
  $posts = $query->posts;
  $post_dates = array();

  foreach($posts as $post) {
    $post_dates[] = $post->post_date;
  }

  return $post_dates;
}

add_action( 'save_post', 'send_future_posts' );