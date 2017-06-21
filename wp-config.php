<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'christinncbase');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'christinncbase');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'adminRoot7');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'christinncbase.mysql.db');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'E3e+j`ERn_l:$J-&aadJa{(KQoGK 3qBFfE=^oq/e@%BO39(`0udJoH6LZ&-FNE$');
define('SECURE_AUTH_KEY',  'Ny6eDThl2vpzGg?a-&LrZQV8T77EdBHx*Gdmpf>y)%Z$?yVh}Z)l_,C,]>i><e{(');
define('LOGGED_IN_KEY',    'PnXYVik?o9~*?]YPWyfx$/z]5z&d%~qISiW8hR$xmyBwY.ri=rZ VmBl 4scICN5');
define('NONCE_KEY',        'upD,~U;a}S$pPD[+LObnZ{CjRQoyn4IEdgp)tF.[@/:Jm|zdkOJk^BiMe6R?&I/p');
define('AUTH_SALT',        'jqv3[;|Qb5d.Bx! d{|k{5fEtdY8Jb_:)/Aj*3EU+sc?nHUmI3WTgpK+lp<s1/H?');
define('SECURE_AUTH_SALT', 'BBcq{Q>~2ZIND&/`w8sQeK_v@WhP=uW0^d|D&xdxzna L5FH56Nbcoa<7r_KJWN-');
define('LOGGED_IN_SALT',   'kwU$Z.(4x=JAG,1>RZro<_~raK+x:qCRpXaU8akWW6%+G=]12Umig3TKDb2^Q4=O');
define('NONCE_SALT',       '<Wo1mM/7GR-RTcImu_UJGsZo-h3du)FKm|@wYBK+[`AIko4d+L7^ve9)@&c7ALc~');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'portfolio_wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
