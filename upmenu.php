<?php
/*
Plugin Name: Integracja UpMenu
Plugin URI: http://upmenu.com
Description: Plugin do integracji systemu zamówień online UpMenu
Author: Bartek Konopka
Version: 1.0
Author URI: http://bartekkonopka.pl
*/

add_action('admin_menu', 'upmenu_plugin_menu');

function upmenu_plugin_menu() {
	add_menu_page('UpMenu', 'UpMenu', 'administrator', 'upmenu_plugin-settings', 'upmenu_plugin_settings_page', 'dashicons-cart');
}

add_action( 'admin_init', 'upmenu_plugin_settings' );


function upmenu_plugin_settings() { 
	register_setting( 'upmenu_plugin-settings-group', 'account_url' );
	register_setting( 'upmenu_plugin-settings-group', 'account_url_en' );
}

function upmenu_plugin_settings_page() { ?>
	<div class="wrap">
		<h2>Integracja UpMenu</h2>

		<div class="card pressthis">
			<h2>Instrukcja integracji</h2>
			<p>Wypełnij poniższe pola tekstowe. Jeśli nie posiadasz menu w wersji angielskiej drugie pole pozostaw puste.</p>
			<hr>
			<p>Aby wyświetlić menu w wersj polskiej w dowolnym miejscu w treści strony wklej poniższy tag:</p>
			<p><code>[upmenu]</code></p>
			<hr>
			<p>Aby wyświetlić menu w wersji angielskiej wklej:</p>
			<code>[upmenu-en]</code>
			<br><br>
		</div>
		<br>
		<form method="post" action="options.php">
		    <?php settings_fields( 'upmenu_plugin-settings-group' ); ?>
		    <?php do_settings_sections( 'upmenu_plugin-settings-group' ); ?>
		    <table class="form-table">
		        <tr valign="top">
		        	<th scope="row">Adres strony PL:</th>
			        <td>
			        	<input type="text" name="account_url" class="regular-text code" placeholder="http://restauracja.upmenu.com" value="<?php echo esc_attr( get_option('account_url') ); ?>" />
			        	<p class="description">Podaj adres strony z menu w wersji polskiej</p>
			        </td>
		        </tr>
		        <tr>
		        	<th scope="row">Adres strony EN:</th>
		        	<td>
		        		<input type="text" name="account_url_en" class="regular-text code" placeholder="http://restauracja.upmenu.com/en" value="<?php echo esc_attr( get_option('account_url_en') ); ?>" />
		        		<p class="description">Podaj adres strony z menu w wersji angielskiej</p>
		        	</td>
		        </tr>
		    </table>
		    
		    <?php submit_button(); ?>

		</form>
	</div>
<? }


function upmenu_plugin_shortcode(){
	$iframe = 	'<iframe src="#" width="100%" height="700px" frameborder="0" id="upmenu"></iframe>
					<script type="text/javascript">
					    var src = "'. esc_attr( get_option('account_url') ) .'";
					    if(window.location.href.indexOf("?") != -1) {
					        src += "?"+ window.location.href.slice(window.location.href.indexOf("?") + 1);
					    }
					    document.getElementById("upmenu").src = src;
					</script>';
	return $iframe;
}
add_shortcode('upmenu', 'upmenu_plugin_shortcode');


function upmenu_plugin_shortcode_en(){
	$iframe = 	'<iframe src="#" width="100%" height="700px" frameborder="0" id="upmenu"></iframe>
					<script type="text/javascript">
					    var src = "'. esc_attr( get_option('account_url_en') ) .'";
					    if(window.location.href.indexOf("?") != -1) {
					        src += "?"+ window.location.href.slice(window.location.href.indexOf("?") + 1);
					    }
					    document.getElementById("upmenu").src = src;
					</script>';
	return $iframe;
}
add_shortcode('upmenu-en', 'upmenu_plugin_shortcode_en');


?>