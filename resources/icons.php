<?php
return [

    /* OLD resource, for backwards compatibility only */
    "/icons/{filename}" => [
        "get" => [
            "controller" => "Phidias\Icons\Controller->old({filename}, {query}, {response})"
        ]
    ],

    "/icons/{prefix}/list" => [
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