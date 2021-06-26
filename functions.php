<?php
/**
 * Child-Theme functions and definitions
 */



function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );




//if ( ! function_exists( 'gutentype_customizer_theme_setup1' ) ) {
  add_filter( 'after_setup_theme', 'gutentype_customizer_theme_setup1', 1 );
// add_filter( 'after_setup_theme', 'gutentype_customizer_theme_setup_child', 1 );

  function gutentype_customizer_theme_setup1($arr) {

    // -----------------------------------------------------------------
    // -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
    // -- Internal theme settings
    // -----------------------------------------------------------------
    $arr = array();
    gutentype_storage_set(
     'settings', array(

        'duplicate_options'      => 'child',            // none  - use separate options for the main and the child-theme
                                // child - duplicate theme options from the main theme to the child-theme only
                                // both  - sinchronize changes in the theme options between main and child themes

        'customize_refresh'      => 'auto',             // Refresh method for preview area in the Appearance - Customize:
                                // auto - refresh preview area on change each field with Theme Options
                                // manual - refresh only obn press button 'Refresh' at the top of Customize frame

        'max_load_fonts'         => 5,                  // Max fonts number to load from Google fonts or from uploaded fonts

        'comment_after_name'     => true,               // Place 'comment' field after the 'name' and 'email'

        'icons_selector'         => 'internal',         // Icons selector in the shortcodes:
                                // vc (default) - standard VC (very slow) or Elementor's icons selector (not support images and svg)
                                // internal - internal popup with plugin's or theme's icons list (fast and support images and svg)

        'icons_type'             => 'icons',            // Type of icons (if 'icons_selector' is 'internal'):
                                // icons  - use font icons to present icons
                                // images - use images from theme's folder trx_addons/css/icons.png
                                // svg    - use svg from theme's folder trx_addons/css/icons.svg

        'socials_type'           => 'icons',            // Type of socials icons (if 'icons_selector' is 'internal'):
                                // icons  - use font icons to present social networks
                                // images - use images from theme's folder trx_addons/css/icons.png
                                // svg    - use svg from theme's folder trx_addons/css/icons.svg

        'check_min_version'      => true,               // Check if exists a .min version of .css and .js and return path to it
                                // instead the path to the original file
                                // (if debug_mode is off and modification time of the original file < time of the .min file)

        'autoselect_menu'        => false,              // Show any menu if no menu selected in the location 'main_menu'
                                // (for example, the theme is just activated)

        'disable_jquery_ui'      => false,              // Prevent loading custom jQuery UI libraries in the third-party plugins

        'use_mediaelements'      => false,               // Load script "Media Elements" to play video and audio

        'tgmpa_upload'           => false,              // Allow upload not pre-packaged plugins via TGMPA

        'allow_no_image'         => false,              // Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.
// set to false 26 06 21 pour voir si fonctionne
        'separate_schemes'       => false,               // Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

        'allow_fullscreen'       => false,              // Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
                                // In the Page Options this styles are present always
                                // (can be removed if filter 'gutentype_filter_allow_fullscreen' return false)

        'attachments_navigation' => false,              // Add arrows on the single attachment page to navigate to the prev/next attachment

        'gutenberg_add_context'  => true,              // Add context to the Gutenberg editor styles with our method (if true - use if any problem with editor styles) or use native Gutenberg way via add_editor_style() (if false - used by default)

        'gutenberg_safe_mode'    => array('elementor'), // vc,elementor - Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)
       )
    );
  return $arr;
}



function deregister_styles_mediaelement() {
	wp_deregister_style('mediaelement');
	wp_deregister_style('wp-mediaelement');
//	wp_deregister_script('mediaelement');
//	wp_deregister_script('wpmediaelement');
}
//add_action('wp_enqueue_scripts', 'dequeue_scripts_styles_mediaelement');
//add_action('after_setup_theme', 'deregister_styles_mediaelement');

function deregister_scripts_mediaelement() {
//	wp_deregister_style('mediaelement');
//	wp_deregister_style('wp-mediaelement');
	wp_deregister_script('mediaelement');
	wp_deregister_script('wpmediaelement');
}
//add_action('wp_enqueue_scripts', 'deregister_scripts_mediaelement');
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
