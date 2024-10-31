<?php
/*
Plugin Name:  Promaker Slider
Description:  Slider administrable en la página de inicio
Version:      1.0
Author:       Jonathan Peralta | Promaker
Author URI:   https://promaker.com.ar
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/
/*===== Assets slider =====*/
function promaker_slider_assets() {
    if ( is_front_page() && get_field( 'activar_slider', 'option' ) == 1 ):
        wp_enqueue_style( 'promaker_slider', plugin_dir_url( __FILE__ ) . 'css/promaker-slider.min.css', 2.4, false );
        wp_enqueue_style( 'promaker_owl', plugin_dir_url( __FILE__ ) . 'css/owl.carousel.min.css', 2.3, false );
        wp_enqueue_script( 'promaker_owl', plugin_dir_url( __FILE__ ) . 'js/owl.carousel.min.js', array('jquery'), false );
    endif;
}
add_action( 'wp_enqueue_scripts', 'promaker_slider_assets' );
/*===== HTML slider homepage =====*/
function promaker_slider_html( $content ) {
    if ( is_front_page() ) {
        if ( get_field( 'activar_slider', 'option' ) == 1 ): ;
            if ( have_rows( 'slider', 'option' ) ): ;
                $navs = get_field( 'navs', 'option' );
                $navs_mobile = get_field( 'navs_mobile', 'option' );
                $dots = get_field( 'dots', 'option' );
                $dots_mobile = get_field( 'dots_mobile', 'option' );
                $woodmart =  get_field( 'woodmart', 'option' );
                $navs_style = get_field( 'navs_style', 'option' );
                $dots_style = get_field( 'dots_style', 'option' );
                $slider .= '<section class="promaker-slider'. ( $woodmart == 1 ? ' woodmart' : '' ) . ( $navs == 0 ? ' promaker-slider-no-navs-desktop' : '' ) . ( $dots == 0 ? ' promaker-slider-no-dots-desktop' : '' ) . ( $navs_mobile == 0 ? ' promaker-slider-no-navs-mobile' : '' ) . ( $dots_mobile == 0 ? ' promaker-slider-no-dots-mobile' : '' ) . ( $navs_style == 'Estilo 1' ? ' promaker-slider-nav-style-1' : '' ) . ( $navs_style == 'Estilo 2' ? ' promaker-slider-nav-style-2' : '' ) . ( $navs_style == 'Estilo 3' ? ' promaker-slider-nav-style-3' : '' ) . ( $navs_style == 'Estilo 4' ? ' promaker-slider-nav-style-4' : '' ) . ( $navs_style == 'Estilo 5' ? ' promaker-slider-nav-style-5' : '' ) . ( $dots_style == 'Estilo 1' ? ' promaker-slider-dots-style-1' : '' ) . ( $dots_style == 'Estilo 2' ? ' promaker-slider-dots-style-2' : '' ) . ( $dots_style == 'Estilo 3' ? ' promaker-slider-dots-style-3' : '' ) . ( $dots_style == 'Estilo 4' ? ' promaker-slider-dots-style-4' : '' ) . ( $dots_style == 'Estilo 5' ? ' promaker-slider-dots-style-5' : '' ) . '">';
                $slider .= '<div class="promaker-slider-owl owl-carousel">';
                    while ( have_rows( 'slider', 'option' ) ): the_row() ;
                        $imagen_desktop = get_sub_field( 'imagen_desktop' );
                        $imagen_mobile = get_sub_field( 'imagen_mobile' );
                        $imagen_pc = $imagen_desktop['url'];
                        $imagen_reponsive = $imagen_mobile['url'];
                        $enlace = get_sub_field( 'enlace' );
                        $enlace_link = $enlace['url'];
                        $enlace_target = $enlace['target'];
                        if ( $enlace ) { ;
                            $slider .= '<a href="'. $enlace_link .'" target="'. $enlace_target .'">';
                        };
                        $slider .= '<div class="promaker-slider-item">';
                        $slider .= '<picture>';
                        $slider .= '<source media="(min-width: 992px)" srcset="'. $imagen_pc .'">';
                        $slider .= '<source media="(max-width: 991px)" srcset="'. $imagen_reponsive .'">';
                        $slider .= '<img src="'. $imagen_pc .'" alt="promaker-slider-item" width="100%" />';
                        $slider .= '</picture>';
                        $slider .= '</div>';
                        if ( $enlace ) { ;
                            $slider .= '</a>';
                        };
                    endwhile;
                $slider .= '</div>';
                $slider .= '</section>';
            endif;
        endif;
        return $slider . $content;
    } else {
        return $content;
    }
}; 
add_filter( 'the_content', 'promaker_slider_html', 10, 1 );
/*===== Panel de opciones slider =====*/
if ( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> '<img src="' . plugin_dir_url( __FILE__ ) . 'logo.png">&nbsp;Promaker Slider <b>v1.0</b>',
		'menu_title'	=> 'Promaker Slider',
		'menu_slug' 	=> 'promaker-slider',
		'icon_url'		=>  '' . plugin_dir_url( __FILE__ ) . 'logo.png',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'update_button'		=> 'Actualizar', 'acf',
		'updated_message'		=> "Los cambios se han guardado con éxito!", 'acf'
	));
};
/*===== Config slider =====*/
add_action( 'wp_print_footer_scripts', function () { ?>
    <?php
        $navs = get_field( 'navs', 'option' );
        $navs_mobile = get_field( 'navs_mobile', 'option' );
        $dots = get_field( 'dots', 'option' );
        $dots_mobile = get_field( 'dots_mobile', 'option' );
        $autoplay = get_field( 'autoplay', 'option' );
        $autoplay_timeout = get_field( 'autoplay_timeout', 'option' );
        $loop = get_field( 'loop', 'option' );
        $items_mobile = get_field( 'items_mobile', 'option' );
        $item_desktop = get_field( 'items_desktop', 'option' );
    ?>
    <?php if ( is_front_page() && get_field( 'activar_slider', 'option' ) == 1 ): ?>
        <script>
            jQuery(document).ready(function($) {
                var promaker_slider = $('.promaker-slider-owl');
                promaker_slider.owlCarousel({
                    loop: <?php if ( $loop == 1 ): ?>true<?php else: ?>false<?php endif; ?>,
                    navText: ["<img src='<?php echo plugin_dir_url( __FILE__ ).'arrow.svg'; ?>' alt='arrow' width='24' />","<img src='<?php echo plugin_dir_url( __FILE__ ).'arrow.svg'; ?>' alt='arrow' width='24' />"],
                    autoplay: <?php if ( $autoplay == 1 ): ?>true<?php else: ?>false<?php endif; ?>,
                    <?php if ( $autoplay ): ?>
                        autoplayTimeout: <?php echo esc_js( $autoplay_timeout ); ?>,
                    <?php endif; ?>
                    responsive: {
                        "0": { 
                            items: <?php echo esc_js( $items_mobile ); ?>,
                            nav: <?php if ( $navs_mobile == 1 ): ?>true<?php else: ?>false<?php endif; ?>,
                            dots: <?php if ( $dots_mobile == 1 ): ?>true<?php else: ?>false<?php endif; ?>
                        }, 
                        "992": { 
                            items: <?php echo esc_js( $item_desktop ); ?>,
                            nav: <?php if ( $navs == 1 ): ?>true<?php else: ?>false<?php endif; ?>,
                            dots: <?php if ( $dots == 1 ): ?>true<?php else: ?>false<?php endif; ?>
                        }
                    }
                });
            });
        </script>
    <?php endif; ?>
<?php } );
/*===== Requisito de ACF =====*/
add_action('plugins_loaded', function () {
    require_once(ABSPATH . '/wp-admin/includes/plugin.php');
    if ( !is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
        deactivate_plugins('promaker-sliders/promaker.php');
        add_action('admin_notices', 'promaker_slider_aviso');
    }
});
function promaker_slider_aviso() {
    echo '<div class="error"><p>Para utilizar <strong>Promaker Slider</strong> por favor activa o instala <strong>"Advanced Custom Fields PRO (+5.8.8)"</strong>.</p></div>';
}
/*===== Campos ACF =====*/
if ( function_exists('acf_add_local_field_group') ):
    acf_add_local_field_group(array(
        'key' => 'group_639912bb7a9a3',
        'title' => 'Opciones slider',
        'fields' => array(
            array(
                'key' => 'field_6399d212f7705',
                'label' => '<span class="dashicons dashicons-admin-generic"></span> Configuración',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'left',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_63991738c4ce4',
                'label' => '<span class="dashicons dashicons-visibility"></span> Activar slider',
                'name' => 'activar_slider',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_63991347fc9f5',
                'label' => '<span class="dashicons dashicons-admin-settings"></span> Woodmart theme activo',
                'name' => 'woodmart',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_6399d29df7707',
                'label' => '<span class="dashicons dashicons-desktop"></span> Items desktop',
                'name' => 'items_desktop',
                'type' => 'number',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_6399d313f7708',
                'label' => '<span class="dashicons dashicons-smartphone"></span> Items mobile',
                'name' => 'items_mobile',
                'type' => 'number',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_6399d345f7709',
                'label' => '<span class="dashicons dashicons-controls-play"></span> Autoplay',
                'name' => 'autoplay',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_6399d372f770a',
                'label' => '<span class="dashicons dashicons-controls-forward"></span> Autoplay Timeout',
                'name' => 'autoplay_timeout',
                'type' => 'number',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_6399d345f7709',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_6399d41cf770b',
                'label' => '<span class="dashicons dashicons-controls-repeat"></span> Loop',
                'name' => 'loop',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_6399d448f770c',
                'label' => '<span class="dashicons dashicons-leftright"></span> Navs',
                'name' => 'navs',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_6399d460f770d',
                'label' => '<span class="dashicons dashicons-admin-appearance"></span> Navs style',
                'name' => 'navs_style',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Seleccionar opción' => 'Seleccionar opción',
                    'Estilo 1' => 'Estilo 1',
                    'Estilo 2' => 'Estilo 2',
                    'Estilo 3' => 'Estilo 3',
                    'Estilo 4' => 'Estilo 4',
                    'Estilo 5' => 'Estilo 5',
                ),
                'default_value' => array(
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value',
                'placeholder' => '',
            ),
            array(
                'key' => 'field_6399dad31dc99',
                'label' => '<span class="dashicons dashicons-smartphone"></span> Navs mobile',
                'name' => 'navs_mobile',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_6399d4b2f770e',
                'label' => '<span class="dashicons dashicons-ellipsis"></span> Dots',
                'name' => 'dots',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_6399d4dbf770f',
                'label' => '<span class="dashicons dashicons-admin-appearance"></span> Dots style',
                'name' => 'dots_style',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Seleccionar opción' => 'Seleccionar opción',
                    'Estilo 1' => 'Estilo 1',
                    'Estilo 2' => 'Estilo 2',
                    'Estilo 3' => 'Estilo 3',
                    'Estilo 4' => 'Estilo 4',
                    'Estilo 5' => 'Estilo 5',
                ),
                'default_value' => array(
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value',
                'placeholder' => '',
            ),
            array(
                'key' => 'field_6399db151dc9a',
                'label' => '<span class="dashicons dashicons-smartphone"></span> Dots mobile',
                'name' => 'dots_mobile',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_6399d259f7706',
                'label' => '<span class="dashicons dashicons-images-alt2"></span> Items',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'left',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_63991278fc9f1',
                'label' => '<span class="dashicons dashicons-format-image"></span> Slides',
                'name' => 'slider',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => 'field_639912b7fc9f2',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Añadir slide',
                'sub_fields' => array(
                    array(
                        'key' => 'field_639912b7fc9f2',
                        'label' => '<span class="dashicons dashicons-desktop"></span> Imagen desktop',
                        'name' => 'imagen_desktop',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'medium_large',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                    array(
                        'key' => 'field_639912e3fc9f3',
                        'label' => '<span class="dashicons dashicons-smartphone"></span> Imagen mobile',
                        'name' => 'imagen_mobile',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'medium_large',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                    array(
                        'key' => 'field_63991318fc9f4',
                        'label' => '<span class="dashicons dashicons-admin-links"></span> Enlace',
                        'name' => 'enlace',
                        'type' => 'link',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'promaker-slider',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
endif;