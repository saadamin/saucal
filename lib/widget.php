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


function saucal_employee_register_widget()
{
    register_widget('saucal_employee_widget');
}
add_action('widgets_init', 'saucal_employee_register_widget');
class saucal_employee_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            // widget ID
            'saucal_employee_widget',
            // widget name
            __('Saucal Show employees', ' saucal_employee_widget_domain'),
            // widget description
            array('description' => __('Saucal Employee list', 'saucal_employee_widget_domain'),)
        );
    }
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];
        //if title is present
        if (!empty($title))
            echo $args['before_title'] . $title .  $args['after_title'];
        $frn = '';
        //API call START
        $url = 'http://dummy.restapiexample.com/api/v1/employees';
        $remote = wp_remote_get(
            $url,
            array(
                'body' => array(
                    'subject'   => $subject,
                    'body'     => $body,
                )
            )
        );
        if (!is_wp_error($remote) && isset($remote['response']['code']) && $remote['response']['code'] == 200 && !empty($remote['body'])) {
            $remote = json_decode($remote['body']);
        }
        foreach ($remote->data as $row => $col) {

            //API call END
            //If api call does not work. Sometime it limits request. uncomment if API requests do not work.
            //JSON file upload START
            // $string = file_get_contents(SAUCAL_PLUGIN_URL . "assets/data.json");
            // $r = json_decode($string, true);
            // foreach ($r as $row => $col) {
            //JSON file upload END

            if (intval($col->employee_salary) < intval(get_user_meta(get_current_user_id(), 'HighestSalaryRange', true))) {
                $frn .= '<p class="wid_div"><span class="wid_val">Employee Name : ' . $col->employee_name . ' </span><span class="wid_val">Employee Age : ' . $col->employee_age . ' </span><span class="wid_val">Employee Salary : ' . $col->employee_salary . ' </span></p>';
            }
        }
        echo $frn;
        echo $args['after_widget'];
    }
    public function form($instance)
    {
        if (isset($instance['title']))
            $title = $instance['title'];
        else
            $title = __('Default Title', 'saucal_employee_widget_domain');
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
<?php
    }
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}
