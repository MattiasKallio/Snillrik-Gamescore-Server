<?php
/**
 * To handle shortcodes
 */

class SNGS_Shortcodes
{
    public function __construct()
    {
        //add shortcode
        wp_enqueue_style( 'snillrik_gamescore',plugin_dir_url( __FILE__ ).'/css/gamescore.css'  );
        add_shortcode('gamescore_toplist', array($this, 'snillrik_gamescore_toplist'));
    }

    /**
     * Shortcode for listpage, ie lists of different statuses from different warehouses.
     * @mainadminpage attribute for shortcode to get main admin page (ie bil)
     */
    public function snillrik_gamescore_toplist($atts=[])
    {

        $attributes = shortcode_atts(array(
            'gamename' => 'DrOne4000',
            'level' => 'ZB6'
        ), $atts);

        //$user = wp_get_current_user();

        $user_args = array(
            'meta_key' => 'sngs_'.$attributes["gamename"].'_level_'.$attributes["level"].'_time',
            'number' => 100,
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        );
        
        $top_users = get_users($user_args);
        
        $str_out = "";
        $counter = 1;

        $str_out .= "<li>";
        $str_out .= "<div style='text-align:center;'><strong>#</strong><strong>Name</strong></div><div><strong>Time</strong></div><div><strong>Kills</strong></div>";
        $str_out .= "</li>";

        foreach($top_users as $user){

            $top_info = get_user_meta($user->ID,'sngs_' . $attributes["gamename"] . '_level_' . $attributes["level"].'_full', true);
                
                //array('score'=>$score,'time'=>$time,'kills'=>$kills));

            //$timeen = date("i:s", $top_info["time"]/1000);
            $timeen = $this->formatMilliseconds($top_info["time"]);

            $str_out .= "<li>";
            $str_out .= "<div><strong>".$counter."</strong> ".$user->display_name . "</div><div>" . $timeen . "</div><div>" . $top_info["kills"]."</div>";//<div>" . print_r($top_info,true)."</div>";
            $str_out .= "</li>";
            $counter++;
        }

        //return 'sngs_'.$attributes["gamename"].'_level_'.$attributes["level"].'_time'."Gamescores, top 10: ";
        return "<div class='snillrik_gamescore'><ul>".$str_out."<ul></div>";

    }

    private function formatMilliseconds($milliseconds) {
        $seconds = floor($milliseconds / 1000);
        $minutes = floor($seconds / 60);
        //$hours = floor($minutes / 60);
        $milliseconds = $milliseconds % 1000;
        $seconds = $seconds % 60;
        $minutes = $minutes % 60;
    
        $format = '%02u:%02u.%03u';
        $time = sprintf($format, $minutes, $seconds, $milliseconds);
        return rtrim($time, '0');
    }

    /**
     * get top 100 maybe?
     *
     */
    public function getUserScore($gamename, $infos = array())
    {
        $user = wp_get_current_user();

        if ($gamename && $level) {
            //return "MEE!".print_r($_POST,true);
            $current_time = get_user_meta($user->id, 'sngs_' . $gamename . '_level_' . $level . '_time');
            if ($time < $current_time) {
                update_user_meta($user->id, 'sngs_' . $gamename . '_level_' . $level . '_score', $score);
                update_user_meta($user->id, 'sngs_' . $gamename . '_level_' . $level . '_time', $time);
                update_user_meta($user->id, 'sngs_' . $gamename . '_level_' . $level . '_kills', $kills);
                update_user_meta($user->id, 'sngs_' . $gamename . '_level_' . $level . '_full', array('score' => $score, 'time' => $time, 'kills' => $kills));
                return "Score added to db.";
            } else {
                return "You have a better time: " . date("i:s", $current_time / 1000);
            }
        } else {
            return "missing..." . print_r($_POST, true);
        }
    }

}
