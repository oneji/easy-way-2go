<?php

return [

    'home' => [
        'label' => 'Главная'
    ],

    'drivingExperience' => [
        'label' => 'Водительский опыт',
        'actionsLabel' => 'Действия',
        'successAddedAlert' => 'Опыт успешно добавлен.',
        'successEditedAlert' => 'Опыт успешно обновлен.',
        'emptySet' => 'На данный момент записей о водительском опыте не найдено.',
        'addModalLabel' => 'Добавить',
        'editModalLabel' => 'Изменить'
    ],

    'languages' => [
        'label' => 'Языки',
        'codeLabel' => 'Код',
        'actionsLabel' => 'Действия',
        'successAddedAlert' => 'Язык успешно добавлен',
        'successEditedAlert' => 'Язык успешно обновлен',
        'emptySet' => 'На данный момент записей о языках не найдено.',
        'addModalLabel' => 'Добавить',
        'editModalLabel' => 'Изменить'
    ],

    'countries' => [
        'label' => 'Страны',
        'codeLabel' => 'Код',
        'actionsLabel' => 'Действия',
        'successAddedAlert' => 'Страна успешно добавлена',
        'successEditedAlert' => 'Страна успешно обновлена',
        'emptySet' => 'На данный момент записей о языках не найдено.',
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
    
    'cargoTypes' => [
        'label' => 'Типы груза',
        'modelsLabel' => 'Типы',
        'actionsLabel' => 'Действия',
        'emptySet' => 'На данный момент записей о типах груза не найдено.',
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
        ],
        'form' => [
            'addFormLabel' => 'Добавить транспортное средство',
            'editFormLabel' => 'Изменить траспортное средство',
            'documentsLabel' => 'Документы',
            'uploadedDocumentsLabel' => 'Добавленные документы',
            'noDocumentsLabel' => 'На данный момент документов не найдено',
            'labels' => [
                'transportRegistered' => 'Автомобиль зарегистрирован?',
                'company' => 'Фирма',
                'individual' => 'Физ. лицо',
                'country' => 'Страна регистрации',
                'city' => 'Город, адрес, индекс регистрации транспорта',
                'carNumber' => 'Номер автомобиля',
                'brand' => 'Марка',
                'model' => 'Модель',
                'year' => 'Год выпуска',
                'inspectionFrom' => 'Тех осмотр с',
                'inspectionTo' => 'Тех осмотр до',
                'insuranceFrom' => 'Страхование с',
                'insuranceTo' => 'Страхование до',
                'hasCmr' => 'Есть  CMR?',
                'yes' => 'Да',
                'no' => 'Нет',
                'passengerSeats' => 'Кол-во пассажирских мест',
                'cuboMetres' => 'Сколько кубометров можете вести?',
                'kilos' => 'Сколько киллограмм можете вести?',
                'okForMove' => 'Транспорт подходит для переезда?',
                'canPullTrailer' => 'Можете ли тянуть прицеп?',
                'hasTrailer' => 'Есть ли трейлер?',
                'palletTransportation' => 'Перевозка паллетов?',
                'conditioner' => 'Кондиционер',
                'wifi' => 'Wi-Fi',
                'tvVideo' => 'Tv-Video',
                'disabledPeopleSeats' => 'Места для инвалидов',
                // Documents side
                'passportPhoto' => 'Фото паспорта (2 стороны)',
                'tehOsmotrPhoto' => 'Тех осмотр (2 стороны)',
                'insurancePhoto' => 'Страховка (2 стороны)',
                'peopleLicensePhoto' => 'Лицензия на перевозку людей (2 стороны)',
                'carPhoto' => 'Фото автомобиля',
                'trailerPhoto' => 'Фото трейлера'
            ],
            'placeholders' => [
                'country' => 'Выберите страну',
                'city' => 'Город, адрес, индекс',
                'carNumber' => 'Не указано',
                'inspectionFrom' => 'Тех осмотр с',
                'inspectionTo' => 'Тех осмотр до',
                'insuranceFrom' => 'Страхование с',
                'insuranceTo' => 'Страхование до',
                'passengerSeats' => 'Не указано',
                'cuboMetres' => 'Не указано',
                'kilos' => 'Не указано',
                // Documents side
                'passportPhoto' => 'Выберите файл',
                'tehOsmotrPhoto' => 'Выберите файл',
                'insurancePhoto' => 'Выберите файл)',
                'peopleLicensePhoto' => 'Выберите файл',
                'carPhoto' => 'Выберите файл',
                'trailerPhoto' => 'Выберите файл'
            ]
        ]
    ],

    'routes' => [
        'label' => 'Маршруты водителей',
        'driverInfoLabel' => 'Все маршруты',
        'infoModalLabel' => 'Просмотр маршрута',
        'from' => 'Туда',
        'to' => 'Обратно',
        'transport' => 'Транспорт',
        'status' => 'Статус',
        'actions' => 'Действия',
        'calendar' => 'Календарь',
        'departureDate' => 'Дата отправления',
        'departureTime' => 'Время отправления',
        'arrivalDate' => 'Дата прибытия',
        'arrivalTime' => 'Время прибытия',
        'type' => 'Тип',
        'routeAddresses' => 'Адреса маршрута',
        'noAddressesWarning' => 'Перед сохранением добавьте хотя бы один адрес!',
        'address' => 'Город, адрес',
        'emptySet' => 'На данный момент маршрутов водителей в базе не найдено.',
    ],

    'bas' => [
        'label' => 'Заявки на Бизнес-аккаунт',
        'baInfoLabel' => 'Все заявки',
        'approveBtn' => 'Принять',
        'declineBtn' => 'Отклонить',
        'generateRandomPassBtn' => 'Случайный пароль',
        'generalInfo' => 'Общая информация',
        'userInfo' => 'Данные пользователя',
        'driversAndTransport' => 'Водители и Транспорт',
        'datatable' => [
            'request' => 'Заявка',
            'type' => 'Тип',
            'status' => 'Статус',
            'actions' => 'Действия',
            'date' => 'Дата',
            'statusApproved' => 'Принята',
            'statusPending' => 'В обработке',
            'statusDeclined' => 'Отклонена'
        ],
        'firmOwner' => [
            'label' => 'Собственник фирмы',
            'companyName' => 'Названик фирмы',
            'name' => 'ФИО',
            'email' => 'Email адрес',
            'phoneNumber' => 'Номер телефона',
            'inn' => 'ИНН или ID',
            'nationality' => 'Национальность',
            'country' => 'Страна проживания',
            'password' => 'Придумайте пароль',
            'passwordConfirmation' => 'Подтвердите пароль'
        ],
        'mainDriver' => [
            'label' => 'Главный водитель',
            'name' => 'ФИО',
            'birthday' => 'День рождения',
            'nationality' => 'Национальность',
            'phoneNumber' => 'Номер телефона',
            'email' => 'Email адрес',
            'country' => 'Место проживания',
            'dlIssuePlace' => 'Где были выданы водительские права?',
            'dlIssuedAt' => 'Водительские права действуют с',
            'dlExpiresAt' => 'Водительские права действуют до',
            'drivingExperience' => 'Водительский опыт',
            'conviction' => 'Судимость',
            'comment' => 'Коммент',
            'wasKeptDrunk' => 'Были ли задержаны пьяными?',
            'grades' => 'Баллы',
            'gradesExpireAt' => 'Срок действия баллов',
            'dtp' => 'Были ли в ДТП в течение 5 лет?'
        ],
        'emptySet' => 'На данный момент заявок в базе не найдено.',
    ],

    'orders' => [
        'label' => 'Заказы',
        'infoLabel' => 'Все заказы',
        'from' => 'Откуда',
        'to' => 'Куда',
        'date' => 'Дата',
        'client' => 'Заказчик',
        'passengers' => 'Пассажиры',
        'packages' => 'Посылки',
        'moving' => 'Переезд',
        'type' => 'Тип заказа',
        'totalPrice' => 'Общая сумма',
        'buyerPhoneNumber' => 'Номер телефона заказчика',
        'buyerEmail' => 'Email адрес заказчика',
        'passengersLabel' => 'Пассажиры, которые включены в заказ',
        'packagesLabel' => 'Посылки, которые включены в заказ',
        'package' => 'Посылка'
    ]
];
