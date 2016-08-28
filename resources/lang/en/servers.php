<?php

return [

    'not_found' => 'Server ":server" not found.',
    'server_created' => 'Server created successfully.',
    'name_exists' => 'Server with name ":name" already exists.',
    'name_exists_try' => 'Server with name ":name" already exists, try again.',
    'invalid_path_try' => 'Path ":path" not found, try again.',
    'invalid_binary_try' => 'Binary ":binary" not found, try again.',

    'create' => [
        'name' => 'Server Name (used to identify server in commands)',
        'path' => 'Binary Directory (must be directory, do not include binary)',
        'binary' => 'Binary (executable file inside Binary Directory)',
        'game' => 'Server Game',
        'ip' => 'Server IP',
        'port' => 'Server Port',
        'rcon' => 'Server RCON Password',
        'params' => 'Server Parameters',
        'surveil' => 'Run Surveil on Server?'
    ],

    'delete' => [
        'confirm' => 'Are you sure you wish to delete ":server"?',
        'aborted' => 'Server deletion aborted.',
        'success' => 'Server deleted successfully.'
    ],

    'config' => [

        'not_found' => 'Config ":name" not found.',
        'not_found_for' => 'Config ":name" not found for Server ":server".',
        'config_created' => 'Config created successfully.',
        'name_exists' => 'Config with name ":name" already exists.',
        'name_exists_try' => 'Config with name ":name" already exists, try again.',

        'create' => [

            'name' => 'Config Name (used to load configuration)',

        ]

    ]

];
