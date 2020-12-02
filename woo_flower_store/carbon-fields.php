<?php 
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
    
    Container::make( 'theme_options', __( 'Partners Options', 'crb' ) )    
    ->add_fields( array(
            Field::make( 'complex', 'partners_crb', 'Partners' )
                ->set_layout( 'tabbed-horizontal' )
                ->add_fields( 'partner_info',array(
                    Field::make( 'text', 'name', 'Name' ),
                    Field::make( 'text', 'surname', 'Surname' ),
                    Field::make( 'text', 'social', 'Social' ),
                ) ),
    ) );
    
    Container::make('theme_options', __('Widget photo'))
    ->add_fields( array(
        Field::make( 'image', 'image_about_widget_crb', 'Photo' )
            ->set_value_type( 'url' )
    ) );
     
    Container::make('theme_options', __('Title decorators'))
    ->add_fields( array(
        
            Field::make( 'image', 'image_zero', 'Variant_1' )
                ->set_value_type( 'url' ),
            
            Field::make( 'image', 'image_first', 'Variant_2' )
                ->set_value_type( 'url' ),
        
            Field::make( 'image', 'image_second', 'Variant_3' )
                ->set_value_type( 'url' ),
        
            Field::make( 'image', 'image_third', 'Variant_4' )
                ->set_value_type( 'url' ),
        
            Field::make( 'image', 'image_fourth', 'Variant_5' )
                ->set_value_type( 'url' ),
        
            Field::make( 'image', 'image_fives', 'Variant_6' )
                ->set_value_type( 'url' ),
        
            Field::make( 'image', 'image_six', 'Variant_7' )
                ->set_value_type( 'url' )
        ) );


}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( ABSPATH . '/vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}

