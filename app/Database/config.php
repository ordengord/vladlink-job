<?
return [
    'host' => 'localhost',

    'name' => "zenkin-vladlink",

    'user' => "root",

    'password' => "",

    'charset' => 'utf8',

    'table' => 'categories',

    'categories' =>
        [
            'id' => 'INT(10) NOT NULL',
            'name' => 'VARCHAR(50)',
            'alias' => 'VARCHAR(15)',
            'parent_id' => 'INT (10)'
        ]
];