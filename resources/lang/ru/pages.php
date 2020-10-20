<?php

return [

    'home' => [
        'label' => 'Главная'
    ],
    'drivingExperience' => [
        'label' => 'Водительский опыт',
        'actionsLabel' => 'Действия',
        'emptySet' => 'На данный момент записей о водительском опыте не найдено.',
        'addModalLabel' => 'Добавить',
        'editModalLabel' => 'Изменить'
    ],
    'carBrands' => [
        'label' => 'Марки автомобиля',
        'brandsLabel' => 'Марки',
        'actionsLabel' => 'Действия',
        'emptySet' => 'На данный момент записей о марках траспорта не найдено.',
        'addModalLabel' => 'Добавить',
        'editModalLabel' => 'Изменить'
    ],
    'carModels' => [
        'label' => 'Модели автомобиля',
        'modelsLabel' => 'Модели',
        'actionsLabel' => 'Действия',
        'emptySet' => 'На данный момент записей о моделях траспорта не найдено.',
        'addModalLabel' => 'Добавить',
        'editModalLabel' => 'Изменить'
    ],
    'brigadirs' => [
        'label' => 'Бригадиры',
        'datatable' => [
            'fullName' => 'ФИО',
            'phoneNumber' => 'Номер телефона',
            'company' => 'Фирма',
            'inn' => 'ИНН или ID',
            'actions' => 'Действия'
        ],
        'emptySet' => 'На данный момент записей о бригадирах не найдено.',
    ],
    'createBrigadir' => [
        'label' => 'Добавить бригадира',
        'addForm' => [
            'label' => 'Данные бригадира',
            'labels' => [
                'mr' => 'Мистер',
                'ms' => 'Миссис',
                'notSure' => 'Не определился',
                'firstName' => 'Имя',
                'lastName' => 'Фамилия',
                'email' => 'Email',
                'photo' => 'Фото',
                'password' => 'Пароль',
                'confirmPassword' => 'Подтвердите пароль',
                'birthday' => 'День рождения',
                'nationality' => 'Национальность',
                'phone' => 'Номер телефона',
                'company' => 'Фирма',
                'inn' => 'ИНН или ID',
            ],
            'placeholders' => [
                'firstName' => 'Введите имя',
                'lastName' => 'Введите фамилию',
                'email' => 'Введите email',
                'photo' => 'Выберите фото',
                'password' => 'Введите пароль',
                'confirmPassword' => 'Подтвердите пароль',
                'birthday' => 'Выберите день рождения',
                'nationality' => 'Выберите страну',
                'phone' => 'Введите номер телефона',
                'company' => 'Введите название фирмы',
                'inn' => 'Введите ИНН или ID',
            ]
        ]
    ],
    'editBrigadir' => [
        'label' => 'Изменить бригадира',
        'addForm' => [
            'label' => 'Данные бригадира',
            'labels' => [
                'mr' => 'Мистер',
                'ms' => 'Миссис',
                'notSure' => 'Не определился',
                'firstName' => 'Имя',
                'lastName' => 'Фамилия',
                'email' => 'Email',
                'photo' => 'Фото',
                'password' => 'Пароль',
                'confirmPassword' => 'Подтвердите пароль',
                'birthday' => 'День рождения',
                'nationality' => 'Национальность',
                'phone' => 'Номер телефона',
                'company' => 'Фирма',
                'inn' => 'ИНН или ID',
            ],
            'placeholders' => [
                'firstName' => 'Введите имя',
                'lastName' => 'Введите фамилию',
                'email' => 'Введите email',
                'photo' => 'Выберите фото',
                'password' => 'Введите пароль',
                'confirmPassword' => 'Подтвердите пароль',
                'birthday' => 'Выберите день рождения',
                'nationality' => 'Выберите страну',
                'phone' => 'Введите номер телефона',
                'company' => 'Введите название фирмы',
                'inn' => 'Введите ИНН или ID',
            ]
        ]
    ],
    'drivers' => [
        'label' => 'Водителя',
        'driverInfoLabel' => 'Информация о водителе',
        'documentsLabel' => 'Документы',
        'uploadedDocumentsLabel' => 'Uploaded documents',
        'noDocumentsLabel' => 'На данный момент документов не найдено.',
        'datatable' => [
            'fullName' => 'ФИО',
            'phoneNumber' => 'Номер телефона',
            'country' => 'Страна проживания',
            'city' => 'Город',
            'drivingExperience' => 'Опыт вождения',
            'actions' => 'Действия'
        ],
        'emptySet' => 'На данный момент записей о водителях не найдено.',
        'addForm' => [
            'label' => 'Данные водителя',
            'labels' => [
                'mr' => 'Мистер',
                'ms' => 'Миссис',
                'notSure' => 'Не определился',
                'firstName' => 'Имя',
                'lastName' => 'Фамилия',
                'email' => 'Email',
                'photo' => 'Фото',
                'password' => 'Пароль',
                'confirmPassword' => 'Подтвердите пароль',
                'birthday' => 'День рождения',
                'nationality' => 'Национальность',
                'phone' => 'Номер телефона',
                'country' => 'Место проживания',
                'city' => 'Город, адрес, индекс',
                // Documents side
                'drivingExperience' => 'Водительский опыт',
                'dlIssuePlace' => 'Где выданы вод. права?',
                'dlIssuedAt' => 'Действует с',
                'dlExpiresAt' => 'Действует до',
                'comment' => 'Комментарий',
                'conviction' => 'Судимость',
                'keptDrunk' => 'Были ли задержаны пьяными?',
                'dtp' => 'Были ли в ДТП в течение 5 лет?',
                'grades' => 'Баллы',
                'gradesExpireAt' => 'Срок действия баллов',
                'dlPhoto' => 'Фото водительского удостоверения (2 стороны)',
                'passportPhoto' => 'Паспорт или ИД (2 стороны)'
            ],
            'placeholders' => [
                'firstName' => 'Введите имя',
                'lastName' => 'Введите фамилию',
                'email' => 'Введите email',
                'photo' => 'Выберите фото',
                'password' => 'Введите пароль',
                'confirmPassword' => 'Подтвердите пароль',
                'birthday' => 'Выберите дату',
                'nationality' => 'Выберите страну',
                'phone' => 'Введите номер телефона',
                'country' => 'Выберите страну',
                'city' => 'Город, адрес, индекс',
                // Documents side
                'dlIssuePlace' => 'Выберите страну',
                'dlIssuedAt' => 'Выберите дату',
                'dlExpiresAt' => 'Выберите дату',
                'comment' => 'Не указано',
                'gradesExpireAt' => 'Выберите дату',
                'dlPhoto' => 'Выберите файл',
                'passportPhoto' => 'Выберите файл'
            ]
        ]
    ],
    'createDriver' => [
        'label' => 'Добавить водителя'
    ],
    'editDriver' => [
        'label' => 'Изменить водителя'
    ],
    'clients' => [
        'label' => 'Клиенты',
        'clientInfoLabel' => 'Информация о клиенте',
        'datatable' => [
            'fullName' => 'ФИО',
            'phoneNumber' => 'Номер телефона',
            'idCard' => 'Номер ID карты',
            'passport' => 'Номер паспорта',
            'actions' => 'Действия'
        ],
        'emptySet' => 'На данный момент записей о клиентах не найдено.',
        'addForm' => [
            'labels' => [
                'mr' => 'Мистер',
                'ms' => 'Миссис',
                'notSure' => 'Не определился',
                'firstName' => 'Имя',
                'lastName' => 'Фамилия',
                'email' => 'Email',
                'photo' => 'Фото',
                'password' => 'Пароль',
                'confirmPassword' => 'Подтвердите пароль',
                'birthday' => 'День рождения',
                'nationality' => 'Национальность',
                'phone' => 'Номер телефона',
                'idCard' => 'Номер ID карты',
                'idCardExpiresAt' => 'ID карта действительна до',
                'passport' => 'Номер паспорта',
                'passportExpiresAt' => 'Паспорт действителен до'
            ],
            'placeholders' => [
                'firstName' => 'Введите имя',
                'lastName' => 'Введите фамилию',
                'email' => 'Введите email',
                'photo' => 'Выберите фото',
                'password' => 'Введите пароль',
                'confirmPassword' => 'Подтвердите пароль',
                'birthday' => 'Выберите дату',
                'nationality' => 'Выберите страну',
                'phone' => 'Введите номер телефона',
                'idCard' => 'Введите номер ID карты',
                'idCardExpiresAt' => 'Выберите дату',
                'passport' => 'Введите номер паспорта',
                'passportExpiresAt' => 'Выберите дату'
            ]
        ]
    ],
    'createClient' => [
        'label' => 'Добавить водителя'
    ],
    'editClient' => [
        'label' => 'Изменить водителя'
    ],
    'transport' => [
        'label' => 'Транспорт',
        'bindDriverBtn' => 'Привязать водителя',
        'emptySet' => 'На данный момент транспортных средств в базе не найдено.',
        'noDriversBound' => 'Водителей не привязано',
        'bindDriverModal' => [
            'label' => 'Привязать водиетеля',
            'transportLabel' => 'Транспортное средство',
            'chooseTransportLabel' => 'Выберите транспорт',
            'driverLabel' => 'Водитель',
            'chooserDriverLabel' => 'Выберите водителя',
            'bindDriverBtn' => 'Привязать',
            'firstAddTransportLabel' => 'Сначала добавьте транспортное средство',
            'firstAddDriverLabel' => 'Сначала добавьте водителя'
        ]
    ]

];
