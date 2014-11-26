<?php
/*
Plugin Name: Crikeyes
Plugin URI: http://www.crikeyes.com/
Description: Crikeyes provides worlds best support chat application to provide real time support for your customers. This helps the website owners to build a strong customer support team equipped with the support chat widget to communicate with your customers.
Version: 1.0.0
Author: Softnotions Technologies Pvt Ltd
Author URI: http://www.softnotions.com
License: GPL
*/


/** Load widget on footer */
add_action('wp_footer', 'crikey_chatwidget'); 

/** Function to load widget */
function crikey_chatwidget(){  

    global $wpdb;
    //Get table name with prefix
    $table_name = $wpdb->prefix . 'crikey_chat';
    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE chatwidget_id = '1'");

	$script = $result[0]->script;
    $header_color = $result[0]->header_color;
    $header_text_color = $result[0]->header_font_color;
    $body_color = $result[0]->body_color;
    $widget_option = $result[0]->widget_options;
    $layout = $result[0]->location_layout;

    if(($layout==1) || ($layout==2)){
        $header_id = 'Crikeyes_leftsideheader';
    } else {
        $header_id = 'Crikeyes_ChatBoxHead';
    }

    if($layout==1) {
        $loc_layout = '<div id="Crikeyes_ChatBox" class="Crikeyes_leftside" style="height: 310px; display: block;">
    <div id="Crikeyes_chatleftobject">
    </div>
    <div id="Crikeyes_leftsideheader" onclick="javascript:MinimizeChatBoxLeft()"  >
        <div id="Crikeyes_ChatBoxHead">
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBoxLeft()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/down_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
    </div>
</div>';
    } elseif($layout==2) {
        $loc_layout = '<div id="Crikeyes_ChatBox" class="Crikeyes_rightside" style="height: 310px; display: block;right:-302px;">
    
    <div id="Crikeyes_leftsideheader" onclick="javascript:MinimizeChatBoxRight()" >
        <div id="Crikeyes_ChatBoxHead">
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBoxRight()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/down_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
    </div>
    <div id="Crikeyes_chatleftobject">
    </div>
</div>';
    } elseif($layout==3) {
        $loc_layout = '<div id="Crikeyes_ChatBox" class="Crikeyes_bottomleftchat" style="height: 38px; display: block;">
   
     
        <div id="Crikeyes_ChatBoxHead"  onclick="javascript:MinimizeChatBoxLeftBottom()" >
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBoxLeftBottom()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/up_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
     
     <div id="Crikeyes_chatleftobject">
    </div>
</div>';
    } elseif($layout==4) {
        $loc_layout = '<div id="Crikeyes_ChatBox" style="height: 38px; display: block;">
  
    
        <div id="Crikeyes_ChatBoxHead" onclick="javascript:MinimizeChatBox()" >
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBox()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/up_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
     
      <div id="Crikeyes_chatleftobject">
    </div>
</div>';
    }

    //Replace script variables with selected values
    $script = strtr($script, array('$header_color' => $header_color, '$body_color' => $body_color, '$widget_option' => $widget_option, '$header_text_color' => $header_text_color, '$layout' => $loc_layout, '$header_id' => $header_id));
	
	echo $script;  


}


/** Creating tables and inserting default values */

global $jal_db_version;
$jal_db_version = '1.0.0';

/** Function to create tables on install */
function jal_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'crikey_chat';
	
	/*
	 * We'll set the default character set and collation for this table.
	 * If we don't do this, some characters could end up being converted 
	 * to just ?'s when saved in our table.
	 */
	$charset_collate = '';

	if ( ! empty( $wpdb->charset ) ) {
	  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
	}

	if ( ! empty( $wpdb->collate ) ) {
	  $charset_collate .= " COLLATE {$wpdb->collate}";
	}

    $wpdb->query("DROP TABLE IF EXISTS $table_name");
	$sql .= "CREATE TABLE $table_name (
		chatwidget_id mediumint(9) NOT NULL AUTO_INCREMENT,
		version varchar(255) NOT NULL DEFAULT '',
	  	script text NOT NULL,
	  	header_color varchar(100) NOT NULL DEFAULT '',
	  	header_font_color varchar(100) NOT NULL DEFAULT '',
	  	body_color varchar(100) NOT NULL DEFAULT '',
	  	location_layout varchar(100) NOT NULL DEFAULT '',
	  	widget_options varchar(100) NOT NULL DEFAULT '',
	  	created_time datetime DEFAULT NULL,
	  	update_time datetime DEFAULT NULL,
		PRIMARY KEY (chatwidget_id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}

/** Function to insert data on install */
function jal_install_data() {
	global $wpdb;
	
	$created_time = date("Y-m-d H:i:s");
	$script = '<script type="text/javascript">
                    var Host;
                    Host = \'\';
                    var getLocation = function (href) {
                        var l = document.createElement("a");
                        l.href = href;
                        return l;
                    };
                    jQuery(document).ready(function () {
                        var l = getLocation(document.URL);
                        Host = l.hostname;

				        var Url = "http://crikeyes.com/support/SupportChat.aspx?Host=" + Host + "&Field=$widget_option|&BodyColor=$body_color";
				        jQuery(\'#Crikeyes_chatleftobject\').append("<object type=\'text/html\' data=\'" + Url + "\' id=\'Crikeyes_Chat\'></object>");
                        jQuery(\'#$header_id\').css(\'background\', \'$header_color\');
				        jQuery(\'#Crikeyes_Head\').css(\'color\', \'$header_text_color \');

				    });
				</script>
				$layout';
	
	$table_name = $wpdb->prefix . 'crikey_chat';
	
	$wpdb->insert( 
		$table_name, 
		array( 
			'chatwidget_id' => '1', 
			'version' => '1.0.0', 
			'script' => $script,
			'header_color' => 'rgb(33, 154, 201)',
			'header_font_color' => 'rgb(255, 255, 255)',
			'body_color' => 'rgb(255, 255, 255)',
			'location_layout' => '4',
			'widget_options' => 'Name|Email|PhoneNo|Department',
			'created_time' => $created_time, 
		) 
	);
}
register_activation_hook( __FILE__, 'jal_install' );
register_activation_hook( __FILE__, 'jal_install_data' );

/** Delete table on uninstall */
/**
 * Check for hook
 */
if ( function_exists('register_uninstall_hook') )
    register_uninstall_hook(__FILE__, 'example_deinstall');

 /**
 * Delete options in database
 */
function example_deinstall() {

    global $wpdb;   //required global declaration of WP variable

    $table_name = $wpdb->prefix. 'crikey_chat';

    $sql = "DROP TABLE ". $table_name;

    $wpdb->query($sql);
}


/** Backend menu */
  	/** Step 2 (from text above). */
add_action( 'admin_menu', 'crikey_plugin_menu' );

/** Step 1. */
function crikey_plugin_menu() {
	add_menu_page( 'Crikey Plugin Options', 'Crikeyes', 'manage_options', 'crikey-plugin-settings', 'crikey_plugin_options', plugins_url( 'crikeyes/images/crikeyes_menu.png' ) );
}

/* Include js and css files in back end */
function add_my_css_and_my_js_files(){
        wp_enqueue_script('colorpickerjs', plugins_url('/js/colorpicker.js', __FILE__), true);
        wp_enqueue_style( 'colorpickercss', plugins_url('/css/colorpicker.css', __FILE__), 'all');
        wp_enqueue_style( 'layout', plugins_url('/css/layout.css', __FILE__), 'all');
        wp_enqueue_style( 'crikeystyle', plugins_url('/css/crikeystyle.css', __FILE__), 'all');
        wp_enqueue_style( 'SupportChatPlugin', esc_url_raw( 'http://crikeyes.com/support/Styles/SupportChatPlugin.css' ), array(), null );
    }
    add_action('admin_enqueue_scripts', "add_my_css_and_my_js_files");

/* Include js and css files in front end */
function add_css_js_frontend() {
    wp_enqueue_script('SupportChatPluginjs', plugins_url('/js/SupportChatPlugin.js', __FILE__), true);
    wp_localize_script('SupportChatPluginjs', 'passURL', array( 'plugin_url' => plugins_url() ));
    wp_enqueue_style( 'SupportChatPlugin', esc_url_raw( 'http://crikeyes.com/support/Styles/SupportChatPlugin.css' ), array(), null );
}

add_action( 'wp_enqueue_scripts', 'add_css_js_frontend' ); // wp_enqueue_scripts action hook to link only on the front-end

/** Step 3. */
/** Backend contents */
function crikey_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

    global $wpdb;
    $table_name = $wpdb->prefix . 'crikey_chat';
    $result = $wpdb->get_results("SELECT * FROM $table_name WHERE chatwidget_id = '1'");


    $header_color = $result[0]->header_color;
    $header_text_color = $result[0]->header_font_color;
    $body_color = $result[0]->body_color;
    $widget_option = $result[0]->widget_options;
    $layout = $result[0]->location_layout;
    $script = $result[0]->script;

    if(($layout==1) || ($layout==2)){
        $header_id = 'Crikeyes_leftsideheader';
    } else {
        $header_id = 'Crikeyes_ChatBoxHead';
    }

    if($layout==1) {
        $loc_layout = '<div id="Crikeyes_ChatBox" class="Crikeyes_leftside" style="height: 310px; display: block;">
    <div id="Crikeyes_chatleftobject">
    </div>
    <div id="Crikeyes_leftsideheader" onclick="javascript:MinimizeChatBoxLeft()"  >
        <div id="Crikeyes_ChatBoxHead">
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBoxLeft()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' . plugins_url( 'images/down_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
    </div>
</div>';
    } elseif($layout==2) {
        $loc_layout = '<div id="Crikeyes_ChatBox" class="Crikeyes_rightside" style="height: 310px; display: block;right:-302px;">
    
    <div id="Crikeyes_leftsideheader" onclick="javascript:MinimizeChatBoxRight()" >
        <div id="Crikeyes_ChatBoxHead">
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBoxRight()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/down_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
    </div>
    <div id="Crikeyes_chatleftobject">
    </div>
</div>';
    } elseif($layout==3) {
        $loc_layout = '<div id="Crikeyes_ChatBox" class="Crikeyes_bottomleftchat" style="height: 38px; display: block;">
   
     
        <div id="Crikeyes_ChatBoxHead"  onclick="javascript:MinimizeChatBoxLeftBottom()" >
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBoxLeftBottom()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/up_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
     
     <div id="Crikeyes_chatleftobject">
    </div>
</div>';
    } elseif($layout==4) {
        $loc_layout = '<div id="Crikeyes_ChatBox" style="height: 38px; display: block;">
  
    
        <div id="Crikeyes_ChatBoxHead" onclick="javascript:MinimizeChatBox()" >
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBox()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/up_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
     
      <div id="Crikeyes_chatleftobject">
    </div>
</div>';
    }

    $script = strtr($script, array('$header_color' => $header_color, '$body_color' => $body_color, '$widget_option' => $widget_option, '$header_text_color' => $header_text_color, '$layout' => $loc_layout, '$header_id' => $header_id));

    $option_check  = explode('|', $widget_option);
    foreach ($option_check as $checked) {

        if (strpos($checked, 'Name') !== false) {
            $namecheck = 'checked="checked"';
            $namepreview = 'block';
        }
        if (strpos($checked, 'Email') !== false) {
            $emailcheck = 'checked="checked"';
            $emailpreview = 'block';
        }
        if (strpos($checked, 'PhoneNo') !== false) {
            $phonecheck = 'checked="checked"';
            $phonepreview = 'block';
        }
        if (strpos($checked, 'Department') !== false) {
            $depcheck = 'checked="checked"';
            $depreview = 'block';
        }

    }
    ?>
    <script type="text/javascript">
    //<![CDATA[
         var $j = jQuery.noConflict();
    //]]>
    </script>
    <!-- Load color picker and change color in preview -->
    <script type="text/javascript">
    jQuery(document).ready(function($) {
    $('#colorSelector').ColorPicker({
    	onShow: function (colpkr) {
    		$(colpkr).fadeIn(500);
    		return false;
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    		$('#colorSelector div').css('backgroundColor', '#' + hex);
    		$('#Crikeyes_ChatBoxHead').css('backgroundColor', '#' + hex);
    	}
    });
    $('#colorSelector1').ColorPicker({
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('#colorSelector1 div').css('backgroundColor', '#' + hex);
            $('#Crikeyes_Head').css('color', '#' + hex);
        }
    });
    $('#colorSelector2').ColorPicker({
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('#colorSelector2 div').css('backgroundColor', '#' + hex);
            $('#Crikeyes_ChatBoxContent').css('backgroundColor', '#' + hex);
        }
    });
    /** Get widget options */
    var $cbs1 = $("#Name1").change(function() {
    if ($cbs1.is(":checked")){
            $('#Crikeyes_Name').show( );
        } else {
            $('#Crikeyes_Name').hide( );
        }
    });
    var $cbs2 = $("#Email1").change(function() {
    if ($cbs2.is(":checked")){
            $('#Crikeyes_Email').show( );
        } else {
            $('#Crikeyes_Email').hide( );
        }
    });
    var $cbs3 = $("#PhoneNo1").change(function() {
    if ($cbs3.is(":checked")){
            $('#Crikeyes_Phone').show( );
        } else {
            $('#Crikeyes_Phone').hide( );
        }
    });
    var $cbs4 = $("#Department1").change(function() {
    if ($cbs4.is(":checked")){
            $('#Crikeyes_ddDepartment').show( );
        } else {
            $('#Crikeyes_ddDepartment').hide( );
        }
    });

    });
    </script>

    <!-- All backend contents -->
    <div class="crikey-content-header">
    <h1 class="icon-head head-blog">Chat Widget Manager</h1>
    </div>

    <div class="crikey_admin_content">
    <div class="crikey_admin_left">
    <div id="colorsel">
    <h3 class="pull-left">Live Chat Script</h3>
    <ul id="Ul1" class="selectcolor">
        <li>
        <label>
        Header color:</label>
    	    <div id="colorSelector">
    		    <div style="background-color: <?php echo $header_color; ?>">
    		    </div>
    	    </div>
        </li>
        <div class="clear"></div>
        <li>
        <label>
        Header font color:</label>
    	    <div id="colorSelector1">
    		    <div style="background-color: <?php echo $header_text_color; ?>">
    		    </div>
    	    </div>
        </li>
        <div class="clear"></div>
        <li>
        <label>
        Body color:</label>
    	    <div id="colorSelector2">
    		    <div style="background-color: <?php echo $body_color; ?>">
    		    </div>
    	    </div>
        </li>
        <div class="clear"></div>
        <li>
    	    <label>
    	        Location Layout:</label>
    	    <div id="layoutselect">
    	        <select id="Layout" name="layoutselect">
    	            <option value="1" <?php if($layout=="1") echo 'selected="selected"'; ?>>Left</option>
    	            <option value="2" <?php if($layout=="2") echo 'selected="selected"'; ?>>Right</option>
    	            <option value="3" <?php if($layout=="3") echo 'selected="selected"'; ?>>Left Bottom</option>
    	            <option value="4" <?php if($layout=="4") echo 'selected="selected"'; ?>>Right Bottom</option>
    	        </select></div>
    	</li>
    </ul>
    </div>

    <div id="widget_option">
    <h3 class="pull-left">Widget Options</h3>
    <input type="checkbox" name="wid_options[]" value="Name" id="Name1" <?php echo $namecheck; ?>/>Name<br>
    <input type="checkbox" name="wid_options[]" value="Email" id="Email1" <?php echo $emailcheck; ?>/>Email-id<br>
    <input type="checkbox" name="wid_options[]" value="PhoneNo" id="PhoneNo1" <?php echo $phonecheck; ?>/>Phone Number<br>
    <input type="checkbox" name="wid_options[]" value="Department" id="Department1" <?php echo $depcheck; ?>/>Department 
    </div>
    

    </div>

    <div class="crikey_admin_right">
    <h3 class="pull-left">Preview</h3>

    <!-- Load crikey preview -->
    <div class="crikey_preview">
    	<div id="Crikeyes_ChatBoxHead" style="background-color: <?php echo $header_color; ?>;">
    	    <label id="Crikeyes_Head" style="color: <?php echo $header_text_color; ?>;">
    	        Chat with us!</label>
    	    <a href="javascript:void(0)" id="Crikeyes_MinimizeButton" onclick="javascript:MinimizeChatBox()">
    	        <img id="Crikeyes_minImage" src="<?php echo plugins_url( 'images/up_Arrow.png',  __FILE__  ) ?>"></a>
    	</div>
    	<div id="Crikeyes_chatleftobject">
    	    <div id="Crikeyes_ChatBoxContent" style="background-color: <?php echo $body_color; ?>;">
    	        <div id="Crikeyes_Login">
    	            <div id="Crikeyes_Fields">
    	                <input placeholder="Name" class="Crikeyes_tb5" id="Crikeyes_Name" style="display: <?php echo $namepreview;?>;">
    	                <input placeholder="Email-Id" class="Crikeyes_tb5" id="Crikeyes_Email" style="display: <?php echo $emailpreview;?>;">
    	                <input placeholder="Phone Number" class="Crikeyes_tb5" id="Crikeyes_Phone" style="display: <?php echo $phonepreview;?>;">
    	                <select class="Crikeyes_tb5" id="Crikeyes_ddDepartment" style="display: <?php echo $depreview;?>;">
    	                    <option value="0">Select</option>
    	                    <option value="343">Testing</option>
    	                </select>
    	            </div>
    	            <img id="Crikeyes_Load" src="<?php echo plugins_url( 'images/LoadingWheel.gif',  __FILE__  ) ?>">
    	            <input type="button" onclick="Login();" value="Submit" class="Crikeyes_btn Crikeyes_btn-large Crikeyes_btn-primary"
    	                id="Crikeyes_btnLogin">
    	            <div id="Crikeyes_poweredtext">
    	                Powered by <a href="http://crikeyes.com" target="_blank">Crikeyes</a>
    	            </div>
    	        </div>
    	    </div>
    	</div>
    </div>

    <textarea name="script_display" readonly="readonly" rows="3" id="ReadChatArea">
    <?php echo $script; ?></textarea>
    </div>
    <div class="clear"></div>
        <div class="update-button">
            <input type="submit" name="submit" value="Update" id="generate_script" />
        </div>

    </div>
<?php
}

/** Add ajax for generating script */
add_action( 'admin_footer', 'crikey_action_javascript' ); // Write our JS below here

function crikey_action_javascript() { ?>
    <script type="text/javascript" >
    jQuery( "#generate_script" ).click(function() {
        var header_color = jQuery('#colorSelector div').css("background-color");
        var header_text_color = jQuery('#colorSelector1 div').css("background-color");
        var body_color = jQuery('#colorSelector2 div').css("background-color");
        var widget_option = jQuery('#widget_option input:checked').map(function() {return this.value;}).get().join('|');
        var layout = jQuery( "#Layout option:selected" ).val();

        var data = {
            'action': 'crikey_action',
            'header_color': header_color,
            'header_text_color': header_text_color,
            'body_color': body_color,
            'widget_option': widget_option,
            'layout': layout,
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('#ReadChatArea').html(response);
        });
    });
    </script> <?php
}

/** Ajax action */
add_action( 'wp_ajax_crikey_action', 'crikey_action_callback' );

/** Insert selected datas to database and display on front end */
function crikey_action_callback() {
    global $wpdb; // this is how you get access to the database
    $table_name = $wpdb->prefix . 'crikey_chat';

    $header_color = $_POST['header_color'];
    $header_text_color = $_POST['header_text_color'];
    $body_color = $_POST['body_color'];
    $widget_option = $_POST['widget_option'];
    $layout = $_POST['layout'];
    $updated_time = date("Y-m-d H:i:s");

    if(($layout==1) || ($layout==2)){
        $header_id = 'Crikeyes_leftsideheader';
    } else {
        $header_id = 'Crikeyes_ChatBoxHead';
    }

    if($layout==1) {
        $loc_layout = '<div id="Crikeyes_ChatBox" class="Crikeyes_leftside" style="height: 310px; display: block;">
    <div id="Crikeyes_chatleftobject">
    </div>
    <div id="Crikeyes_leftsideheader" onclick="javascript:MinimizeChatBoxLeft()"  >
        <div id="Crikeyes_ChatBoxHead">
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBoxLeft()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/down_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
    </div>
</div>';
    } elseif($layout==2) {
        $loc_layout = '<div id="Crikeyes_ChatBox" class="Crikeyes_rightside" style="height: 310px; display: block;right:-302px;">
    
    <div id="Crikeyes_leftsideheader" onclick="javascript:MinimizeChatBoxRight()" >
        <div id="Crikeyes_ChatBoxHead">
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBoxRight()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/down_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
    </div>
    <div id="Crikeyes_chatleftobject">
    </div>
</div>';
    } elseif($layout==3) {
        $loc_layout = '<div id="Crikeyes_ChatBox" class="Crikeyes_bottomleftchat" style="height: 38px; display: block;">
   
     
        <div id="Crikeyes_ChatBoxHead"  onclick="javascript:MinimizeChatBoxLeftBottom()" >
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBoxLeftBottom()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/up_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
     
     <div id="Crikeyes_chatleftobject">
    </div>
</div>';
    } elseif($layout==4) {
        $loc_layout = '<div id="Crikeyes_ChatBox" style="height: 38px; display: block;">
  
    
        <div id="Crikeyes_ChatBoxHead" onclick="javascript:MinimizeChatBox()" >
            <label id="Crikeyes_Head">
                Chat with us!</label>
            <a onclick="javascript:MinimizeChatBox()" id="Crikeyes_MinimizeButton" href="javascript:void(0)">
                <img src="' .plugins_url( 'images/up_Arrow.png',  __FILE__  ) . '" id="Crikeyes_minImage"></a>
        </div>
     
      <div id="Crikeyes_chatleftobject">
    </div>
</div>';
    }
    $loc_layout = htmlspecialchars($loc_layout);

    $wpdb->update( 
        $table_name, 
        array( 
            'header_color' => $header_color,  // string
            'header_font_color' => $header_text_color,
            'body_color' => $body_color,
            'widget_options' => $widget_option,
            'location_layout' => $layout,
            'update_time' => $updated_time
        ), 
        array( 'chatwidget_id' => 1 )
    );

    $result = $wpdb->get_results("SELECT script FROM $table_name WHERE chatwidget_id = '1'");
    $script = htmlspecialchars($result[0]->script);
    $script = strtr($script, array('$header_color' => $header_color, '$body_color' => $body_color, '$widget_option' => $widget_option, '$header_text_color' => $header_text_color, '$layout' => $loc_layout, '$header_id' => $header_id));
    echo $script;

    die(); // this is required to terminate immediately and return a proper response
}