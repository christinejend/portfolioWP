<?php
/*
    Template Name: Home
    http://localhost/portfolio/wp-admin/themes.php
*/

get_header();
?>

<?php $fieldsAcf = get_fields(); ?>
<!-- PAGE ACCUEIL -->
  <main id="home" class="home">
    <div class="home__circle">
        <h2 role="heading" level="2" class="hidden">Picture</h2>
      </div>

    <?php if( get_field('auteur') ): ?>
      <h1 role="heading" level="1" class="home__title">
      <?= $fieldsAcf['auteur']; ?>
	   </h1>
   <?php endif; ?>

        <h2 role="heading" level="2" class="home__sTitle"><?= $fieldsAcf['metier']; ?></h2>
  </main>
<!-- FIN page ACCUEIL -->
<!-- page PROJETS -->
  <main class="projects" id="projects">

    <?php
     $prjts = new WP_Query(); // Prends la page projets
     $prjts->query([
             'pagename'=>'Projets'
        ]);
        if ( $prjts->have_posts() ):
                       while ( $prjts->have_posts() ):
                        $prjts->the_post();
                ?>
  <h1 role="heading" level="1" class="projects__title"><?= the_title(); ?></h1>
  <?php endwhile; endif; ?>
  <div class="projects__single">
    <?php
       $projet = new WP_Query([
               'post_type'=>'projets',
          ]);
        if ( $projet->have_posts() ):
            while ( $projet->have_posts() ):
              $projet->the_post();
    ?>

    <a href="#<?= the_field('id'); ?>" class="projects__link">
					<div class="projects__pict">
						<h2 class="hidden">Forme</h2>
            <img src="<?= the_field('miniature'); ?>" alt="" class="projects__img">
						<div class="projects__text">
						<h2 class="projects__name"><?= the_title(); ?></h2>
						</div>

					</div>
				</a>
        <?php endwhile; endif; ?>
  </main>
<!-- FIN PAGE -->
 <!-- PAGE A PROJET -->
  <main class="project">
    <?php
       $projet = new WP_Query([
               'post_type'=>'projets',
          ]);
        if ( $projet->have_posts() ):
            while ( $projet->have_posts() ):
              $projet->the_post();
    ?>
    <div class="prj" id="<?= the_field('id'); ?>">
    				<a href="#" class="project__close"><img src="wp-content/themes/hexagone/assets/img/close.png" alt="" class="project__closeP"></a>
            <div class="project__bloc">
              <h1 class="project__title"><?= the_title(); ?></h1>
      				<p class="project__course"><?= the_field('cours'); ?></p>
      				<!--<ul class="project__prog">
      					<h2 class="project__progTitle">Moyen utilisé</h3>
      					<li class="projects__eltProg"><//?= the_field('moyen'); ?></li>
      				</ul>-->
      				<p class="project__text"><?= the_field('intitule'); ?></p>
                <figure class="project__fig">
      					<img src="<?= the_field('palette'); ?>" alt="aperçu de la palette de couleur" class="project__kuller">
      					<figcaption class="project__figTxt">Palette de couleur utilisé pour le site</figcaption>
      				</figure>

      				<img src="<?= the_field('apercu'); ?>" alt="aperçu du site" class="project__site">
              <?php $link = get_field('lien_ext'); ?>
              <a href="<?php echo $link ?>" class="project__link">Aller le voir</a>
      			</div>
            </div>

          <?php endwhile; endif; ?>
  </main>
<!-- PAGE A PROPPOS -->
  <main class="about" id="about">
    <?php
         $prop = new WP_Query([
                 'pagename'=>'A propos'
                ]);
          if ( $prop->have_posts() ):
              while ( $prop->have_posts() ):
                  $prop->the_post();
          ?>
          <h1 role="heading" level="1" class="about__title"><?= the_title(); ?></h1>
          <div class="about__circle">
              <img src="<?= the_field('photo'); ?>" alt="" class="about__circleImg">
          </div>
          <p class="about__more"><?= the_field('presentation'); ?>
          </p>
          <?php $lien = get_field('lien_contact'); ?>
          <a href="#contact" class="about__link">Envie de me contacter?</a>
          <p class="about__more2"><?= the_field('explications'); ?></p>
          <div class="about__list">
  					<div class="about__listSk">
    					<h3 class="hidden">Skills</h3>
                <?= the_field('list_comp_suite'); ?>
                <?= the_field('list_competences'); ?>
            </div>
            <div class="about__listJo">
			      <h3 class="hidden">Join</h3>
            <ul class="about__listJoin">
          <li class="about__eltJoin fb"><?= the_field('facebook'); ?> </li>
          <li class="about__eltJoin git">  <?= the_field('github'); ?></li>
          <li class="about__eltJoin gmail"> <?= the_field('gmail'); ?><br><span class="space">
gmail.com</span></li>
        </ul>
				</div>
        <?php endwhile; endif; ?>
  </main>
<!-- FIN page ABOUT -->
<!-- Page Contact -->
<footer class="contact" id="contact">
  <?php
       $foot = new WP_Query([
               'pagename'=>'Contact'
              ]);
        if ( $foot->have_posts() ):
            while ( $foot->have_posts() ):
                $foot->the_post();
        ?>
      <h1 role="heading" level="1" class="contact__title"><?= the_title(); ?></h1>
      <div class="contact__circle">
        <!-- PICTURE -->
      </div>
      <div class="contact__form">
        <?= the_field('form'); ?>
      </div>
        <?php endwhile; endif; ?>
        <div class="contact__right">
          <?php
               $prop = new WP_Query([
                       'pagename'=>'A propos'
                      ]);
                if ( $prop->have_posts() ):
                    while ( $prop->have_posts() ):
                        $prop->the_post();
                ?>
  				<ul class="contact__listJoin">
  					<li class="contact__eltJoin fbCont"><?= the_field('facebook'); ?></li>
  					<li class="contact__eltJoin gitCont"><?= the_field('github'); ?></li>
  					<li class="contact__eltJoin gmailCont"> <?= the_field('gmail'); ?><br><span class="space">gmail.com</span></li>
  				</ul>
  			</div>
      <?php endwhile; endif; ?>
      </footer>
  <?php wp_footer(); ?>
</body>

</html>
