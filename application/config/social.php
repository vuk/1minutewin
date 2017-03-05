<?php
/**
 * Created by PhpStorm.
 * User: vuk
 * Date: 24.2.17.
 * Time: 22.47
 */
return
    [
        "base_url"   => "http://1minutewin.com/auth/callback",
        "providers"  => [
            "Google"   => [
                "enabled" => true,
                "keys"    => [ "id" => "137669333889-0a7evojp7l64rv41bs09e8m9mekqs26t.apps.googleusercontent.com", "secret" => "cKc7gmxY5E9aM7bC5mkNuyeP" ],
            ],
            "Facebook" => [
                "enabled"        => true,
                "keys"           => [ "id" => "613231668886012", "secret" => "02f6c2c305875ddd572a2463f2edf628" ],
                "display" => "popup",
                "scope" => ['email']
            ]
        ],
        "debug_mode" => false,
        "debug_file" => "",
    ];