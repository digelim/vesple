<?php

/**
* Template Name: Thank you
*/

$navigation = get_field('navigation', 'options') ?: null;
$footer = get_field('footer', 'options') ?: null;

get_header( $navigation );

?>

<div class="container">
    <h3 class="align-center m-t-100 m-b-100">Thank you for your order, you will be redirected shortly.</h3>
</div>
