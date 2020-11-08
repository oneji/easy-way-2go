<?php

return [

    'home' => [
        'label' => 'Home'
    ],

    'drivingExperience' => [
        'label' => 'Driving experience',
        'actionsLabel' => 'Actions',
        'successAddedAlert' => 'Item successfully added.',
        'successEditedAlert' => 'Item successfully added.',
        'emptySet' => 'For now, we could not find any items.',
        'addModalLabel' => 'Add new',
        'editModalLabel' => 'Edit'
    ],

    'languages' => [
        'label' => 'Languages',
        'codeLabel' => 'Code',
        'actionsLabel' => 'Actions',
        'successAddedAlert' => 'Item successfully added.',
        'successEditedAlert' => 'Item successfully added.',
        'emptySet' => 'For now, we could not find any items.',
        'addModalLabel' => 'Add new',
        'editModalLabel' => 'Edit'
    ],
    
    'countries' => [
        'label' => 'Countries',
        'codeLabel' => 'Code',
        'actionsLabel' => 'Actions',
        'successAddedAlert' => 'Item successfully added.',
        'successEditedAlert' => 'Item successfully added.',
        'emptySet' => 'For now, we could not find any items.',
        'addModalLabel' => 'Add new',
        'editModalLabel' => 'Edit'
    ],

    'carBrands' => [
        'label' => 'Car brands',
        'brandsLabel' => 'Brand|Brands',
        'actionsLabel' => 'Actions',
        'emptySet' => 'For now, we could not find any items.',
        'addModalLabel' => 'Add new',
        'editModalLabel' => 'Edit',
    ],

    'carModels' => [
        'label' => 'Car models',
        'modelsLabel' => 'Models',
        'actionsLabel' => 'Actions',
        'emptySet' => 'For now, we could not find any items.',
        'addModalLabel' => 'Add new',
        'editModalLabel' => 'Edit',
    ],

    'brigadirs' => [
        'label' => 'Formen',
        'datatable' => [
            'fullName' => 'Full name',
            'phoneNumber' => 'Phone number',
            'company' => 'Company',
            'inn' => 'INN or ID',
            'actions' => 'Actions'
        ],
        'emptySet' => 'For now, we could not find any items.',
    ],

    'createBrigadir' => [
        'label' => 'Add new foreman',
        'addForm' => [
            'label' => 'Foreman information',
            'labels' => [
                'mr' => 'Mister',
                'ms' => 'Missis',
                'notSure' => 'Not sure',
                'firstName' => 'First name',
                'lastName' => 'Last name',
                'email' => 'Email',
                'photo' => 'Photo',
                'password' => 'Password',
                'confirmPassword' => 'Confirm password',
                'birthday' => 'Birthday',
                'nationality' => 'Nationality',
                'phone' => 'Phone number',
                'company' => 'Company',
                'inn' => 'INN or ID'
            ],
            'placeholders' => [
                'firstName' => 'Enter first name',
                'lastName' => 'Enter last name',
                'email' => 'Enter email',
                'photo' => 'Choose photo',
                'password' => 'Enter password',
                'confirmPassword' => 'Confirm password',
                'birthday' => 'Choose birthday',
                'nationality' => 'Choose country',
                'phone' => 'Enter phone number',
                'company' => 'Enter company',
                'inn' => 'Enter INN or ID'
            ]
        ]
    ],
    
    'editBrigadir' => [
        'label' => 'Edit foreman',
        'addForm' => [
            'label' => 'Foreman information',
            'labels' => [
                'mr' => 'Mister',
                'ms' => 'Missis',
                'notSure' => 'Not sure',
                'firstName' => 'First name',
                'lastName' => 'Last name',
                'email' => 'Email',
                'photo' => 'Photo',
                'password' => 'Password',
                'confirmPassword' => 'Confirm password',
                'birthday' => 'Birthday',
                'nationality' => 'Nationality',
                'phone' => 'Phone number',
                'company' => 'Company',
                'inn' => 'INN or ID'
            ],
            'placeholders' => [
                'firstName' => 'Enter first name',
                'lastName' => 'Enter last name',
                'email' => 'Enter email',
                'photo' => 'Choose photo',
                'password' => 'Enter password',
                'confirmPassword' => 'Confirm password',
                'birthday' => 'Choose birthday',
                'nationality' => 'Choose country',
                'phone' => 'Enter phone number',
                'company' => 'Enter company',
                'inn' => 'Enter INN or ID'
            ]
        ]
    ],

    'drivers' => [
        'label' => 'Drivers',
        'driverInfoLabel' => 'Driver information',
        'uploadedDocumentsLabel' => 'Uploaded documents',
        'noDocumentsLabel' => 'For now, we could not find any items.',
        'documentsLabel' => 'Documents',
        'datatable' => [
            'fullName' => 'Full name',
            'phoneNumber' => 'Phone number',
            'country' => 'Country',
            'city' => 'City',
            'drivingExperience' => 'Driving experience',
            'actions' => 'Actions'
        ],
        'emptySet' => 'For now, we could not find any items.',
        'addForm' => [
            'labels' => [
                'mr' => 'Mister',
                'ms' => 'Missis',
                'notSure' => 'Not sure',
                'firstName' => 'First name',
                'lastName' => 'Last name',
                'email' => 'Email',
                'photo' => 'Photo',
                'password' => 'Password',
                'confirmPassword' => 'Confirm password',
                'birthday' => 'Birthday',
                'nationality' => 'Nationality',
                'phone' => 'Phone number',
                'country' => 'Country',
                'city' => 'City, address, postal code',
                // Documents side
                'drivingExperience' => 'Driving experience',
                'dlIssuePlace' => 'Where was your driving licence issued?',
                'dlIssuedAt' => 'Issued at',
                'dlExpiresAt' => 'Expires at',
                'comment' => 'Comment',
                'conviction' => 'Conviction',
                'keptDrunk' => 'Were you kept drunk?',
                'dtp' => 'Have you had an accident within 5 years?',
                'grades' => 'Grades',
                'gradesExpireAt' => 'Grades expire at',
                'dlPhoto' => 'Photo of driver\'s license (2 sides)',
                'passportPhoto' => 'Passport or ID (2 sides)'
            ],
            'placeholders' => [
                'firstName' => 'Enter first name',
                'lastName' => 'Enter last name',
                'email' => 'Enter email',
                'photo' => 'Choose photo',
                'password' => 'Enter password',
                'confirmPassword' => 'Confirm password',
                'birthday' => 'Choose date',
                'nationality' => 'Choose country',
                'phone' => 'Enter phone number',
                'country' => 'Choose country',
                'city' => 'City, address, postal code',
                // Documents side
                'drivingExperience' => 'Driving experience',
                'dlIssuePlace' => 'Choose country',
                'dlIssuedAt' => 'Choose date',
                'dlExpiresAt' => 'Choose date',
                'comment' => 'Not set',
                'gradesExpireAt' => 'Choose date',
                'dlPhoto' => 'Choose file',
                'passportPhoto' => 'Choose file'
            ]
        ]
    ],

    'createDriver' => [
        'label' => 'Add new driver'
    ],

    'editDriver' => [
        'label' => 'Edit driver'
    ],

    'clients' => [
        'label' => 'Clients',
        'clientInfoLabel' => 'Client information',
        'datatable' => [
            'fullName' => 'Full name',
            'phoneNumber' => 'Phone number',
            'idCard' => 'ID card number',
            'passport' => 'Passport number',
            'actions' => 'Actions'
        ],
        'emptySet' => 'For now, we could not find any items.',
        'addForm' => [
            'labels' => [
                'mr' => 'Mister',
                'ms' => 'Missis',
                'notSure' => 'Not sure',
                'firstName' => 'First name',
                'lastName' => 'Last name',
                'email' => 'Email',
                'photo' => 'Photo',
                'password' => 'Password',
                'confirmPassword' => 'Confirm password',
                'birthday' => 'Birthday',
                'nationality' => 'Nationality',
                'phone' => 'Phone number',
                'idCard' => 'ID card number',
                'idCardExpiresAt' => 'ID card expires at',
                'passport' => 'Passport number',
                'passportExpiresAt' => 'Passport expires at'
            ],
            'placeholders' => [
                'firstName' => 'Enter first name',
                'lastName' => 'Enter last name',
                'email' => 'Enter email',
                'photo' => 'Choose photo',
                'password' => 'Enter password',
                'confirmPassword' => 'Confirm password',
                'birthday' => 'Choose date',
                'nationality' => 'Choose country',
                'phone' => 'Enter phone number',
                'idCard' => 'Enter ID card number',
                'idCardExpiresAt' => 'Choose date',
                'passport' => 'Enter passport number',
                'passportExpiresAt' => 'Choose date'
            ]
        ]
    ],

    'createClient' => [
        'label' => 'Add new client'
    ],

    'editClient' => [
        'label' => 'Edit client'
    ],
    
    'transport' => [
        'label' => 'Transport',
        'bindDriverBtn' => 'Bind driver',
        'emptySet' => 'For now, we could not find any items.',
        'noDriversBound' => 'No drivers bound',
        'bindDriverModal' => [
            'label' => 'Bind driver',
            'transportLabel' => 'Transport',
            'chooseTransportLabel' => 'Choose transport',
            'driverLabel' => 'Driver',
            'chooserDriverLabel' => 'Choose driver',
            'bindDriverBtn' => 'Bind',
            'firstAddTransportLabel' => 'First add transport',
            'firstAddDriverLabel' => 'First add driver'
        ],
        'form' => [
            'addFormLabel' => 'Add transport',
            'editFormLabel' => 'Edit transport',
            'documentsLabel' => 'Documents',
            'uploadedDocumentsLabel' => 'Uploaded documents',
            'noDocumentsLabel' => 'For now, we could not find any items',
            'labels' => [
                'transportRegistered' => 'Is transport registered?',
                'company' => 'Company',
                'individual' => 'Individual',
                'country' => 'Country of registration',
                'city' => 'City, address, postal code of registration',
                'carNumber' => 'Car number',
                'brand' => 'Brand',
                'model' => 'Model',
                'year' => 'Year',
                'inspectionFrom' => 'Inspection from',
                'inspectionTo' => 'Inspection to',
                'insuranceFrom' => 'Insurance from',
                'insuranceTo' => 'Insurance to',
                'hasCmr' => 'Has CMR?',
                'yes' => 'Yes',
                'no' => 'No',
                'passengerSeats' => 'Number of passenger seats',
                'cuboMetres' => 'How many cubic meters can you carry?',
                'kilos' => 'How many kilograms can you carry?',
                'okForMove' => 'Is the transport suitable for moving?',
                'canPullTrailer' => 'Can you pull a trailer?',
                'hasTrailer' => 'Has trailer?',
                'palletTransportation' => 'Pallet transportation',
                'conditioner' => 'Has conditioner?',
                'wifi' => 'Has Wi-Fi?',
                'tvVideo' => 'Has Tv-Video?',
                'disabledPeopleSeats' => 'Has disabled people seats?',
                // Documents side
                'passportPhoto' => 'Car passport (2 sides)',
                'tehOsmotrPhoto' => 'Inspection (2 sides)',
                'insurancePhoto' => 'Insurance (2 sides)',
                'peopleLicensePhoto' => 'Personnel transport license (2 sides)',
                'carPhoto' => 'Car photos',
                'trailerPhoto' => 'Trailer photos'
            ],
            'placeholders' => [
                'country' => 'Choose country',
                'city' => 'City, address, postal code',
                'carNumber' => 'Not set',
                'inspectionFrom' => 'Inspection from',
                'inspectionTo' => 'Inspection to',
                'insuranceFrom' => 'Insurance from',
                'insuranceTo' => 'Insurance to',
                'passengerSeats' => 'Not set',
                'cuboMetres' => 'Not set',
                'kilos' => 'Not set',
                // Documents side
                'passportPhoto' => 'Choose file',
                'tehOsmotrPhoto' => 'Choose file',
                'insurancePhoto' => 'Choose file)',
                'peopleLicensePhoto' => 'Choose file',
                'carPhoto' => 'Choose file',
                'trailerPhoto' => 'Choose file'
            ]
        ]
    ],

    'routes' => [
        'label' => 'Routes',
        'driverInfoLabel' => 'All routes',
        'infoModalLabel' => 'Route',
        'datatable' => [
            'from' => 'From',
            'to' => 'To',
            'driver' => 'Driver',
            'status' => 'Status',
            'actions' => 'Actions'
        ],
        'emptySet' => 'For now, we could not find any items.',
    ],
    
    'bas' => [
        'label' => 'Bussiness Account Requests',
        'driverInfoLabel' => 'All requests',
        'datatable' => [
            'request' => 'Request',
            'type' => 'Type',
            'status' => 'Status',
            'date' => 'Date',
            'actions' => 'Actions',
            'statusApproved' => 'Approved',
            'statusPending' => 'Pending',
            'statusDeclined' => 'Declined'
        ],
        'firmOwner' => [
            'label' => 'Firm owner',
            'company_name' => 'Company name',
            'name' => 'Full name',
            'email' => 'Email address',
            'phoneNumber' => 'Phone number',
            'inn' => 'Inn or ID',
            'nationality' => 'Nationality',
            'country' => 'Place of residence'
        ],
        'mainDriver' => [
            'label' => 'Main driver',
            'name' => 'Full name',
            'birthday' => 'Birthday',
            'nationality' => 'Nationality',
            'phoneNumber' => 'Phone number',
            'email' => 'Email address',
            'country' => 'Place of residence',
            'dlIssuePlace' => 'Where was your driving licence issued?',
            'dlExpiresAt' => 'Driving license expires at',
            'drivingExperience' => 'Driving experience',
            'conviction' => 'Conviction',
            'comment' => 'Comment',
            'wasKeptDrunk' => 'Was kept drunk?',
            'grades' => 'Grades',
            'gradesExpireAt' => 'Grades expire at',
            'dtp' => 'Have you had an accident within 5 years?'
        ],
        'emptySet' => 'For now, we could not find any items.',
    ],
];
