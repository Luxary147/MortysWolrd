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





add_filter('the_content', 'add_personajes_C137');

function add_personajes_C137($content){

	if ( ! is_page('tienda') ) return $content;

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

	$template = '<div class="coleccion">
					{data}
				</div>';

	 if ( $data ){
	 	$str = '';
         $cantidad=count($data);
         print_r($data);
		foreach ($data as $C_137) {
			$str .= '<div class="ReusableCard">';
			$str .= "<img src='{$C_137->image}'>";
			$str .= "<p class='Cardname'>{$C_137->name}</p>";
            $str .= "<p class='Speciename'>Especie: {$C_137->species}</p>";
            $str .= "<p class='Cardname'>{$cantidad}</p>";
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

	$template = '<div class="Episodio">
					{data}
				</div>';


	 if ( $T1Json ){
	 	$str = '';
        $str .= '<h2> Primera Temporada </h2>';
		foreach ( $T1Json as $episode) {
			$str .= '<div class="Temporada">';
			$str .= "<p class='id'>{$episode->id}</p>";
            $str .= "<p class='name'>{$episode->name}</p>";
            $str .= "<p class='salida'>{$episode->air_date}</p>";
            /* A lo mejor agrgo algo mas aqui
            $str .= "<p class='id'>{$episode->id}</p>";
            */
			$str .= "</div>";
            
		}
	 }
     
     if ( $T2Json ){           
        $str .= '<h2> Segunda Temporada </h2>';
       foreach ( $T2Json as $episode) {
           $str .= '<div class="Temporada">';
           $str .= "<p class='id'>{$episode->id}</p>";
           $str .= "<p class='name'>{$episode->name}</p>";
           $str .= "<p class='salida'>{$episode->air_date}</p>";
           /* A lo mejor agrgo algo mas aqui
           $str .= "<p class='id'>{$episode->id}</p>";
           */
           $str .= "</div>";
           
       }
    }
    if ( $T3Json ){
        $str .= '<h2> Tercera Temporada </h2>';
       foreach ( $T3Json as $episode) {
           $str .= '<div class="Temporada">';
           $str .= "<p class='id'>{$episode->id}</p>";
           $str .= "<p class='name'>{$episode->name}</p>";
           $str .= "<p class='salida'>{$episode->air_date}</p>";
           /* A lo mejor agrgo algo mas aqui
           $str .= "<p class='id'>{$episode->id}</p>";
           */
           $str .= "</div>";
           
       }
    }
    if ( $T4Json ){
        $str .= '<h2> Cuarta Temporada </h2>';
       foreach ($T4Json as $episode) {
           $str .= '<div class="Temporada">';
           $str .= "<p class='id'>{$episode->id}</p>";
           $str .= "<p class='name'>{$episode->name}</p>";
           $str .= "<p class='salida'>{$episode->air_date}</p>";
           /* A lo mejor agrgo algo mas aqui
           $str .= "<p class='id'>{$episode->id}</p>";
           */
           $str .= "</div>";
           
       }
    }
    if ( $T5Json ){           
        $str .= '<h2> Quinta Temporada </h2>';
       foreach ( $T5Json as $episode) {
           $str .= '<div class="Temporada">';
           $str .= "<p class='id'>{$episode->id}</p>";
           $str .= "<p class='name'>{$episode->name}</p>";
           $str .= "<p class='salida'>{$episode->air_date}</p>";
           /* A lo mejor agrgo algo mas aqui
           $str .= "<p class='id'>{$episode->id}</p>";
           */
           $str .= "</div>";
           
       }
    }


	$html = str_replace('{data}', $str, $template);

	return $html;
}


/*Listar todos los mortys <existentes></existentes>*/

// add_filter('the_content', 'add_mortys');

// function add_mortys($content){

// 	if ( ! is_page('MortyWorld') ) return $content;

// 	$html = get_Mortys();
// 	return $content.$html;
// }

// // Función que se encarga de recuperar los datos de la API externa
// function get_Mortys(){

//     /*resetear variables*/
//     $id=1;
//     $str = '';
//     $bloque = '';

//     $template = '<div class="coleccion">
//                     {data}
//                 </div>';


//     while ($id <= 4) {
//         echo ($id);
//         $urlMortys = "https://rickandmortyapi.com/api/character/?page={$id}&name=morty";

//         $responseMorty = wp_remote_get($urlMortys);

//         //Si falla retorna un error
//         if (is_wp_error($responseMorty)) {
//             error_log("Error: ". $responseMorty->get_error_message());
//             return false;
//         }

// 	$body = wp_remote_retrieve_body($responseMorty);

// 	$data = json_decode($body);

//     print_r($data);

// 	 if ( $data ){
// 		foreach ($data as $InfoMorty) {
// 			$str .= '<div class="MortyCard">';
// 			$str .= "<img src='{$InfoMorty->image}'>";
// 			$str .= "<p class='Cardname'>{$InfoMorty->name}</p>";
//             $str .= "<p class='Speciename'>Especie: {$InfoMorty->species}</p>";
//             $str .= "<p class='Status'>Estado : {$InfoMorty->status}</p>";
// 			$str .= "</div>";
            
// 		}
// 	 }

//     $id=$id +1;
//     }
    
// 	$html = str_replace('{data}', $str, $template);

// 	return $html;
// }


add_filter('the_content', 'add_Mortys');

function add_Mortys($content){

	if ( ! is_page('MortyWorld') ) return $content;

	$html = get_morty();
	return $content.$html;
}

// Función que se encarga de recuperar los datos de la API externa
function get_morty(){

	$url = "https://rickandmortyapi.com/api/character/?name=morty";
    
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

	 if ( $data ){
	 	$str = '';
        $controlador=0;


		foreach ($data as $allMorty) {

            if ($controlador == 1 ){

                foreach($allMorty as $InfoMorty){
                $str .= '<div class="MortyCard">';
                $str .= "<img src='{$InfoMorty->image}'>";
                $str .= "<p class='Cardname'>{$InfoMorty->name}</p>";
                $str .= "<p class='Speciename'>Especie: {$InfoMorty->species}</p>";
                $str .= "<p class='Status'>Estado : {$InfoMorty->status}</p>";
                $str .= "</div>";
                }
             }else{
                 $controlador=1;
             }

        }
		}
	 


	$html = str_replace('{data}', $str, $template);

	return $html;
}