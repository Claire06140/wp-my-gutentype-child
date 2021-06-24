<?php
/**
 * Child-Theme functions and definitions
 */


function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


function deregister_styles_mediaelement() {
	wp_deregister_style('mediaelement');
	wp_deregister_style('wp-mediaelement');
//	wp_deregister_script('mediaelement');
//	wp_deregister_script('wpmediaelement');
}
//add_action('wp_enqueue_scripts', 'dequeue_scripts_styles_mediaelement');
add_action('after_setup_theme', 'deregister_styles_mediaelement');

function deregister_scripts_mediaelement() {
//	wp_deregister_style('mediaelement');
//	wp_deregister_style('wp-mediaelement');
	wp_deregister_script('mediaelement');
	wp_deregister_script('wpmediaelement');
}
add_action('wp_enqueue_scripts', 'deregister_scripts_mediaelement');
//add_action('after_setup_theme', 'dequeue_scripts_styles_mediaelement');



//  STOP chargement toutes Google fonts -> REDUX  ds  framework redux  def du plugin  worth the read,
//  disable_google_fonts_link set  to  truee

// AMELIORER VITESSE DE CHARGEMENT ET AFFICHAGE PAGE 
//function stop_custom_css() {
//	wp_dequeue_style( 'gutentype-custom' );
//	}
//add_acction('wp_enqueue_scripts', 'stop_custom_css')

// Arreter de generer des css/__colors.... ete css/__custom
// // Custom colors, fonts and other rules
//		if ( ! is_customize_preview() && ! isset( $_GET['color_scheme'] ) && gutentype_is_off( gutentype_get_theme_option( //'debug_mode' ) ) ) {
//			wp_enqueue_style( 'gutentype-custom', gutentype_get_file_url( 'css/__custom.css' ), array(), null );
//			if ( gutentype_get_theme_setting( 'separate_schemes' ) ) {
//				$schemes = gutentype_get_sorted_schemes();
//				if ( is_array( $schemes ) ) {
//					foreach ( $schemes as $scheme => $data ) {
//						wp_enqueue_style( "gutentype-color-{$scheme}", gutentype_get_file_url( "css/__colors_{$scheme}.css" //), array(), null );
//					}
//				}
//			}
//		} else {
//			wp_add_inline_style( 'gutentype-main', gutentype_customizer_get_css() );
//		}
// 
// REDEFINIR gutentype_theme_fonts_links avec chemin local de stylesheet,css pour gutentype_get_file_url pour arrêter de charger les fonts google - laissées en backup quand meme  - speed insights fontsapi
// OPTION A TENTER EN BACKUP: MODIFIER L'URL DE  wp_enqueue_style( ‘google-fonts’, ‘//fonts.googleapis.com/css?family=Oswald:400,700|Lato:400,400i,700’, array(), PARENT_THEME_VERSION );
// Return links for all theme fonts
//if ( ! function_exists( 'gutentype_theme_fonts_links' ) ) {
	function gutentype_theme_fonts_links() {
		$links = array();
		$google_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Google fonts: on or off', 'gutentype' ) );
		$custom_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Custom fonts (included in the theme): on or off', 'gutentype' ) );

		if ( ( $google_fonts_enabled || $custom_fonts_enabled ) && ! gutentype_storage_empty( 'load_fonts' ) ) {
			$load_fonts = (array)gutentype_storage_get( 'load_fonts' );
			if ( count( $load_fonts ) > 0 ) {
				$google_fonts = '';
				foreach ( $load_fonts as $font ) {
					$url = '';
					if ( $custom_fonts_enabled && empty( $font['styles'] ) ) {
						$slug = gutentype_get_load_fonts_slug( $font['name'] );
						$url  = gutentype_get_file_url( sprintf( 'css/font-face/%s/stylesheet.css', $slug ) );
						if ( ! empty( $url ) ) {
							$links[ $slug ] = $url;
						}
					}
				}
			}
		}
		return $links;
	}
//}


function lighten_fontello() {
    if ( ! is_admin()) {
    wp_dequeue_style( 'fontello-icons' );
    
    wp_enqueue_style( 'fontello-icons', gutentype_get_file_url( 'css/font-icons/css/fontello-embedded-test.css' ), array(), null );
    }
}
add_action( 'wp_enqueue_scripts', 'lighten_fontello');
//function new_fontello() 
//add_action( 'wp_enqueue scripts', 'new_fontello' );


// Enqueue custom scripts =>>> 15 06 recopie fonction ds trx_addons.php car enfichable càd commence par
// if ( ! function_exists( 'gutentype_trx_addons_frontend_scripts' ) ) {
// ici viré if et commenté ligne qui indique d'aller chercher trx_addons.js car contient indics pour maps pas utiles et soulignées par google speeed insights
function gutentype_trx_addons_frontend_scripts() {
		if ( gutentype_exists_trx_addons() ) {
			if ( gutentype_is_on( gutentype_get_theme_option( 'debug_mode' ) ) ) {
// ici commenté pour test
//				 $gutentype_url = gutentype_get_file_url( 'plugins/trx_addons/trx_addons.js' );
// on garde le reste
				if ( '' != $gutentype_url ) {
					wp_enqueue_script( 'gutentype-trx-addons', $gutentype_url, array( 'jquery' ), null, true );
				}
			}
		}
	}
add_action( 'wp_enqueue_scripts', 'gutentype_trx_addons_frontend_scripts' );
//ne pas oublier de refermer if avec crochet
// }


/* ajout defer a differents scripts tuto thibaut soufflet . fr 13 06*/
/*
function add_defer_attribute($tag, $handle) {
  // ajouter les handles de mes scripts au array ci-dessous. Ici 3 scripts par exemple.
  $scripts_to_defer = array('nom-script-1', 'nom-script-2', 'nom-script-3' );
  foreach($scripts_to_defer as $defer_script) {
    if ($defer_script === $handle) {
      return str_replace(' src', ' defer="defer" src', $tag);
    }
  }
  return $tag;
}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);
*/