<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if(!class_exists('mrMetaBox')) {
    require('vendor/mr-meta-box/mr-meta-box.php');
}

class SnPopup {
    protected $path;
    protected $url;
    protected $metabox;
    protected $defaults_metabox;
    protected  $supported_post_types;

    const prefix = 'sn_popup_';

    function __construct(){
        $this->url = plugins_url( '', __FILE__ );
        $this->path = plugin_dir_path( __FILE__ );

        $this->supported_post_types = array('post','page');

        add_action('wp_enqueue_scripts',array($this,'load_assets'));
        add_action('init',array($this,'create_post_type'));
        add_action('init',array($this,'init_metaboxes'));
        add_action('wp',array($this,'set_cookie'));
        add_action('save_post',array($this,'save'));

        add_action('wp_footer',array($this,'render_popup_html'));

        load_plugin_textdomain('sn_popup', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }

    function load_assets(){
        wp_enqueue_script('jquery');
        wp_enqueue_script('featherlight', $this->url . '/vendor/featherlight-1.3.4/release/featherlight.min.js',array('jquery'));
        wp_enqueue_script('sn-popup', $this->url .'/js/sn-popup.js',array('featherlight'));

        wp_enqueue_style('sn-featherlight',$this->url .'/vendor/featherlight-1.3.4/release/featherlight.min.css');
        wp_enqueue_style('sn-popup',$this->url .'/css/sn-popup.css');
    }

    function create_post_type(){
        register_post_type( 'sn_popup',
            array(
                'labels' => array(
                    'name' => __( 'SN Popup','sn_popup'),
                    'singular_name' => __( 'SN Popup', 'sn_popup' )
                ),
                'public' => false,
                'has_archive' => false,
                'publicaly_queryable' => false,
                'query_var' => false,
                'show_ui' => true,
                'supports' => array(
                    'title',
                    'custom-fields',
                    'editor'
                )

            )
        );
    }

    function init_metaboxes(){
        $this->metabox = new mrMetaBox(array(
            'id' => 'sn_posts_metabox', //string Meta box ID - required
            'title' => __('SN Popup','sn_popup'), //string Title of the meta box
            'prefix' => self::prefix, //string Prefix of the field ids
            'postType' => $this->supported_post_types, //array Array of post types you want to add meta box to
            'context' => 'side', //string The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side')
            'priority' => 'high', // string The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
            'usage' => 'plugin', //string 'theme', 'plugin' or 'http://example.com/path/to/mr-meta-box/folder'
            'showInColumns' => false //boolean Whether to show the mr meta box fields in 3 columns - comes handy where there is many fields in one mr meta box
        ));

        $this->defaults_metabox = new mrMetaBox(array(
            'id' => 'sn_metabox', //string Meta box ID - required
            'title' => __('SN Popup','sn_popup'), //string Title of the meta box
            'prefix' => self::prefix, //string Prefix of the field ids
            'postType' => array('sn_popup'), //array Array of post types you want to add meta box to
            'context' => 'side', //string The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side')
            'priority' => 'high', // string The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
            'usage' => 'plugin', //string 'theme', 'plugin' or 'http://example.com/path/to/mr-meta-box/folder'
            'showInColumns' => false //boolean Whether to show the mr meta box fields in 3 columns - comes handy where there is many fields in one mr meta box
        ));

        $this->add_fields($this->metabox,array(
            array(
                'id' => 'popup_select',
                'type' => 'Select',
                'label' => __('Popup','sn_popup'),
                'default' => __('Pick a popup','sn_popup'),
                'options' => $this->get_popups_title_and_id()
            ),
            array(
                'id' => 'show_once',
                'type' => 'Checkbox',
                'label' => __('Show once','sn_popup'),
                'default' => true
            ),
            array(
                'id' => 'cookie_expire_time',
                'type' => 'Text',
                'default' => 7,
                'label' => __('Days until popup is shown again','sn_popup')
            ),
            array(
                'id' => 'delay',
                'type' => 'Text',
                'default' => 0,
                'label' => __('Open delay in milliseconds','sn_popup')
            ),
            array(
                'id' => 'openSpeed',
                'type' => 'Text',
                'default' => 250,
                'label' => __('Open Animation Speed','sn_popup')
            ),
            array(
                'id' => 'closeSpeed',
                'type' => 'Text',
                'default' => 250,
                'label' => __('Close Animation Speed','sn_popup')
            ),
            array(
                'id' => 'show_popup',
                'type' => 'Checkbox',
                'label' => __('Show Popup','sn_popup'),
                'default' => false
            )
        ));
        $this->add_fields($this->defaults_metabox,array(
            array(
                'id' => 'is_global',
                'type' => 'Checkbox',
                'label' => __('Show on every page (unless overriden by page itself)','sn_popup'),
                'default' => false
            ),
            array(
                'id' => 'infoLabel',
                'type'=> 'Label',
                'text' => __('Options if used globally:','sn_popup')
            ),
            array(
                'id' => 'show_once',
                'type' => 'Checkbox',
                'label' => __('Show once','sn_popup'),
                'default' => true
            ),
            array(
                'id' => 'cookie_expire_time',
                'type' => 'Text',
                'default' => 7,
                'label' => __('Days until popup is shown again','sn_popup')
            ),
            array(
                'id' => 'delay',
                'type' => 'Text',
                'default' => 0,
                'label' => __('Open delay in milliseconds','sn_popup')
            ),
            array(
                'id' => 'openSpeed',
                'type' => 'Text',
                'default' => 250,
                'label' => __('Open Animation Speed','sn_popup')
            ),
            array(
                'id' => 'closeSpeed',
                'type' => 'Text',
                'default' => 250,
                'label' => __('Close Animation Speed','sn_popup')
            )
        ));
    }

    function add_fields($metabox,$fields = array()){
        foreach($fields as $field){
            $metabox->addField($field);
        }
    }

    function save($id){
        global $post_type;
        $post_type_object = get_post_type_object($post_type);

        if($post_type != 'sn_popup') return $id;
        if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (!isset($_POST['post_ID']) || $id != $_POST['post_ID']) || (!wp_verify_nonce($_POST['mr_meta_box_nonce'], $post_type)) || (!current_user_can($post_type_object->cap->edit_post, $id))) {
            return $id;
        }
        $current = get_option(self::prefix .'global');
        if(isset($_POST[self::prefix.'is_global'])){
            if(isset($current)){
                update_post_meta($current,self::prefix.'is_global','');
            }
            update_option(self::prefix .'global',$id);
        } else {
            $was_global = get_post_meta($id,self::prefix.'is_global',true);
            if($was_global == '1'){
                update_option(self::prefix.'global',false);
            }
        }

    }

    function get_all_popups(){
        return get_posts(array(
            'posts_per_page' => -1,
            'post_type' => 'sn_popup'
        ));
    }

    function get_popups_title_and_id(){
        $popups = $this->get_all_popups();
        $arr = array();

        foreach($popups as $popup){
            $arr[$popup->ID] = $popup->post_title;
        }
        return $arr;
    }

    function get_popup_content($id){
        $popup = get_post($id);

        return apply_filters('the_content',$popup->post_content);
    }

    function render_popup_html(){
        $post_id = get_queried_object_id();

        $show = get_post_meta($post_id,self::prefix.'show_popup',true);
        $delay = 0;
        $openSpeed = 0;
        $closeSpeed = 0;

        $popup_id = get_post_meta($post_id,self::prefix.'popup_select',true);

        if($show == 1 && !empty($popup_id)){
            $show_once = get_post_meta($post_id,self::prefix.'show_once',true);
            if($show_once == 1){
                if(isset($_COOKIE['sn-popup'])) return;
            }

            $delay = get_post_meta($post_id,self::prefix.'delay',true);
            $openSpeed = get_post_meta($post_id,self::prefix.'openSpeed',true);
            $closeSpeed = get_post_meta($post_id,self::prefix.'closeSpeed',true);
        } else {
            $popup_id = get_option(self::prefix.'global');
            if(!isset($popup_id) || empty($popup_id)) return;

            $show_once = get_post_meta($popup_id,self::prefix.'show_once',true);
            if($show_once == 1){
                if(isset($_COOKIE['sn-popup-global'])) return;
            }
            $delay = get_post_meta($popup_id,self::prefix.'delay',true);
            $openSpeed = get_post_meta($popup_id,self::prefix.'openSpeed',true);
            $closeSpeed = get_post_meta($popup_id,self::prefix.'closeSpeed',true);
        }

        $content = $this->get_popup_content($popup_id);

        $html = '<div id="sn-popup-'.$popup_id.'" class="sn-popup" data-delay="'.$delay.'" data-openspeed="'.$openSpeed.'" data-closespeed="'.$closeSpeed.'">';
        $html .= $content;
        $html .= '</div>';

        echo $html;
    }

    function set_cookie(){
        if(!isset($_COOKIE['sn-popup'])){
            $id = get_queried_object_id();
            $expire = get_post_meta($id,self::prefix.'cookie_expire_time',true);
            $show = get_post_meta($id,self::prefix.'show_popup',true);

            if(empty($expire))
                $expire = 7;
            else
                $expire = (int)$expire;

            if($show == 1)
            setcookie('sn-popup',0,time() + ( $expire * 86400 ));
        }
        if(!isset($_COOKIE['sn-popup-global'])){
            $globalPopup = get_option(self::prefix.'global');
            if(isset($globalPopup)){
                $expire = get_post_meta($globalPopup,self::prefix.'cookie_expire_time',true);
                if(empty($expire))
                    $expire = 7;
                else
                    $expire = (int)$expire;
                setcookie('sn-popup-global',0,time() + ( $expire * 86400 ), '/');
            }
        }
    }
}