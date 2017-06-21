<?php
/*
Plugin Name: Easy Textillate
Plugin URI: https://wordpress.org/plugins/easy-textillate/
Description: Very beautiful text animations (shortcodes in posts and widgets or PHP code in theme files).
Version: 1.03
Author: Flector
Author URI: https://profiles.wordpress.org/flector#content-plugins
Text Domain: easy-textillate
*/ 

function textillate_shortcode($atts, $content) {
	extract(shortcode_atts(array(
		'effect_in'      => 'fadeInLeftBig',
        'type_in'        => 'sequence',
		'effect_out'     => 'hinge',
		'type_out'       => 'shuffle',
        'loop'           => 'true',
        'mindisplaytime' => '2000',
        'initialdelay'   => '0',
        'delay'          => '50'
	), $atts));

    global $textillate_options;
    
    $textillate_options['randomid'] = easy_textillate_randomid(5);
    $textillate_options['effect_in'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$effect_in);
    $textillate_options['type_in'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$type_in);
    $textillate_options['effect_out'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$effect_out);
    $textillate_options['type_out'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$type_out);
    $textillate_options['loop'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$loop);
    $textillate_options['mindisplaytime'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$mindisplaytime);
    $textillate_options['initialdelay'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$initialdelay);
    $textillate_options['delay'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$delay);
    
    
	$output  = "\n<span class=\"textillate-" . $textillate_options['randomid'] . "\">\n";
	$output .= $content;
	$output .= "</span>\n";
    
    global $et_scripts;
    ob_start();
    easy_textillate_print_scripts();
    $et_scripts .= ob_get_contents();
    ob_end_clean();

	return $output;
}
add_shortcode('textillate', 'textillate_shortcode');
add_filter('widget_text', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');
add_filter('the_title', 'do_shortcode');

function easy_textillate_print_scripts() { 
global $textillate_options; ?>
<script type="text/javascript">
jQuery(document).ready(function(){
  jQuery('.textillate-<?php echo $textillate_options['randomid']; ?>').textillate({
  loop: <?php echo $textillate_options['loop']; ?>,
  minDisplayTime: <?php echo $textillate_options['mindisplaytime'];?>,
  initialDelay: <?php echo $textillate_options['initialdelay']; ?>,
  autoStart: true,
  in: {
    effect: '<?php echo $textillate_options['effect_in']; ?>',
    delayScale: 1.5,
    delay: <?php echo $textillate_options['delay']; ?>,
    sync: <?php if ($textillate_options['type_in']=='sync'){echo 'true';}else{echo 'false';}; ?>,
    sequence: <?php if ($textillate_options['type_in']=='sequence'){echo 'true';}else{echo 'false';}; ?>,
    shuffle: <?php if ($textillate_options['type_in']=='shuffle'){echo 'true';}else{echo 'false';}; ?>,
    reverse: <?php if ($textillate_options['type_in']=='reverse'){echo 'true';}else{echo 'false';}; ?>,
    callback: function () {}
  },
  out: {
    effect: '<?php echo $textillate_options['effect_out']; ?>',
    delayScale: 1.5,
    delay: <?php echo $textillate_options['delay']; ?>,
    sync: <?php if ($textillate_options['type_out']=='sync'){echo 'true';}else{echo 'false';}; ?>,
    sequence: <?php if ($textillate_options['type_out']=='sequence'){echo 'true';}else{echo 'false';}; ?>,
    shuffle: <?php if ($textillate_options['type_out']=='shuffle'){echo 'true';}else{echo 'false';}; ?>,
    reverse: <?php if ($textillate_options['type_out']=='reverse'){echo 'true';}else{echo 'false';}; ?>,
    callback: function () {}
  },
  callback: function () {}
});
});     
</script>
<?php } 

function et_scripts_footer() {
	global $et_scripts;
    echo $et_scripts;
}
add_action('wp_footer', 'et_scripts_footer');

function easy_textillate_files() {
	$purl = plugins_url();
	
    wp_register_script('easy-textillate-lettering', $purl . '/easy-textillate/inc/jquery.lettering.js');  
    wp_register_script('easy-textillate-textillate', $purl . '/easy-textillate/inc/jquery.textillate.js');  
    wp_register_script('easy-textillate-zclip', $purl . '/easy-textillate/inc/jquery.zclip.js');  
	wp_register_style('easy-textillate-animate', $purl . '/easy-textillate/inc/animate.min.css');
    wp_register_style('easy-textillate', $purl . '/easy-textillate/inc/easy-textillate.css');
	
	if(!wp_script_is('jquery')) {wp_enqueue_script('jquery');}
    wp_enqueue_script('easy-textillate-lettering');
    wp_enqueue_script('easy-textillate-textillate');
    wp_enqueue_style('easy-textillate-animate');
    if(is_admin()){wp_enqueue_style('easy-textillate');}
    if(is_admin()){wp_enqueue_script('easy-textillate-zclip');}
}
add_action('wp_enqueue_scripts', 'easy_textillate_files');
add_action('admin_enqueue_scripts', 'easy_textillate_files');

function easy_textillate_setup(){
    load_plugin_textdomain('easy-textillate');
}
add_action('init', 'easy_textillate_setup');

function easy_textillate_actions($links) {
	return array_merge(array('settings' => '<a href="options-general.php?page=easy-textillate.php">' . __('Settings', 'easy-textillate') . '</a>'), $links);
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'easy_textillate_actions');

function et_enable_shortcode($content) {return do_shortcode($content);}
add_filter('bbp_get_reply_content', 'et_enable_shortcode', 10,2);
add_filter('bbp_get_topic_content', 'et_enable_shortcode', 10,2);

function easy_textillate_options_page() {
?>
<div class="wrap">
<h2 class="tbon"><?php _e('Easy Textillate Settings', 'easy-textillate'); ?></h2>

<div class="metabox-holder" id="poststuff">
<div class="meta-box-sortables">

<div class="postbox">
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e("Preview", "easy-textillate"); ?></span></h3>
    <div class="inside" style="display: block;">
        
        <div class="grid grid-pad" style="margin-top:12px!important;">
        <section class="col-1-1">
            
            <div class="playground grid">
              <div class="col-1-1 viewport">
                  <div class="tlt">
                    <ul class="texts" style="display: none">
                      <span class="mytext"></span>
                    </ul>
                  </div>
              </div>
              <div class="col-1-1 controls" style="padding-right: 0">
                <form class="grid grid-pad">
                <label><?php _e('Your Text', 'easy-textillate'); ?></label>
                <textarea name="mytext" id="mytext" rows="3"><?php _e('The quick brown fox jumps over the lazy dog.', 'easy-textillate'); ?></textarea>

                  <div class="control col-1-2">
                    <label><?php _e('In Animation', 'easy-textillate'); ?></label>
                    <select name="in_effect" data-key="effect" data-type="in">
                    </select>
                    <select data-key="type" data-type="in">
                      <option value="">sequence</option>
                      <option value="reverse">reverse</option>
                      <option value="sync">sync</option>
                      <option value="shuffle">shuffle</option>
                    </select>
                  </div>
                  <div class="control col-1-2">
                    <label><?php _e('Out Animation', 'easy-textillate'); ?></label>
                    <select name="out_effect"data-key="effect" data-type="out"></select>
                    <select name="out_type" data-key="type" data-type="out">
                      <option value="">sequence</option>
                      <option value="reverse">reverse</option>
                      <option value="sync">sync</option>
                      <option selected="selected" value="shuffle">shuffle</option>
                    </select>
                  </div>
                </form>
              </div>
            </div>
            
        </section>
      </div>
        
      <div style="clear:both;"></div>
    </div>
</div>

<div class="postbox">
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e("Shortcode", "easy-textillate"); ?></span></h3>
    <div class="inside" style="padding-bottom:20px;display: block;">
    
    <table width="100%">
    <tr><td>
    
    <span style="color:#183691;" class="demo-container1">[textillate effect_in='<span style="color:green;" class="demo-box"></span>' type_in='<span style="color:green;" class="demo-box2"></span>' effect_out='<span style="color:green;" class="demo-box3"></span>' type_out='<span style="color:green;" class="demo-box4"></span>']<span style="color:#A71D5D;" class="demo-box5"></span>[/textillate]
	</span>
    </td>
    <td width="50px" style="align:right;">
    
     <span style="text-align:right;">
         <div style="position:relative"><button id="copy1" class="button button-secondary"><label><?php _e('Copy to ClipBoard', 'easy-textillate'); ?></label></button></div>
     </span>
     
     </td></tr>
     </table>

    </div>
</div>

<div class="postbox">
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e("PHP code", "easy-textillate"); ?></span></h3>
    <div class="inside" style="padding-bottom:20px;display: block;">
         
    <table width="100%">
    <tr><td>
         
    <span style="color:#183691;" class="demo-container2"><span style="color:#A71D5D;">&lt;?php</span> <span style="color:red;">echo do_shortcode("</span>[textillate effect_in='<span style="color:green;" class="demo-box"></span>' type_in='<span style="color:green;" class="demo-box2"></span>' effect_out='<span style="color:green;" class="demo-box3"></span>' type_out='<span style="color:green;" class="demo-box4"></span>']<span style="color:#A71D5D;" class="demo-box5"></span>[/textillate]<span style="color:red;">");</span> <span style="color:#A71D5D;">?&gt;</span>
	</span>   

     </td>
    <td width="50px" style="align:right;">
    
     <span style="text-align:right;">
         <div style="position:relative"><button id="copy2" class="button button-secondary"><?php _e('Copy to ClipBoard', 'easy-textillate'); ?></button></div>
     </span>
     
     </td></tr>
     </table>   

    </div>
</div>

<div class="postbox">
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e('Additional Options', 'easy-textillate'); ?></span></h3>
	  <div class="inside" style="padding-bottom:20px;display: block;">

	 <p><?php _e('You can use additional shortcode options:', 'easy-textillate'); ?></p>
     
     <table><tr><td width="170px;">
     <span style="color:#183691;">loop=</span><span style="color:green;">'true'</span></td><td> <span style="color:#bcbcbc;">// <?php _e('enable looping  (\'true\' or \'false\', \'true\' is default)', 'easy-textillate'); ?> </span></td></tr>
     <tr><td><span style="color:#183691;">minDisplayTime=</span><span style="color:green;">'2000'</span></td><td> <span style="color:#bcbcbc;">// <?php _e('sets the minimum display time for each text before it is replaced (\'2000\' is default)', 'easy-textillate'); ?></span></td></tr>
    <tr><td><span style="color:#183691;">initialDelay=</span><span style="color:green;">'0'</span></td><td>  <span style="color:#bcbcbc;">// <?php _e('sets the initial delay before starting the animation (\'0\' is default)', 'easy-textillate'); ?></span></td></tr>
    <tr><td><span style="color:#183691;">delay=</span><span style="color:green;">'50'</span></td><td>  <span style="color:#bcbcbc;">// <?php _e('set the delay between each character (\'50\' is default)', 'easy-textillate'); ?></span></td></tr>
	  </table>
    
    </div>
</div>

<div class="postbox">
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e('About', 'easy-textillate'); ?></span></h3>
	  <div class="inside" style="padding-bottom:15px;display: block;">
      
	  <p><?php _e('<strong>Easy Textillate</strong> uses the following libraries:', 'easy-textillate'); ?></p>
      <div class="about">
        <ul>
            <li><a target="_blank" href="https://jschr.github.io/textillate/">textillate.js</a>, <?php _e('by', 'easy-textillate'); ?> Jordan Schroter</li>
            <li><a target="_blank" href="http://daneden.github.io/animate.css/">animate.css</a>, <?php _e('by', 'easy-textillate'); ?> Daniel Eden</li>
            <li><a target="_blank" href="http://letteringjs.com/">lettering.js</a>, <?php _e('by', 'easy-textillate'); ?> Dave Rupert</li>
            </ul>
      </div>
   
    </div>
</div>

<div class="postbox">
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e("Do you like this plugin ?", "easy-textillate"); ?></span></h3>
    <div class="inside" style="display: block;">
        <img src="<?php echo WP_PLUGIN_URL. '/easy-textillate/img/icon_coffee.png'; ?>" title="<?php _e("buy me a coffee", "easy-textillate"); ?>" style=" margin: 5px; float:left;" />
		
        <p><?php _e("Hi! I'm <strong>Flector</strong>, developer of this plugin.", "easy-textillate"); ?></p>
        <p><?php _e("I've been spending many hours to develop this plugin.", "easy-textillate"); ?> <br />
		<?php _e("If you like and use this plugin, you can <strong>buy me a cup of coffee</strong>.", "easy-textillate"); ?></p>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
            <input type="image" src="<?php echo WP_PLUGIN_URL. '/easy-textillate/img/donate.gif'; ?>" border="0" name="submit" title="<?php _e("Donate with PayPal", "easy-textillate"); ?>">
        </form>
        <div style="clear:both;"></div>
    </div>
</div>

</div>
</div>
<?php 
}

function easy_textillate_admin_print_scripts() {
?>
<script type="text/javascript">

  jQuery(document).ready(function($) {
    var log = function (msg) {
      return function () {
        if (console) console.log(msg);
         var $test = $('textarea#mytext').val();
         $('span.mytext').text($test);
         $('span.demo-box5').text($test);
      }
    }
    $('code').each(function () {
      var $this = $(this);
      $this.text($this.html());

    })
    
    var animateClasses = 'bounce flash pulse rubberBand shake swing tada wobble jello bounceIn bounceInDown bounceInLeft bounceInRight bounceInUp bounceOut bounceOutDown bounceOutLeft bounceOutRight bounceOutUp fadeIn fadeInDown fadeInDownBig fadeInLeft fadeInLeftBig fadeInRight fadeInRightBig fadeInUp fadeInUpBig fadeOut fadeOutDown fadeOutDownBig fadeOutLeft fadeOutLeftBig fadeOutRight fadeOutRightBig fadeOutUp fadeOutUpBig flipInX flipInY flipOutX flipOutY lightSpeedIn lightSpeedOut rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight hinge rollIn rollOut zoomIn zoomInDown zoomInLeft zoomInRight zoomInUp zoomOut zoomOutDown zoomOutLeft zoomOutRight zoomOutUp slideInDown slideInLeft slideInRight slideInUp slideOutDown slideOutLeft slideOutRight slideOutUp';

    var $form = $('.playground form')
      , $viewport = $('.playground .viewport');

    var getFormData = function () {
        
      var data = { 
        loop: true, 
        in: { callback: log('in callback called.') }, 
        out: { callback: log('out callback called.') }
      };
      
      $form.find('[data-key="effect"]').each(function () {
        var $this = $(this)
          , key = $this.data('key')
          , type = $this.data('type');
          if ($this.data('key')=='effect' & $this.data('type')=='in'){
            $('span.demo-box').text($this.val());}
          if ($this.data('key')=='effect' & $this.data('type')=='out'){
            $('span.demo-box3').text($this.val());}
          
          data[type][key] = $this.val();
      });

      $form.find('[data-key="type"]').each(function () {
          
        var $this = $(this)
          , key = $this.data('key')
          , type = $this.data('type')
          , val = $this.val();

          if ($this.data('key')=='type' & $this.data('type')=='in'){
            $('span.demo-box2').text($this.val());
            if ($this.val()=='') {$('span.demo-box2').text('sequence');}
            }
          if ($this.data('key')=='type' & $this.data('type')=='out'){
            $('span.demo-box4').text($this.val());
            if ($this.val()=='') {$('span.demo-box4').text('sequence');}
            }
          data[type].shuffle = (val === 'shuffle');
          data[type].reverse = (val === 'reverse');
          data[type].sync = (val === 'sync');
      });

      return data;
    };

    $.each(animateClasses.split(' '), function (i, value) {
      var type = '[data-type]'
        , option = '<option value="' + value + '">' + value + '</option>';
        
      if (/Out/.test(value) || value === 'hinge') {
        type = '[data-type="out"]';
      } else if (/In/.test(value)) {
        type = '[data-type="in"]';
      } 

      if (type) {
        $form.find('[data-key="effect"]' + type).append(option);        
      }
    });

    $form.find('[data-key="effect"][data-type="in"]').val('fadeInLeftBig');
    $form.find('[data-key="effect"][data-type="out"]').val('hinge');

    setTimeout(function () {
        $('.fade').addClass('in');
    }, 250);

    setTimeout(function () {
      $('h1.glow').removeClass('in');
    }, 2000);

    var $tlt = $viewport.find('.tlt')
      .on('start.tlt', log('start.tlt triggered.'))
      .on('inAnimationBegin.tlt', log('inAnimationBegin.tlt triggered.'))
      .on('inAnimationEnd.tlt', log('inAnimationEnd.tlt triggered.'))
      .on('outAnimationBegin.tlt', log('outAnimationBegin.tlt triggered.'))
      .on('outAnimationEnd.tlt', log('outAnimationEnd.tlt triggered.'))
      .on('end.tlt', log('end.tlt'));
    
    $form.on('change', function () {
      var obj = getFormData();
      $tlt.textillate(obj);
    }).trigger('change');

  });
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
$('.tbon').textillate({
  loop: false,
  minDisplayTime: 2000,
  initialDelay: 200,
  autoStart: true,
  inEffects: [],
  outEffects: [ 'hinge' ],
  in: {
    effect: 'bounceInDown',
    delayScale: 1.5,
    delay: 50,
    sync: false,
    shuffle: false,
    reverse: true,
    callback: function () {}
  },
  callback: function () {}
});})
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
$('.tcode').textillate({
  loop: true,
  minDisplayTime: 5000,
  initialDelay: 800,
  autoStart: true,
  inEffects: [],
  outEffects: [],
  in: {
    effect: 'rollIn',
    delayScale: 1.5,
    delay: 50,
    sync: false,
    shuffle: true,
    reverse: false,
    callback: function () {}
  },
   out: {
    effect: 'fadeOut',
    delayScale: 1.5,
    delay: 50,
    sync: false,
    shuffle: true,
    reverse: false,
    callback: function () {}
  },
  callback: function () {}
});})
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {

    $("#copy1").zclip({
            path:'<?php echo plugins_url() . '/easy-textillate/inc' ?>/zclip.swf',
            copy: function() {var $test = $('textarea#mytext').val();
                $('span.mytext').text($test);
                $('span.demo-box5').text($test);
                return $('.demo-container1').text();
            },
            beforeCopy: function() {},
            afterCopy: function() {
                alert('<?php echo __('The code is in your clipboard now:', 'easy-textillate'); ?> \n\n' + $('.demo-container1').text());
            }
    });
    
    $("#copy2").zclip({
            path:'<?php echo plugins_url() . '/easy-textillate/inc' ?>/zclip.swf',
            copy: function() {var $test = $('textarea#mytext').val();
                $('span.mytext').text($test);
                $('span.demo-box5').text($test);
                return $('.demo-container2').text();
            },
            beforeCopy: function() {},
            afterCopy: function() {
                alert('<?php echo __('The code is in your clipboard now:', 'easy-textillate'); ?> \n\n' + $('.demo-container2').text());
            }
    });

});
</script>
<?php }    
add_action('admin_head', 'easy_textillate_admin_print_scripts');

function easy_textillate_menu() {
	add_options_page('Easy Textillate', 'Easy Textillate', 'manage_options', 'easy-textillate.php', 'easy_textillate_options_page');
}
add_action('admin_menu', 'easy_textillate_menu');

function easy_textillate_randomid($length = 4){
  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
  $numChars = strlen($chars);
  $string = '';
  for ($i = 0; $i < $length; $i++) {
    $string .= substr($chars, rand(1, $numChars) - 1, 1);
  }
  return $string;
}

?>