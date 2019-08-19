<?php
/**
 * To handle user and user requests
 */

class SNGS_User
{
    public function __construct()
    {
        add_action('rest_api_init', function () {
            register_rest_route('/jwt-auth/v1', '/user/(?P<id>\d+)', array(
                'methods' => 'POST',
                'callback' => array($this, 'setUserScore'),
                'permission_callback' => function($request){	  
                    return is_user_logged_in();
                  }
            ));
        });

    }

    public function setUserScore($gamename, $infos = array())
    {
        $user = wp_get_current_user();

        $gamename = isset($_POST['gamename']) ? sanitize_text_field($_POST['gamename']) : false;
        $level = isset($_POST['level']) ? sanitize_text_field($_POST['level']) : false;
        $score = isset($_POST['score']) && is_numeric($_POST['score']) ? $_POST['score'] : false;
        $time = floatval(isset($_POST['time']) ? sanitize_text_field($_POST['time']) : false);
        $kills = isset($_POST['kills']) && is_numeric($_POST['kills']) ? $_POST['kills'] : false;
        $scoretime = isset($_POST['scoretime']) && is_numeric($_POST['scoretime']) ? $_POST['scoretime'] : false;

        if ($gamename && $level) {
            //return "MEE!".print_r($_POST,true);
            $current_time = get_user_meta($user->id,'sngs_' . $gamename . '_level_' . $level.'_time', true);
            if(($time<floatval($current_time) || $current_time=="") || floatval($current_time)==0.0){
                update_user_meta($user->id, 'sngs_' . $gamename . '_level_' . $level.'_score', $score);
                update_user_meta($user->id, 'sngs_' . $gamename . '_level_' . $level.'_time', $time);
                update_user_meta($user->id, 'sngs_' . $gamename . '_level_' . $level.'_kills', $kills);
                update_user_meta($user->id, 'sngs_' . $gamename . '_level_' . $level.'_full', array('score'=>$score,'time'=>$time,'kills'=>$kills,'scoretime'=>$scoretime));
                return "New highscore: ".date("i:s",($time/1000));
            }
            else{
                return "Your best time: ".date("i:s",(floatval($current_time)/1000));
            }
        } else {
            return "missing...".print_r($_POST,true);
        }
    }

    public function set_user_score($request)
    {
        //die(print_r($request,true));
        $parameters = $request->get_params();

        $connectiontoken = sanitize_text_field(urldecode($parameters["connectiontoken"]));
        $servertoken = get_option("snillrik_gamescore_token");
        if ($connectiontoken == $servertoken) {
            echo "Woohoo, det är samma!";
        }

        /*  $userid = $getuseridfromtokensomehow = 1;
        //$userid = sanitize_text_field(urldecode($parameters["user"]));

        $score = sanitize_text_field(urldecode($parameters["score"]));
        $level = sanitize_text_field(urldecode($parameters["level"]));
        $time = sanitize_text_field(urldecode($parameters["time"]));
        $kills = sanitize_text_field(urldecode($parameters["kills"]));

        setUserScore($userid, $gamename, array(
        "score"=>$score,
        "level"=>$level,
        "time"=>$time,
        "kills"=>$kills,
        )); */

        //return "woohoo ".$userid;
    }

}
