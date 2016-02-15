<?php return [

    "/icons" => [
        "get" => [
            "controller" => "Phidias\Icons\Controller->getList()"
        ]
    ],

    "/icons/{icon*}" => [
        "get" => [
            "controller" => "Phidias\Icons\Controller->get({icon}, {request}, {response})"
        ]
    ]

];