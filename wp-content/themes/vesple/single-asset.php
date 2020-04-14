<?php

header('Content-Type: application/json');

$results = array();

if (have_posts()):
  while (have_posts()):
    the_post();
    $results = array(
      'name' => get_the_content(),
      'symbol' => get_the_title(),
      'returns' => json_decode( get_field('returns') ),
      'exchange' => get_the_category()[0]->category_description,
      'currency' => get_the_excerpt()
    );
  endwhile;
endif;

echo json_encode($results, JSON_UNESCAPED_SLASHES);

die();

?>
