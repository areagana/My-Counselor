<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'clients' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'issues' => 'c,r,u,d',
            'records' => 'c,r,u,d',
            'schedules' => 'c,r,u,d',
            'documents' => 'c,r,u,d',
            'backgrounds' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'counsellor' => [
            'clients' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'issues' => 'c,r,u,d',
            'records' => 'c,r,u,d',
            'schedules' => 'c,r,u,d',
            'documents' => 'c,r,u,d',
            'backgrounds' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'user' => [
            'profile' => 'r,u',
        ],
      
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
