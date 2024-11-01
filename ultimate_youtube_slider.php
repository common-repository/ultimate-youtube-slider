<?php
/*
Plugin Name: Ultimate Youtube Slider
Plugin URI: http://ultimatesocialwidgets.com/wpdemo/
Description: Ultimate Youtube Slider - An awesome youtube hosted video slider.
Author: Ultimate Social Widgets
Version: 1.0
Author URI: http://ultimatesocialwidgets.com/wpdemo/
*/
class RealYoutubeSlider{

    public $options;

    public function __construct() {
        //you can run delete_option method to reset all data
        //delete_option('real_youtube_plugin_options');
        $this->options = get_option('real_youtube_plugin_options');
        $this->real_utube_register_settings_and_fields();
    }

    public static function add_youtube_tools_options_page(){
        add_options_page('Ultimate Youtube Slider', 'Ultimate Youtube Slider ', 'administrator', __FILE__, array('RealYoutubeSlider','real_youtube_tools_options'));
    }

    public static function real_youtube_tools_options(){
?>
<div class="wrap">
    <?php screen_icon(); ?>
    <h2>Ultimate Youtube Slider Configuration</h2>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('real_youtube_plugin_options'); ?>
        <?php do_settings_sections(__FILE__); ?>
        <p class="submit">
            <input name="submit" type="submit" class="button-primary" value="Save Changes"/>
        </p>
    </form>
</div>
<?php
    }
    public function real_utube_register_settings_and_fields(){
        register_setting('real_youtube_plugin_options', 'real_youtube_plugin_options',array($this,'real_youtube_validate_settings'));
        add_settings_section('real_youtube_main_section', 'Settings', array($this,'real_youtube_main_section_cb'), __FILE__);
        //Start Creating Fields and Options
        //sidebar image
        //add_settings_field('sidebarImage', 'Sidebar Image', array($this,'sidebarImage_settings'),__FILE__,'real_youtube_main_section');
        //pageURL
        add_settings_field('youtube_user', 'Youtube Video Username', array($this,'pageUsername_settings'), __FILE__,'real_youtube_main_section');
        //pageURL
        add_settings_field('youtube_url', 'Youtube Video Code', array($this,'pageURL_settings'), __FILE__,'real_youtube_main_section');
        //marginTop
        add_settings_field('marginTop', 'Margin Top', array($this,'marginTop_settings'), __FILE__,'real_youtube_main_section');
        //alignment option
         add_settings_field('alignment', 'Alignment Position', array($this,'position_settings'),__FILE__,'real_youtube_main_section');
        //width
        add_settings_field('width', 'Width', array($this,'width_settings'), __FILE__,'real_youtube_main_section');
        //height
        add_settings_field('height', 'Height', array($this,'height_settings'), __FILE__,'real_youtube_main_section');

    }
    public function real_youtube_validate_settings($plugin_options){
        return($plugin_options);
    }
    public function real_youtube_main_section_cb(){
        //optional
    }


    //pageURL_settings
    public function pageUsername_settings() {
        if(empty($this->options['youtube_user'])) $this->options['youtube_user'] = "disney";
        echo "<input name='real_youtube_plugin_options[youtube_user]' type='text' value='{$this->options['youtube_user']}' />";
    }

    //pageURL_settings
    public function pageURL_settings() {
        if(empty($this->options['youtube_url'])) $this->options['youtube_url'] = "cEjqEEYOZUk";
        echo "<input name='real_youtube_plugin_options[youtube_url]' type='text' value='{$this->options['youtube_url']}' />";
    }
    //marginTop_settings
    public function marginTop_settings() {
        if(empty($this->options['marginTop'])) $this->options['marginTop'] = "250";
        echo "<input name='real_youtube_plugin_options[marginTop]' type='text' value='{$this->options['marginTop']}' />";
    }
    //alignment_settings
    public function position_settings(){
        if(empty($this->options['alignment'])) $this->options['alignment'] = "left";
        $items = array('left','right');
        echo "<select name='real_youtube_plugin_options[alignment]'>";
        foreach($items as $item){
            $selected = ($this->options['alignment'] === $item) ? 'selected = "selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }
    //width_settings
    public function width_settings() {
        if(empty($this->options['width'])) $this->options['width'] = "350";
        echo "<input name='real_youtube_plugin_options[width]' type='text' value='{$this->options['width']}' />";
    }
    //height_settings
    public function height_settings() {
        if(empty($this->options['height'])) $this->options['height'] = "400";
        echo "<input name='real_youtube_plugin_options[height]' type='text' value='{$this->options['height']}' />";
    }

}
add_action('admin_menu', 'real_youtube_trigger_options_function');

function real_youtube_trigger_options_function(){
    RealYoutubeSlider::add_youtube_tools_options_page();
}

add_action('admin_init','real_youtube_trigger_create_object');
function real_youtube_trigger_create_object(){
    new RealYoutubeSlider();
}
add_action('wp_footer','real_youtube_add_content_in_footer');
function real_youtube_add_content_in_footer(){

    $o = get_option('real_youtube_plugin_options');
    extract($o);
    $width=$width;
    $height=$height;
    $total_height=$height-30;
	//$mheight = $height-85;
    //$max_height=$total_height+10;
$print_youtube = '';
$print_youtube .= ' <iframe
                src="https://www.youtube.com/subscribe_widget?p='.$youtube_user.'"
                class="youtube-subscribe" scrolling="no" frameborder="0">
           </iframe><br/>
            <iframe width="'.$width.'"
                height="'.$total_height.'"
                src="http://www.youtube.com/embed/'.$youtube_url.'"
                frameborder="0" allowfullscreen="yes" style="padding-top: 50px;">
            </iframe>';

$imgURL = plugins_url('assets/youtube-icon.png', __FILE__);
//$imgURL = plugins_url('ultimate-youtube-slider/assets/youtube-icon.png');

?>

<style>
  div#ybox1 {
  height: <?php echo $max_height;?>px !important;
</style>
<?php if($alignment=='left'){?>
<div id="real_youtube_display">
    <div id="ybox1" style="left: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+10);?>px;">
        <div id="ybox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">
            <a class="open" id="ylink" href="#"></a><img style="top: 0px;right:-50px;" src="<?php echo $imgURL;?>" alt="">
            <?php echo $print_youtube; ?>
        </div>

    </div>
</div>

<script type="text/javascript">
(function(d){
  var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
  p.type = 'text/javascript';
  p.async = true;
  p.src = '//assets.pinterest.com/js/pinit.js';
  f.parentNode.insertBefore(p, f);
}(document));
</script>
<script type="text/javascript">
jQuery.noConflict();
jQuery(function (){
jQuery(document).ready(function()
{
jQuery.noConflict();
jQuery(function (){
jQuery("#ybox1").hover(function(){
jQuery('#ybox1').css('z-index',101009);
jQuery(this).stop(true,false).animate({left:  0}, 500); },
function(){
    jQuery('#ybox1').css('z-index',10000);
    jQuery("#ybox1").stop(true,false).animate({left: -<?php echo trim($width+10); ?>}, 500); });
});}); });
jQuery.noConflict();
</script>
<?php } else { ?>
<div id="real_youtube_display">
    <div id="ybox1" style="right: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+10);?>px;">
        <div id="ybox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">
            <a class="open" id="ylink" href="#"></a><img style="top: 0px;left:-50px;" src="<?php echo $imgURL;?>" alt="">
            <?php echo $print_youtube; ?>
        </div>

    </div>
</div>

<script type="text/javascript">
jQuery.noConflict();
jQuery(function (){
jQuery(document).ready(function()
{
jQuery.noConflict();
jQuery(function (){
jQuery("#ybox1").hover(function(){
jQuery('#ybox1').css('z-index',101009);
jQuery(this).stop(true,false).animate({right:  0}, 500); },
function(){
    jQuery('#ybox1').css('z-index',10000);
    jQuery("#ybox1").stop(true,false).animate({right: -<?php echo trim($width+10); ?>}, 500); });
});}); });
jQuery.noConflict();
</script>
<?php } ?>
<?php
}
add_action( 'wp_enqueue_scripts', 'register_real_youtube_slider_styles' );
 function register_real_youtube_slider_styles() {
    wp_register_style( 'register_real_youtube_slider_styles', plugins_url( 'assets/style.css' , __FILE__ ) );
    wp_enqueue_style( 'register_real_youtube_slider_styles' );
        wp_enqueue_script('jquery');
 }
 $real_youtube_default_values = array(
     'marginTop' => 250,
     'youtube_url' => '',
     'youtube_user' => '',
     'width' => '350',
     'height' => '430',
     'alignment' => 'left'

 );
 add_option('real_youtube_plugin_options', $real_youtube_default_values);
