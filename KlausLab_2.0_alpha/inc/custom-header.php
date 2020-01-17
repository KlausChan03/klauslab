<?php
/**
 * @package KlausLab
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses KlausLab_header_style()
 * @uses KlausLab_admin_header_style()
 * @uses KlausLab_admin_header_image()
 */
function KlausLab_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'KlausLab_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '495762',
		'width'                  => 1600,
		'height'                 => 420,		
		'default-image'      => get_parent_theme_file_uri( '/img/header.jpg' ),
		'flex-height'            => true,
		'wp-head-callback'       => 'KlausLab_header_style',
		'admin-head-callback'    => 'KlausLab_admin_header_style',
		'admin-preview-callback' => 'KlausLab_admin_header_image',
	) ) );
	
	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/img/header.jpg',
			'thumbnail_url' => '%s/img/header.jpg',
			'description'   => __( 'Default Header Image', 'KlausLab' ),
		),
	) );
	
}
add_action( 'after_setup_theme', 'KlausLab_custom_header_setup' );

if ( ! function_exists( 'KlausLab_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see KlausLab_custom_header_setup().
 */
function KlausLab_header_style() {
	$header_text_color = get_header_textcolor();
	$header_image = get_header_image();

	if ( $header_image ) : ?>

		<script id="custom-header-image">
			/*
			$(document).ready(function(){
				let $dom = $(".swiper-wrapper").children();
				$dom.css({"background-image":"url( 
				<?
				// php echo esc_url( $header_image ); 
				?>
				)",
				"background-position":"center",
				"background-size":"cover"})
			})
			*/

		</script>

		<style type="text/css" id="custom-header-image">
	      .site-branding:before {
	        background-image: url( <?php echo esc_url( $header_image ); ?>);
	        background-position: center;
	        background-repeat: no-repeat;
	        background-size: cover;
	        content: "";
	        display: block;
	        position: absolute;
	        top: 0;
	        left: 0;
	        width: 100%;
	        height: 100%;
	        z-index:-1;
	      }
	    </style>

		
	<?php
	endif;

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value.
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // KlausLab_header_style

if ( ! function_exists( 'KlausLab_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see KlausLab_custom_header_setup().
 */
function KlausLab_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // KlausLab_admin_header_style

if ( ! function_exists( 'KlausLab_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see KlausLab_custom_header_setup().
 */
function KlausLab_admin_header_image() {
?>
	<div id="headimg">
		<h1 class="displaying-header-text">
			<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // KlausLab_admin_header_image
