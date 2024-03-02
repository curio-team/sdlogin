<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use ZxcvbnPhp\Zxcvbn;

trait ChecksPasswords
{
    public function checkPassword($password, $user = null)
    {
        $userDetails = [];

        if ($user != null) {
            $userDetails = [$user->name, $user->email];
        }

        $zxcvbn = new Zxcvbn();
        $strength = $zxcvbn->passwordStrength($password, $userDetails);

        $seconds = (int)(time() + (int)($strength['crack_times_seconds']['online_no_throttling_10_per_second']));
        try {
            $seconds = Carbon::createFromTimestamp($seconds);
            $strength['time_display'] = $seconds->diffForHumans(null, true);
        } catch (\Exception $e) {
            $strength['time_display'] = '3 miljoen jaar';
        }

        $return = [
            'passes' => ($strength['score'] < 2) ? false : true,
            'feedback' => [
                'Het gekozen wachtwoord is niet sterk genoeg.',
                'Dit wachtwoord zou in ongeveer ' . $strength['time_display'] . ' te raden zijn!',

                ...(!empty($strength['feedback']['warning']) ? [__($strength['feedback']['warning'])] : []),
                ...collect($strength['feedback']['suggestions'])->map(function ($suggestion) {
                    return __($suggestion);
                }),
            ],
            'time' => $strength['time_display'],
        ];

        return (object) $return;
    }
}
