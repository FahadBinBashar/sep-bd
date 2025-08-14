<?php
namespace Config;

use CodeIgniter\Database\Config as DatabaseConfig;

class Database extends DatabaseConfig
{
    public array $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'sepbdco1_db',
        'password' => 'Fahad@#25845',
        'database' => 'sepbdco1_db',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'cacheOn'  => false,
        'cacheDir' => '',
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];
}
