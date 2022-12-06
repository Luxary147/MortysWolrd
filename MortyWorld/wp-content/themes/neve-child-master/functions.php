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

add_action( 'wp_print_styles', function() {
    add_filter( 'neve_load_remote_fonts_locally', '__return_true' );
} );



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

@font-face {
font-family: 'Rick';
src: url('/wp-content/themes/neve-child-master/fonts/get_schwifty.woff') format('woff');
    font-weight: 500;
    font-style: normal;
}

@font-face {
font-family: 'Oneday';
src: url('/wp-content/themes/neve-child-master/fonts/ONEDAY.woff') format('woff'),
	url('/wp-content/themes/neve-child-master/fonts/ONEDAY.woff2') format('woff2'),
	url('/wp-content/themes/neve-child-master/fonts/ONEDAY.tff') format('truetype');
    font-weight: 500;
    font-style: normal;
}

@font-face {
font-family: 'Metropolis';
src: url('/wp-content/themes/neve-child-master/fonts/Metropolis.woff') format('woff');
    font-weight: 500;
    font-style: normal;
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



/*cargar <javascripts>*/


wp_enqueue_script('menu-sticky', '/wp-content/themes/neve-child-master/libs/menu-sticky.js', array('jquery'), '', true);

wp_enqueue_script('MostrarSpoilers', '/wp-content/themes/neve-child-master/libs/spoilers.js', array('jquery'), '', true);



/*funciones */

add_filter('the_content', 'add_personajes_C137');

function add_personajes_C137($content){

	if ( ! is_page('c-137') ) return $content;

	$html = get_data_api();
	return $content.$html;
}

// Función que se encarga de recuperar los datos de la API externa
function get_data_api(){
	$url = "https://rickandmortyapi.com/api/character/38,45,71,82,83,92,112,114,116,117,120,127,155,169,175,179,186,201,216,239,271,302,303,335,343,356,394";
	$response = wp_remote_get($url);


    //Si falla retorna un error
	if (is_wp_error($response)) {
		error_log("Error: ". $response->get_error_message());
		return false;
	}

	$body = wp_remote_retrieve_body($response);

	$data = json_decode($body);
    $cantidad=count($data);
	$template = "<div class='coleccion'>
                    <h2 class='habitantes'> Quantity importan people of C-137: {$cantidad}
					{data}
				</div>";

	 if ( $data ){
	 	$str = '';

		foreach ($data as $C_137) {
			$str .= '<div class="ReusableCard">';
			$str .= "<img src='{$C_137->image}'>";
			$str .= "<p class='Cardname'>{$C_137->name}</p>";
            $str .= "<p class='Speciename'Specie: {$C_137->species}</p>";
            $str .= "<p class='Status'>{$C_137->status}</p>";
			$str .= "</div>";
         
            
		}
	 }
// $str .= "<td>{$C_137->rating->average}</td>";

	$html = str_replace('{data}', $str, $template);

	return $html;
}


/*Cracioón de un listado de todos los <episodios></episodios>*/

add_filter('the_content', 'add_lista_episodios');

function add_lista_episodios($content){

	if ( ! is_page('Episodios') ) return $content;

	$html = get_episodes_api();
	return $content.$html;
}

// Función que se encarga de recuperar los datos de la API externa
function get_episodes_api(){

	$url = 'https://rickandmortyapi.com/api/episode/1,2,3,4,5,6,7,8,9,10,11';
    $url2 = 'https://rickandmortyapi.com/api/episode/12,13,14,15,16,17,18,19,20,21';
    $url3 = 'https://rickandmortyapi.com/api/episode/22,23,24,25,26,27,28,29,30,31';
    $url4 = 'https://rickandmortyapi.com/api/episode/32,33,34,35,36,37,38,39,40,41';
    $url5 = 'https://rickandmortyapi.com/api/episode/42,43,44,45,46,47,48,49,50,51,52';

	$response = wp_remote_get($url);
    $response2 = wp_remote_get($url2);
    $response3 = wp_remote_get($url3);
    $response4 = wp_remote_get($url4);
    $response5= wp_remote_get($url5);

    //Si falla retorna un error
	if (is_wp_error($response) || is_wp_error($response2) || is_wp_error($response3) || is_wp_error($response4)||is_wp_error($response5)){
		error_log("Error: ". $response->get_error_message());
		return false;
	}



	$T1String = wp_remote_retrieve_body($response);
    $T2String = wp_remote_retrieve_body($response2);
    $T3String = wp_remote_retrieve_body($response3);
    $T4String = wp_remote_retrieve_body($response4);
    $T5String = wp_remote_retrieve_body($response5);


	$T1Json = json_decode($T1String);
    $T2Json = json_decode($T2String);
    $T3Json = json_decode($T3String);
    $T4Json = json_decode($T4String);
    $T5Json = json_decode($T5String);

	$template = '<div class="Temporadas">
					{data}
				</div>';


	 if ( $T1Json ){
	 	$str = '';
        $str .= '<h2 id="ancla-T1"> First Season </h2>';
        $str .= '<div class="Episodios">';

		foreach ( $T1Json as $episode) {
			$str .= '<div class="Episodio">';
			$str .= "<p class='id'> Chapter {$episode->id}</p>";
            $str .= "<p class='name'> <u>Name</u>: {$episode->name}</p>";
            $str .= "<p class='salida'> <u>Premiere</u>: {$episode->air_date}</p>";
            /* A lo mejor agrego algo mas aqui
            $str .= "<p class='id'>{$episode->id}</p>";
            */
			$str .= "</div>";
            
		}
        $str .= "</div>";
        $str .= '<p id="ancla-T2"></p>';
	 }
     
     if ( $T2Json ){           
        $str .= '<h2> Second Season </h2>';
        $str .= '<div class="Episodios">';
       foreach ( $T2Json as $episode) {
        
           $str .= '<div class="Episodio">';
           $str .= "<p class='id'> Chapter {$episode->id}</p>";
           $str .= "<p class='name'> <u>Name</u>: {$episode->name}</p>";
           $str .= "<p class='salida'> <u>Premiere</u>: {$episode->air_date}</p>";
           /* A lo mejor agrego algo mas aqui
           $str .= "<p class='id'>{$episode->id}</p>";
           */
           $str .= "</div>";
           
           
       }
       $str .= "</div>";
       $str .= '<p id="ancla-T3"></p>';
    }
    if ( $T3Json ){
        $str .= '<h2 > Third Season </h2>';
        $str .= '<div class="Episodios">';

       foreach ( $T3Json as $episode) {
           $str .= '<div class="Episodio">';
           $str .= "<p class='id'> Chapter {$episode->id}</p>";
           $str .= "<p class='name'> <u>Name</u>: {$episode->name}</p>";
           $str .= "<p class='salida'>  <u>Premiere</u>: {$episode->air_date}</p>";
           /* A lo mejor agrego algo mas aqui
           $str .= "<p class='id'>{$episode->id}</p>";
           */
           $str .= "</div>";
           
           
       }
       $str .= "</div>";
       $str .= '<p id="ancla-T4"></p>';
    }
    if ( $T4Json ){
        $str .= '<h2> Fourth Season </h2>';
        $str .= '<div class="Episodios">';

       foreach ($T4Json as $episode) {
           $str .= '<div class="Episodio">';
           $str .= "<p class='id'> Chapter {$episode->id}</p>";
           $str .= "<p class='name'> <u>Name</u>: {$episode->name}</p>";
           $str .= "<p class='salida'> <u>Premiere</u>: {$episode->air_date}</p>";
           /* A lo mejor agrego algo mas aqui
           $str .= "<p class='id'>{$episode->id}</p>";
           */
           $str .= "</div>";
           
           
       }
       $str .= "</div>";
       $str .= '<p id="ancla-T5"></p>';
       
    }
    if ( $T5Json ){           
        $str .= '<h2> Fifth Season </h2>';
        $str .= '<div class="Episodios">';

       foreach ( $T5Json as $episode) {
           $str .= '<div class="Episodio">';
           $str .= "<p class='id'> Chapter {$episode->id}</p>";
           $str .= "<p class='name'> <u>Name</u>: {$episode->name}</p>";
           $str .= "<p class='salida'> <u>Premiere</u>: {$episode->air_date}</p>";
           /* A lo mejor agrego algo mas aqui
           $str .= "<p class='id'>{$episode->id}</p>";
           */
           $str .= "</div>";
           
           
       }
       $str .= "</div>";
    }


	$html = str_replace('{data}', $str, $template);

	return $html;
}


/*Listar todos los mortys <existentes></existentes>*/

add_filter('the_content', 'add_mortys');

function add_mortys($content){

	if ( ! is_page('MortyWorld') ) return $content;

	$html = get_Mortys();
	return $content.$html;
}

// Función que se encarga de recuperar los datos de la API externa
function get_Mortys(){

    /*resetear variables*/
    $id=1;
    $str = '';
    $bloque = '';

    $template = '<div class="wpb_column vc_column_container vc_col-sm-8 vc_col-lg-offset-1 vc_col-lg-10 vc_col-md-offset-1 vc_col-md-10 vc_col-sm-offset-2 vc_col-xs-12">
                    <div class="coleccion">
                    {data}
                    </div>
                </div>';


    while ($id <= 4) {

        $urlMortys = "https://rickandmortyapi.com/api/character/?page={$id}&name=morty";

        $responseMorty = wp_remote_get($urlMortys);

        //Si falla retorna un error
        if (is_wp_error($responseMorty)) {
            error_log("Error: ". $responseMorty->get_error_message());
            return false;
        }

	$body = wp_remote_retrieve_body($responseMorty);

	$data = json_decode($body);


	 if ( $data ){

        $controlador=0;

        	foreach ($data as $allMorty) {
        
                if ($controlador == 1 ){
        
                    foreach($allMorty as $InfoMorty){
                        $str .= '<div class="MortyCard">';
                        $str .= "<img src='{$InfoMorty->image}'>";
                        $str .= "<p class='Cardname'>{$InfoMorty->name}</p>";
                        $str .= "<p class='Speciename'>Specie: {$InfoMorty->species}</p>";
                        $str .= "<p class='Status'>Status : {$InfoMorty->status}</p>";
                        $str .= "</div>";
                        }
                     }else{
                         $controlador=1;
                     }
        
                }
	 }

    $id=$id +1;
    }
    
	$html = str_replace('{data}', $str, $template);

	return $html;
}


// add_filter('the_content', 'add_Mortys');

// function add_Mortys($content){

// 	if ( ! is_page('MortyWorld') ) return $content;

// 	$html = get_morty();
// 	return $content.$html;
// }

// Función que se encarga de recuperar los datos de la API externa
// function get_morty(){

// 	$url = "https://rickandmortyapi.com/api/character/?name=morty";
    
// 	$response = wp_remote_get($url);


//     Si falla retorna un error
// 	if (is_wp_error($response)) {
// 		error_log("Error: ". $response->get_error_message());
// 		return false;
// 	}

// 	$body = wp_remote_retrieve_body($response);

// 	$data = json_decode($body);

// 	$template = '<div class="coleccion">
// 					{data}
// 				</div>';

// 	 if ( $data ){
// 	 	$str = '';
//         $controlador=0;


// 		foreach ($data as $allMorty) {

//             if ($controlador == 1 ){

//                 foreach($allMorty as $InfoMorty){
//                 $str .= '<div class="MortyCard">';
//                 $str .= "<img src='{$InfoMorty->image}'>";
//                 $str .= "<p class='Cardname'>{$InfoMorty->name}</p>";
//                 $str .= "<p class='Speciename'>Especie: {$InfoMorty->species}</p>";
//                 $str .= "<p class='Status'>Estado : {$InfoMorty->status}</p>";
//                 $str .= "</div>";
//                 }
//              }else{
//                  $controlador=1;
//              }

//         }
// 		}
	 


// 	$html = str_replace('{data}', $str, $template);

// 	return $html;
// }

add_filter('the_content', 'add_ricks');

function add_ricks($content){

	if ( ! is_page('RickWorld') ) return $content;

	$html = get_Ricks();
	return $content.$html;
}

// Función que se encarga de recuperar los datos de la API externa
function get_ricks(){

    /*resetear variables*/
    $id=1;
    $str = '';
    $bloque = '';

    $template = '<div class="wpb_column vc_column_container vc_col-sm-8 vc_col-lg-offset-1 vc_col-lg-10 vc_col-md-offset-1 vc_col-md-10 vc_col-sm-offset-2 vc_col-xs-12">
                    <div class="coleccion">
                    {data}
                    </div>
                </div>';


    while ($id <= 6) {

        $urlRicks = "https://rickandmortyapi.com/api/character/?page={$id}&name=rick";

        $responseRick = wp_remote_get($urlRicks);

        //Si falla retorna un error
        if (is_wp_error($responseRick)) {
            error_log("Error: ". $responseRick->get_error_message());
            return false;
        }

	$body = wp_remote_retrieve_body($responseRick);

	$data = json_decode($body);


	 if ( $data ){

        $controlador=0;

        	foreach ($data as $allRick) {
        
                if ($controlador == 1 ){
        
                    foreach($allRick as $InfoRick){
                        $str .= '<div class="RickCard">';
                        $str .= "<img src={$InfoRick->image} alt='img error'>";
                        $str .= "<p class='Cardname'>{$InfoRick->name}</p>";
                        $str .= "<p class='Speciename'>Specie: {$InfoRick->species}</p>";
                        $str .= "<p class='Status'>Status : {$InfoRick->status}</p>";
                        $str .= "</div>";
                        }

                     }else{
                         $controlador=1;
                     }
        
                }
	 }

    $id=$id +1;
    }
    
	$html = str_replace('{data}', $str, $template);

	return $html;
}


// add_filter( 'gettext_dynamic_sidebar_after', 'modificar_texto_copyright' );

// function modificar_texto_copyright() {

//         return __( 'Copyright Lackern Dark Proyect 2022', 'gettext_dynamic_sidebar_after' );

// }
