<?php
/**
 * Functions to provide support for the One Click Demo Import plugin (wordpress.org/plugins/one-click-demo-import)
 *
 * @package Talon
 */

/*Import content data*/

/*Import content data*/
if ( ! function_exists( 'courtyard_import_files' ) ) :
function courtyard_import_files() {
    return array(
        array(
            'import_file_name'             => 'Courtyard Demo',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-content/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-content/demo-widgets.wie',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-content/demo-customizer.dat',
            'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'courtyard' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'courtyard_import_files' );
endif;

/**
 * Define actions that happen after import
 */

if ( ! function_exists( 'courtyard_set_after_import_mods' ) ) :
function courtyard_set_after_import_mods( $selected_import ) {
 
    if ( 'Courtyard Demo' === $selected_import['import_file_name'] ) {
        
        //Assign the menu
        $primary_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
        set_theme_mod( 'nav_menu_locations' , array( 
                'primary' => $primary_menu->term_id, 
            )
        );

        //Asign the static front page and the blog page
        $front_page = get_page_by_title( 'Home' );
        $blog_page  = get_page_by_title( 'Blog' );
 
        //Set Front page
        if ( isset( $front_page->ID ) ) {
            update_option( 'page_on_front', $front_page->ID );
            update_option( 'show_on_front', 'page' );
            //Assign the Front Page template
            update_post_meta( $front_page -> ID, '_wp_page_template', 'page-templates/template-front-page.php' );
        }

        //Set Blog page
        if ( isset( $blog_page->ID ) ) {
            update_option( 'page_for_posts', $blog_page -> ID );
        }
    }     
}
add_action( 'pt-ocdi/after_import', 'courtyard_set_after_import_mods' );
endif;
