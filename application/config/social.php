<?php
/**
 * Created by PhpStorm.
 * User: vuk
 * Date: 24.2.17.
 * Time: 22.47
 */
return
    [
        "base_url"   => "http://1minutewin.com/",
        "providers"  => [
            "Google"   => [
                "enabled" => true,
                "keys"    => [ "id" => "", "secret" => "" ],
            ],
            "Facebook" => [
                "enabled"        => true,
                "keys"           => [ "id" => "", "secret" => "" ],
                "trustForwarded" => false
            ],
            "Twitter"  => [
                "enabled" => true,
                "keys"    => [ "key" => "", "secret" => "" ]
            ],
        ],
        "debug_mode" => true,
        "debug_file" => "bug.txt",
    ];