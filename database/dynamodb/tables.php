<?php

return [
    [
        'TableName'             => 'shares',
        'AttributeDefinitions'  => [
            [
                'AttributeName' => 'id',
                'AttributeType' => 'S',
            ],
        ],
        'KeySchema'             => [
            [
                'AttributeName' => 'id',
                'KeyType'       => 'HASH',
            ],
        ],
        'ProvisionedThroughput' => [
            'ReadCapacityUnits'  => 10,
            'WriteCapacityUnits' => 20,
            'OnDemand'           => false,
        ],
    ],
    // add further tables here
];
