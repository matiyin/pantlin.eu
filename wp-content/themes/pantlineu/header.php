<?

/**
 * @package WordPress
 * @subpackage pantlineu
 */
?>
<!DOCTYPE html>
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <link rel="profile" href="http://gmpg.org/xfn/11" />

    <link rel="apple-touch-icon" sizes="180x180" href="<?= IMAGE_PATH ?>/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= IMAGE_PATH ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= IMAGE_PATH ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= IMAGE_PATH ?>/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= IMAGE_PATH ?>/favicon/safari-pinned-tab.svg" color="#2d72a9">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="https://i.icomoon.io/public/5cc268951a/Pantlineu/style.css">
    
    <? wp_head(); ?>
    <? if (!SITE_LIVE) :
      //Develop only, sweep in production. Loads all css files in css/dev folder
      foreach (glob(get_template_directory()."/css/dev/*.css") as $css) {
        $css = substr($css, strrpos($css, '/') + 1);
        echo '<link type="text/css" rel="stylesheet" href="'.get_template_directory_uri().'/css/dev/'.$css.'?v=' . microtime().'">';
      }
    endif; ?>

  </head>
  <body <?php body_class(); ?>>

    <? get_template_part( 'template-parts/header/site', 'branding' ); // logo and menus ?>
    
  <div class="l-site-container">