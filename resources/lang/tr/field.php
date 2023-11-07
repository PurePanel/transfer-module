<?php

return [
    'name' => ['name' => "Transfer Adı"],
    'target' => ['name' => "Site"],
    'source_ip' => ['name' => "Kaynak IP"],
    'source_port' => ['name' => "Kaynak Port"],
    'source_username' => ['name' => "Kaynak Kullanıcı Adı"],
    'source_password' => ['name' => "Kaynak Şifre"],
    'source_database' => ['name' => "Kaynak Veritabanı"],
    'source_database_user' => ['name' => "Kaynak Veritabanı Kullanıcı Adı"],
    'source_database_password' => ['name' => "Kaynak Veritabanı Şifresi"],
    'source_directory_path' => ['name' => "Kaynak Dizin Yolu (Dizinin sonuna / koymayı unutmayınız!)"],
    'transfer_database' => ['name' => "Database Transfer Edilsin mi?"],
    'status' => ['name' => "Durum"],

    // Server Streams
    'server_name' => [
        'name' => 'Sunucu Adı',
    ],
    'server_ip' => [
        'name' => 'Sunucu IP Adresi',
    ],
    'server_ssh_port' => [
        'name' => 'Sunucu SSH Portu',
    ],
    'server_ssh_username' => [
        'name' => 'Sunucu SSH Kullanıcı Adı',
    ],
    'server_ssh_password' => [
        'name' => 'Sunucu SSH Şifresi',
    ],
    'server_directory_schema' => [
        'name' => 'Sunucu Dizin Şeması',
    ],
    'server_database_root_username' => [
        'name' => 'Sunucu Veritabanı Root Kullanıcı Adı',
    ],
    'server_database_root_password' => [
        'name' => 'Sunucu Veritabanı Root Şifresi',
    ],

    'username' => [
        'name' => 'Kullanıcı Adı',
        'instructions' => 'Bu kullanıcı adı <b>"/home/%username%/public/"</b> alanına gelecektir.Lütfen sitenin kullanıcı adını belirtiniz.'
    ],
    'server' => [
        'name' => 'Sunucu',
    ],
    'database_name' => [
        'name' => 'Database Name',
    ],
    'target_site' => [
        'name' => 'Hedef Site',
        'instructions' => 'Aktarımın yapılacağı siteyi temsil eder.Bu aktarım verileri ilgili siteye aktarılacaktır.'
    ],
];
