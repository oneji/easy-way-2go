<?php

return [

    'home' => [
        'label' => 'Home'
    ],
    'drivingExperience' => [
        'label' => 'Driving experience',
        'actionsLabel' => 'Actions',
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
        ]
    ]
];
