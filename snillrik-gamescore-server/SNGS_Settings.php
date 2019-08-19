<?php
// The settings menu

class SNGS_Settings
{
    public function __construct()
    {
        add_action('admin_menu', array($this,'snillrik_gamescore'));
    }

    public function snillrik_gamescore()
    {
        add_menu_page('Gamescore', 'Gamescore settings', 'administrator', __FILE__, array($this,'kallios_snillrik_gamescore_page'), plugins_url('/images/snillrik_bulb.svg', __FILE__));
        add_action('admin_init', array($this,'register_snillrik_gamescore_settings'));
    }

    public function register_snillrik_gamescore_settings()
    {
        //register our settings
        register_setting('snillrik-gamescore-settings-group', 'snillrik_gamescore_token');
        //register_setting( 'kallios-drone-settings-group', 'kallios_drone_texten');
        //register_setting( 'kallios-drone-settings-group', 'kallios_drone_color');
    }

    public function kallios_snillrik_gamescore_page(){
		echo '<div class="wrap snillrik-gamescore">
				<h2>DrOne4000 settings</h2>
				<form method="post" action="options.php">';
    	settings_fields('snillrik-gamescore-settings-group');
    	do_settings_sections('snillrik-gamescore-settings-group');


    	echo '<table class="form-table">
        <tr>
        	<td>
        		<h3>Settings for the game server.</h3>
        		<p>Not sure what just yet, but pretty sure it will be needed.</p>
        		<input id="snillrik_gamescore_token" name="snillrik_gamescore_token" value="'.get_option("snillrik_gamescore_token").'" />
        	</td>
        	<td>
        	</td>
		</tr>
    </table>';

    submit_button();

	echo '</form>
	</div>';

}
}

?>