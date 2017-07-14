<?php 
return [
    "/icons/{prefix}" => [
        "get" => [
            "controller" => "Phidias\Icons\Controller->getList({prefix})"
        ]
    ],

    "/icons/{prefix}/{size}/{color}/{icon}" => [
        "get" => [
            "controller" => "Phidias\Icons\Controller->get({prefix}, {size}, {color}, {icon}, {response})"
        ]
    ]
];