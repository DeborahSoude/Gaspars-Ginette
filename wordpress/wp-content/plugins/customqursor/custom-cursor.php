<?php
/**
 * Plugin Name: Curseur personnalisé
 * Description: Modules Elementor pour concevoir une curseur personnalisé
 * Plugin URI:  https://d-impulse.com/
 * Version:     1
 * Author:      D-Impulse Developer
 * Author URI:  https://d-impulse.com/
 * Text Domain: custom-cursor
 * 
 * Elementor tested up to: 3.23.4
 * Elementor Pro tested up to: 3.13.1
 */

namespace D_Impulse_Custom_Cursor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//Une fois que elementor est chargé, execute le fichier
add_action( 'elementor/init', function() {
    require_once( __DIR__ . '/includes/admin-page.php');
} );

//Ajouter les scripts dans le footer
add_action( 'wp_footer', function(){

    //Ne pas l'appliquer dans l'admin
    if ( is_admin() ) {
        return;
    }

    // On récupère l'instance d'élémentor pour récupérer le contenu d'un élément élémentor
    $pluginElementor = \Elementor\Plugin::instance();
    $option = get_option( 'dimpulse_custom_qursor_options' );

    if ($option) {
        ?>
            <div id="cursor">
                <?php foreach ( $option['default'] as $i => $val ) : 
                    if ( $val !== '' && $val !== 'default' ) : ?>
                        <div data-class="<?php echo $val; ?>">
                            <?php echo $pluginElementor->frontend->get_builder_content( $option['default'][ $i ] ); ?>
                        </div>
                    <?php else :?>
                        <span class="point"></span>
                    <?php endif; 
                endforeach; ?>
            </div>
        <?php
    }
    

});

add_action( 'wp_enqueue_scripts', function(){
    $option = get_option( 'dimpulse_custom_qursor_options' );
    $pluginElementor = \Elementor\Plugin::instance();
    $defaultCursor = '<span class="point"></span>';

    if (!$option) {
        return;
    }

    wp_enqueue_style( 'customqursor', plugins_url() . '/customqursor/assets/style.css' );
    wp_enqueue_script( 'customqursor', plugins_url() . '/customqursor/assets/script.js', [], false, [ 'in_footer' => true ] );
    wp_localize_script( 'customqursor', 'adminHoverTemplate', [
        'default' => $option['default'][0] !== 'default' ? $pluginElementor->frontend->get_builder_content( $option['default'][0] ) : $defaultCursor,
        'defaultColor' => $option['color'][0],
        'cursor1' => [
            'class' => $option['class'][0] !== '' ? $option['class'][0] : null,
            'template' => $option['template'][0] !== 'noneCursor' ? $pluginElementor->frontend->get_builder_content( $option['template'][0]) : null,
        ],
        'cursor2' => [
            'class' => $option['class'][1] !== '' ? $option['class'][1] : null,
            'template' => $option['template'][1] !== 'noneCursor' ? $pluginElementor->frontend->get_builder_content( $option['template'][1]) : null,
        ],
        'cursor3' => [
            'class' => $option['class'][2] !== '' ? $option['class'][2] : null,
            'template' => $option['template'][2] !== 'noneCursor' ? $pluginElementor->frontend->get_builder_content( $option['template'][2]) : null,
        ],
    ] );
});


add_action('admin_print_styles', function() {
    wp_enqueue_style('admin_css', plugins_url() . '/customqursor/assets/admin-settings.css');
}, 11);

