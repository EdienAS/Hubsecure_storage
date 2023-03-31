<?php

return [

    'role_id' => array(2),

    'frontend_endpoints' => array(
        'sign_up'   => '/auth/sign-up',
        'sign_in'   => '/auth/sign-in',
        'pages_share' => '/pages/share/',
        
    ),
    
    'xrpl_block' => array(
        'endpoints' => array(
            'generate_client_encryption_key' => '/gen/key/client',
            'generate_wallet' => '/test/test_wallet',
            'upload_document' => '/block/upload',
            'create_block' => '/block/create',
            'get_block_status' => '/block/status/',
            'get_document' => '/block/document'
        ),
        'status' => array(
            'pending' => 'pending',
            'processing' => 'processing',
            'minting' => 'minting',
            'compleated' => 'compleated',
            'completed' => 'completed'
        )
    )
];

