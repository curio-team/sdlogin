<?php

namespace App\Http\Controllers\Auth;
use Carbon\Carbon;
use ZxcvbnPhp\Zxcvbn;

trait ChecksPasswords
{
    
    public function check_password($password, $user = null)
    {
        $userDetails = array();
        if($user != null)
        {
            $userDetails = array($user->name, $user->email);
        }

        $zxcvbn = new Zxcvbn();
        $strength = $zxcvbn->passwordStrength($password, $userDetails);
        $seconds = time() + (int) $strength['crack_time'];
        $seconds = Carbon::createFromTimestamp($seconds);
        $strength['time_display'] = $seconds->diffForHumans(null, true);
        
        $return = array(
            "passes" => ($strength['score'] < 3) ? false : true,
            "score" => $strength['score'],
            "time" => $strength['time_display'],
        );

        return (object) $return;
    }

}
