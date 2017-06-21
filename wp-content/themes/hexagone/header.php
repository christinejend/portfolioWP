<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Christine Jendrzejczyk"/>
    <meta name="description" content="Portfolio de Christine Jendrzejczyk" />
    <meta name="keywords" content="portfolio, étudiante Inpres, Christine Jendrzejczyk, Chris Jendrz" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/assets/css/main.css '; ?>"/>
	<title>Portfolio - Christine Jendrzejczyk</title>
</head>
<body>
  <header class="head">
    <h1 role="heading" level="1" class="head__title hidden"><?php wp_title(); the_field('auteur');  ?> </h1>
    <nav class="head__nav">
        <h2 class="hidden">Menu dropdown</h2>
        <input type="checkbox" title="menu" id="drop" class="head__check">
				<label for="drop" checked="checked" class="head__drop"></label>
        <ul class="head__list">
        <?php foreach (dw_get_nav_items('header') as $item):?>
          <li class="head__elt">
            <a href="<?= $item->link?>" class="menu__link"><?= $item->label?></a>
          </li>
        <?php endforeach;?>
        </ul>
    </nav>
  </header
