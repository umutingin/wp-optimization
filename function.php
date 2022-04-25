//Find Handles
add_filter( 'script_loader_tag', 'cameronjonesweb_add_script_handle', 10, 3 );
function cameronjonesweb_add_script_handle( $tag, $handle, $src ) {
	return str_replace( '<script', sprintf(
		'<script data-handle="%1$s"',
		esc_attr( $handle )
	), $tag );
}
//Defer Javascript
add_filter( 'script_loader_tag', 'wsds_defer_scripts', 10, 3 );
function wsds_defer_scripts( $tag, $handle, $src ) {
	$defer_scripts = array( 
		'admin-bar', //using handles
		'query-monitor',
		'contact-form-7',
		'tp-tools',
		'revmin',
		'cookie-notice-front',
		'wpb_composer_front_js',
		'wd-device-library',
		'imagesloaded',
		'wc-add-to-cart',
		'vc_woocommerce-add-to-cart-js',
		'wd-update-cart-fragments-fix',
		'regenerator-runtime',
		'wp-polyfill',
		'js-cookie',
		'woocommerce',
		'wc-cart-fragments',
		'woodmart-theme',
		'wd-autocomplete-library',
		'underscore',
		'wp-util',
		'wc-add-to-cart-variation',
		'wd-owl-library',
		'wd-magnific-library',
		'wd-tooltips-library',
		'wd-panr-parallax-bundle-library',
		//'jquery-core',
		//'jquery-blockui',
		'google_gtagjs',
		'gtm4wp-form-move-tracker',
	);
    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
    }
    return $tag;
}


//Defer JavaScript
function defer_parsing_of_js( $url ) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.min.js?ver=3.6.0' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );
}
add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );


//Preloading CSS
function preload_for_css ( $html, $handle, $href, $media ) {
    if ( is_admin () )
    {
        return $html;
    }
    echo '<link rel="stylesheet preload" as="style" href="' . $href . '" media="all">';
}
add_filter ( 'style_loader_tag', 'preload_for_css', 10, 4 );


//Preload Font Awesome CSS
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
function my_enqueue_scripts() {
    wp_enqueue_style('my-style-handle',
        '/wp-content/plugins/revslider/public/assets/fonts/font-awesome/css/font-awesome.css', array(), null);
}
add_filter('style_loader_tag', 'my_style_loader_tag_filter', 10, 2);
function my_style_loader_tag_filter($html, $handle) {
    if ($handle === 'my-style-handle') {
        return str_replace("rel='stylesheet'",
            "rel='preload' as='font' type='font/woff2' crossorigin='anonymous'", $html);
    }
    return $html;
}
