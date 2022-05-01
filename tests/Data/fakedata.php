<?php declare(strict_types=1);

return [
    'people' => [
        '1' => [
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
        '2' => [
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
        '1' => [
            'name' => 'Semicondutor',
            'type' => 'Eletrônico',
            'model' => 'Hanashi',
            'description' => 'Aqui vai uma descrição do produto',
            'stock' => '15',
            'image_path' => __DIR__ .'/parts/image_1.png'
        ],
        '2' => [
            'name' => 'Computador',
            'type' => 'Notebook',
            'model' => 'Asus VivoBook',
            'description' => 'Notebook 4GB RAM, Intel Core i5-1035G1, 15.6" HD, 1TB SSD, Windows 10',
            'stock' => '1',
            'image_path' => __DIR__ .'/parts/image_2.png'
        ]
    ]
];