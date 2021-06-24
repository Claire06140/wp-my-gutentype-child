<?php
/*
Plugin Name: Mon Petit Plugin for happy-diabetes.com
Description: Site specific code changes for happy-diabetes.com
*/
/* Start Adding Functions Below this Line */
  
  function test() {
      ?>
    <script id="me vois-tu"></script>
    <?php
  }
  add_action('wp_head', 'test');
  
/* Dergister les scripts embed dont YouTube */
function deregister_wpembed(){
 wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'deregister_wpembed' );
// 10 06 changé hook de wp_footer à wp_enqueue_scripts ->  voir si marche différemment avec enqueue. Mettre une prio > au défaut (10)?


// HOOK INIT
/*wp marmite accélérer chargement jquery en utilisant le CDN de Google TOP testé avec speed insight!!!*/
function wpm_jquery() {
if ( !is_admin() ) {
//La fonction supprime l'utilisation du fichier original de JQuery sur votre serveur
    wp_deregister_script( 'jquery' );
//Elle enregistre alors le nouvel emplacement de JQuery, chargé depuis le CDN de Google
    wp_register_script( 'jquery', ( 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js' ), false, null, true );
//La fonction charge JQuery
    wp_enqueue_script( 'jquery' );
   }
}
add_action( 'init', 'wpm_jquery' );

// pour virer swiper (effet changement slides pas utilisé) marche 17 06 => en mettant enqueue ça marche!
function remove_elementor_js () {
//	if ( is_front_page() ) {
		wp_deregister_script( 'elementor-frontend' );

		wp_enqueue_script(
        	'elementor-frontend',
        	ELEMENTOR_ASSETS_URL . 'js/frontend.min.js',
        	[
          	'elementor-frontend-modules',
          	'elementor-dialog', 
          	'elementor-waypoints',
          	//Just comment if you want dont load this JS in page
          	//'swiper',
          	'share-link',
        	],
        	ELEMENTOR_VERSION,
        	true
		);
	}
//}
add_action( 'wp_enqueue_scripts', 'remove_elementor_js');

  


//Tentative arrêter de loader trx_addons.js -> je commente lignes 48 et 49
// Pour l'instant ne marche pas => il faut l'actionner! add_action ou add_filter =>  voir pour virer slider
function trx_addons_load_scripts_front() {
		// Font with icons must be loaded before main stylesheet
		wp_enqueue_style( 'trx_addons-icons', trx_addons_get_file_url('css/font-icons/css/trx_addons_icons-embedded.css'), array(), null );

		// Load Swiper slider script and styles
		trx_addons_enqueue_slider();

		// Load Popup script and styles
		trx_addons_enqueue_popup();

		// Main plugin's styles
		wp_enqueue_style( 'trx_addons', trx_addons_get_file_url('css/trx_addons.css'), array(), null );

		// If 'debug_mode' is off - load merged scripts
		if (trx_addons_is_off(trx_addons_get_option('debug_mode'))) {
			/*wp_enqueue_script( 'trx_addons', trx_addons_get_file_url('js/trx_addons.js'), array('jquery'), null, true );
            */
		// Else load all scripts separate
		} else {
			wp_enqueue_script( 'trx_addons-utils', trx_addons_get_file_url('js/trx_addons.utils.js'), array('jquery'), null, true );
			wp_enqueue_script( 'trx_addons', trx_addons_get_file_url('js/trx_addons.front.js'), array('jquery'), null, true );
		}
		
		// Conditions to load animation.css - not mobile and not VC Frontend
		if ( !wp_is_mobile() && (!function_exists('trx_addons_vc_is_frontend') || !trx_addons_vc_is_frontend()))
			wp_enqueue_style( 'trx_addons-animation',	trx_addons_get_file_url('css/trx_addons.animation.css'), array(), null );
	}




/* Désactivation Pingbacks internes */
function no_self_ping( &$links ) {
 $home = get_option( 'home' );
 foreach ( $links as $l => $link )
 if ( 0 === strpos( $link, $home ) )
 unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );
/* Fin Désactivation Pingbacks internes */



// Rediriger les liens des auteurs vers la page "/a-propos"
function wpm_author_page() {
	return home_url( 'a-propos' );
};
add_filter( 'author_link', 'wpm_author_page' );
// Fin redirection a-propos


// Gravatar Alt Fix
function replace_content($text) {
    $alt = get_the_author_meta( 'display_name' );
    $text = str_replace('alt=\'\'', 'alt=\'Avatar for '.$alt.'\' title=\'Gravatar for '.$alt.'\'',$text);
    return $text;
}
add_filter('get_avatar','replace_content');
// Fin fix Gravatar


/* Dergister les scripts embed dont YouTube ne marche pas */
//function deregister_widgetapi(){
// wp_dequeue_script( 'www-widgetapi.js' );
// }
// add_action( 'wp_enqueue_scripts', 'deregister_widgetapi' );
// ne marche pas non plus avec hook 'wp_footer'
  
  
/* Stop Adding Functions Below this Line */
?>
