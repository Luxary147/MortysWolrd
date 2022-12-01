<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'neve_child_load_css' ) ):
	/**
	 * Load CSS file.
	 */
	function neve_child_load_css() {
		wp_enqueue_style( 'neve-child-style', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'neve-style' ), NEVE_VERSION );
	}
endif;
add_action( 'wp_enqueue_scripts', 'neve_child_load_css', 20 );



/*
**   Fuentes personalizadas
*/

function add_custom_font() { 
	?>
	<style type="text/css">
	
@font-face {
    font-family: 'HelveticaNowDisplayBold';
    src: url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Bold.eot');
    src: url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Bold.eot?#iefix') format('embedded-opentype'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Bold.woff2') format('woff2'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Bold.woff') format('woff'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Bold.ttf') format('truetype'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Bold.svg#HelveticaNowDisplay-Bold') format('svg');
    font-weight: bold;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'HelveticaNowDisplay';
    src: url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Regular.eot');
    src: url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Regular.eot?#iefix') format('embedded-opentype'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Regular.woff2') format('woff2'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Regular.woff') format('woff'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Regular.ttf') format('truetype'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Regular.svg#HelveticaNowDisplay-Regular') format('svg');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'HelveticaNowDisplayMedium';
    src: url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Medium.eot');
    src: url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Medium.eot?#iefix') format('embedded-opentype'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Medium.woff2') format('woff2'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Medium.woff') format('woff'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Medium.ttf') format('truetype'),
        url('/wp-content/themes/neve-child-master/fonts/HelveticaNowDisplay-Medium.svg#HelveticaNowDisplay-Medium') format('svg');
    font-weight: 500;
    font-style: normal;
    font-display: swap;
}


	</style>
	<?php
}
add_action( 'wp_head', 'add_custom_font' );
add_action( 'customize_controls_print_styles', 'add_custom_font' );


function add_custom_fonts( $localized_data ) {
	$localized_data['fonts']['Custom'][] = 'HelveticaNowDisplay';
	$localized_data['fonts']['Custom'][] = 'HelveticaNowDisplayBold';
	$localized_data['fonts']['Custom'][] = 'HelveticaNowDisplayMedium';
	return $localized_data;
}
add_filter( 'neve_react_controls_localization', 'add_custom_fonts' );





add_filter('cartContent', 'add_custom_content');

function add_custom_content($content){

	if ( ! is_page('MortyWorld') ) return $content;

	$html = get_data_api();
	return $content.$html;
}

// Función que se encarga de recuperar los datos de la API externa
function get_data_api(){
	$url = 'https://rickandmortyapi.com/api/character/1,2,3,4,5,6';
	$response = wp_remote_get($url);


    //Si falla retorna un error
	if (is_wp_error($response)) {
		error_log("Error: ". $response->get_error_message());
		return false;
	}

	$body = wp_remote_retrieve_body($response);

	$data = json_decode($body);

	$template = '<div class="coleccion">
					{data}
				</div>';

    $html = $body;
	// if ( $data ){
	// 	$str = '';
		/*foreach ($data as $Mortys) {
			$str .= "<tr>";
			$str .= "<td><img src='{$wine->image}' width='20'/></td>";
			$str .= "<td>{$wine->winery}</td>";
			$str .= "<td>{$wine->wine}</td>";
			$str .= "<td>{$wine->rating->average}</td>";
			$str .= "<td>{$wine->location}</td>";
			$str .= "</tr>";
		}*/
	// }

	/*$html = str_replace('{data}', $str, $template);*/

	return $html;
}