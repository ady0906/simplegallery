<!DOCTYPE html>

<html>
  <head>
    <title><?php bloginfo( 'name' ); ?></title>

    <link href="<?php echo get_bloginfo('template_url'); ?>/styles/global.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo get_bloginfo('template_url'); ?>/styles/about.css" rel="stylesheet" type="text/css" />

    <?php $template_name = basename(get_page_template(), '.php'); ?>
    <link href="<?php echo get_bloginfo('template_url'); ?>/styles/<?php echo $template_name ?>.css" rel="stylesheet" type="text/css" />
  </head>

  <body>
    <div class="theme-wrapper js-theme-wrapper">
      <nav class="theme-header">
        <h1><?php bloginfo( 'name' ); ?></h1>
        <ul class="theme-menu">
			<?php wp_list_pages('title_li'); ?>
        </ul>
      </nav>
