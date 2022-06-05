<?php

declare(strict_types=1);

return [
    'people' => [
        [
            'id' => 1,
            'userName' => 'user1',
            'email' => 'test@hotmail.com',
            'cpf' => '123456789',
            'fullName' => 'Chris Evans',
            'school' => 'Oxford',
            'phoneNumber1' => '(11) 99999-9999',
            'phoneNumber2' => '(11) 91245-1234',
            'password' => 'password',
            'address' => 'Avenida Paulista, 12',
            'city' => 'São Paulo',
            'state' => 'São Paulo',
            'district' => 'Centro',
            'zipCode' => '48830-000'
        ],
        [
            'id' => 2,
            'userName' => 'user2',
            'email' => 'test2@hotmail.com',
            'cpf' => '987654321',
            'fullName' => 'Rafaela Alves',
            'school' => 'Cambridge',
            'phoneNumber1' => '(41) 98888-8888',
            'phoneNumber2' => '(41) 96789-5678',
            'password' => 'password',
            'address' => 'Av. Rachel de Queiroz, 93',
            'city' => 'Campo Grande',
            'state' => 'Mato Grosso do Sul',
            'district' => 'Jardim Aero Rancho',
            'zipCode' => '79083-180'
        ]
    ],
    'eletronicParts' => [
        [
            'id' => 1,
            'personId' => 1,
            'name' => 'Semicondutor',
            'type' => 'Eletrônico',
            'model' => 'Hanashi',
            'description' => 'Aqui vai uma descrição do produto',
            'stock' => 15,
            'image' => [
                'name' => 'image_1.png',
                'type' => 'image/png',
                'tmp_name' => __DIR__ . '/parts/image_1.png',
            ]
        ],
        [
            'id' => 2,
            'personId' => 1,
            'name' => 'Computador',
            'type' => 'Notebook',
            'model' => 'Asus VivoBook',
            'description' => 'Notebook 4GB RAM, Intel Core i5-1035G1, 15.6" HD, 1TB SSD, Windows 10',
            'stock' => 2,
            'image' => [
                'name' => 'image_2.png',
                'type' => 'image/png',
                'tmp_name' => __DIR__ . '/parts/image_2.png',
            ]
        ],
        [
            'id' => 3,
            'personId' => 1,
            'name' => 'Semicondutor Metálico',
            'type' => 'Eletrônico',
            'model' => 'Hanashi',
            'description' => 'Aqui vai uma descrição do produto',
            'stock' => 15,
            'image' => [
                'name' => 'image_3.png',
                'type' => 'image/png',
                'tmp_name' => __DIR__ . '/parts/image_3.png',
            ]
        ],
        [
            'id' => 4,
            'personId' => 2,
            'name' => 'Computador Gamer',
            'type' => 'Notebook',
            'model' => 'Asus VivoBook',
            'description' => 'Notebook 4GB RAM, Intel Core i5-1035G1, 15.6" HD, 1TB SSD, Windows 10',
            'stock' => 13,
            'image' => [
                'name' => 'image_4.png',
                'type' => 'image/png',
                'tmp_name' => __DIR__ . '/parts/image_4.png',
            ]
        ],
        [
            'id' => 5,
            'personId' => 2,
            'name' => 'Computador Gamer Pro',
            'type' => 'Notebook',
            'model' => 'Asus VivoBook',
            'description' => 'Notebook 8GB RAM, Intel Core i5-1137G7, 15.6" HD, 2TB SSD, Windows 11',
            'stock' => 1,
            'image' => [
                'name' => 'image_4.png',
                'type' => 'image/png',
                'tmp_name' => __DIR__ . '/parts/image_4.png',
            ]
        ],
        [
            'id' => 6,
            'personId' => 2,
            'name' => 'Notebook Gamer Pro2',
            'type' => 'Notebook',
            'model' => 'Asus VivoBook',
            'description' => 'Notebook 16GB RAM, Intel Core i9-12900K, 15.6" HD, 2TB SSD, Windows 11',
            'stock' => 3,
            'image' => [
                'name' => 'image_4.png',
                'type' => 'image/png',
                'tmp_name' => __DIR__ . '/parts/image_4.png',
            ]
        ]
    ]
];
