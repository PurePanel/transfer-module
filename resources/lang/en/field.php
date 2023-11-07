<?php

return [
    'name' => ['name' => "Transfer Name"],
    'target' => ['name' => "Site"],
    'source_ip' => ['name' => "Source IP"],
    'source_port' => ['name' => "Source Port"],
    'source_username' => ['name' => "Source Username"],
    'source_password' => ['name' => "Source Password"],
    'source_database' => ['name' => "Source Database"],
    'source_database_user' => ['name' => "Source Database User"],
    'source_database_password' => ['name' => "Source Database Password"],
    'source_directory_path' => ['name' => "Source Directory Path"],
    'transfer_database' => ['name' => "Transfer Database"],
    'status' => ['name' => "Status"],

    // Server Streams
    'server_name' => [
        'name' => 'Server Name',
    ],
    'server_ip' => [
        'name' => 'Server IP Address',
    ],
    'server_ssh_port' => [
        'name' => 'Server SSH Port',
    ],
    'server_ssh_username' => [
        'name' => 'Server SSH Username',
    ],
    'server_ssh_password' => [
        'name' => 'Server SSH Password',
    ],
    'server_directory_schema' => [
        'name' => 'Server Directory Schema',
    ],
    'server_database_root_username' => [
        'name' => 'Server Database Root Username',
    ],
    'server_database_root_password' => [
        'name' => 'Server Database Root Password',
    ],

    'username' => [
        'name' => 'Username',
        'instructions' => 'This username will appear in the <b>"/home/%username%/public/"</b> field. Please specify the username of the site.'
    ],
    'server' => [
        'name' => 'Server',
    ],
    'database_name' => [
        'name' => 'Database Name',
    ],
    'target_site' => [
        'name' => 'Target Site',
        'instructions' => 'It represents the site where the transfer will be made. This transfer data will be transferred to the relevant site.'
    ],
];
