<?php
// Creating the widget 
function saucal_widgets_init()
{

    register_sidebar(array(
        'name' => __('Saucal', 'sidebar-1'),
        'id' => 'sidebar-1',
        'description' => __('The main sidebar appears on the right on each page except the front page template', 'saucal'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'saucal_widgets_init');
