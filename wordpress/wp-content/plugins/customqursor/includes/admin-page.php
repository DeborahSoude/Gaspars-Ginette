<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function custom_qursor_admin_page() {
    ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'dimpulse_custom_qursor' );
                do_settings_sections( 'dimpulse_custom_qursor' );
                submit_button( 'Enregistrer les modifications' );
                ?>
            </form>
        </div>
    <?php
}

// Créé un champ pour définir la class et un champ qui récupère la liste des modèles. 
function custom_qursor_fields() {
    $options = get_option( 'dimpulse_custom_qursor_options' );
    $templates = get_posts(['post_type' => 'elementor_library']);
    ?>
        <h3>Curseur par défaut</h3>
        <p>Choisissez le modèle de curseur personnalisé par défaut. Si aucun modèle n'est sélectionné, un petit point noir sera utilisé automatiquement.</p>
        <div>
            <select name="dimpulse_custom_qursor_options[default][]">
                <option value="default">Curseur par défaut</option>
                <?php foreach ( $templates as $template ) { ?>
                    <?php if ( $template->post_title !== "Kit par défaut" ) { ?>
                        <option value="<?php echo $template->ID; ?>" <?php if ( isset( $options['default'][1] ) ) selected( $options['template'], $template->ID ); ?>> <?php echo $template->post_title; ?> </option>
                    <?php }; ?>
                <?php }; ?>
            </select>
        </div>
        <p>Vous pouvez ici modifier la couleur du petit point.</p>
        <div>
            <input type="color" name="dimpulse_custom_qursor_options[color][]" value='<?php $options["color"][0] ?>' />
        </div>


        <h3>Curseur au hover</h3>
        <p>Sélectionnez ici les modèles et les classes CSS pour personnaliser le curseur au survol de vos éléments. La classe indiquée doit être copiée dans les pages Elementor sur les composants concernés. Si aucune classe n'est définie, le curseur ne sera pas appliqué. Vous pouvez configurer jusqu'à 3 curseurs différents.</p>

    <?php
    for ( $i = 0; $i < 3; $i++ ) : ?>
        <h4>Curseur  <?php echo $i + 1; ?></h4>
        <div>
            <input type="text" name="dimpulse_custom_qursor_options[class][]" value="<?php echo isset( $options['class'] ) ? $options['class'][ $i ] : ''; ?>" placeholder='Saisissez la classe'>
            <select name="dimpulse_custom_qursor_options[template][]">
                <option value="noneCursor">Aucun</option>
                <?php foreach ( $templates as $template ) { ?>
                    <option value="<?php echo $template->ID; ?>" <?php if ( isset( $options['template'] ) ) selected( $options['template'][ $i ], $template->ID ); ?>> <?php echo $template->post_title; ?> </option>
                <?php }; ?>
            </select>
        </div>
    <?php endfor;
}

add_action( 'admin_menu', function() {
 add_options_page( 'Curseur personnalisé', 'Curseur personnalisé', 'manage_options', 'dimpulse-custom-cursor', 'custom_qursor_admin_page' );
});

add_action( 'admin_init', function() {
 register_setting( 'dimpulse_custom_qursor', 'dimpulse_custom_qursor_options' );
 add_settings_section( 'dimpulse_custom_qursor_section', '', function(){}, 'dimpulse_custom_qursor' );
 add_settings_field( 'dimpulse_custom_qursor_field', '
 ', 'custom_qursor_fields', 'dimpulse_custom_qursor', 'dimpulse_custom_qursor_section' );
});

?>