<?php
wp_register_script('jquery' , 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js');


// AJoute un custom post type, se lancera lorsque le wordpress se chargera
add_action( 'init', 'dw_create_post_type' );
/* FUNCTION TO CREATE A POST TYPE*/
function dw_create_post_type() {
  register_post_type( 'projets',
    array(
      'labels' => array(
        'name' => 'Projets',
        'singular_name' => __( 'Projet' ),
        'add_new'=> 'Ajouter un projet'

      ),
      'description'=>'Permet d\'ajouter ou retirer un projet',
      'menu_icon' => 'dashicons-portfolio',
      'menu_position'=>'20',
      'public' => true
    )
  );
}
// MENU

register_nav_menu( 'header', 'Menu principal, affiché dans le header.' );

/*  Script
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function  theme_enqueue_styles(){
  wp_enqueue_style('animate-css-style', get_stylesheet_directory_uri() . '/assets/animates.css');
}
*/
/* GET MENU ITEM */
function dw_get_nav_items($location){
  //Récupère les items du menu $location et les transformer en objet contenant $link et $label

  $id =dw_get_nav_id($location);
  if(!$id) return []; //SI on a pas ID on retourne un tab vide
  $nav=[];
  $children = [];

  foreach(wp_get_nav_menu_items($id) as $object){
    $item = new stdClass(); //Créer un objet vide en php
    $item->link = $object->url;
    $item->label= $object->title;
    $item->children = [];// QUand on ajoute un item a nav, on l'ajoute a chaque fois sur l'id de l'objet

    if($object->menu_item_parent){
      $item->parent = $object->menu_item_parent;
      $children[] = $item; //Stocke les element qui ont un parent mais en attende de confirmer que ce parent existe
    }
    else{
        $nav[$object->ID] = $item; // AJoute un item dans le tab nav = array_push($nav,$item)
    }
  }
  foreach ($children as $item) { //Assigne enfant au parent
    $nav[$item->parent]->children[] = $item;
  }
  return $nav;
}

/* GET MENU id from Location*/
function dw_get_nav_id($location)
{ foreach(get_nav_menu_locations()  as $navLocation => $id){
    if($navLocation == $location) return $id;
  }
  return false;
}

// FIN MENU
