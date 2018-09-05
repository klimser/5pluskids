<?php
return [
    'viewIndex' => [
        'type' => 2,
        'description' => 'View the main page',
    ],
    'managePages' => [
        'type' => 2,
        'description' => 'Manage pages',
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'content',
            'manageEmployees',

        ],
    ],
    'content' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'managePages',
            'manageMenu',
            'manageWidgetHtml',
            'viewIndex',
            'editOwnProfile',
            'manageUsers',
            'editUser',
            'manageTeachers',
            'manageEvents',
            'manageSubjectCategories',
            'manageSubjects',
            'viewSchedule',
            'manageGroups',
            'moneyManagement',
            'manageFeedbacks',
            'manageOrders',
            'manageReviews',
        ],
    ],
    'manageUsers' => [
        'type' => 2,
        'description' => 'Manage users',
    ],
    'manageEmployees' => [
        'type' => 2,
        'description' => 'Manage employees',
    ],
    'manageTeachers' => [
        'type' => 2,
        'description' => 'Manage teachers',
    ],
    'manageEvents' => [
        'type' => 2,
        'description' => 'Manage events',
    ],
    'editOwnProfile' => [
        'type' => 2,
        'ruleName' => 'isOwnProfile',
        'children' => [
            'editUser',
        ],
    ],
    'editUser' => [
        'type' => 2,
        'description' => 'Edit user profile',
    ],
    'manageBanner' => [
        'type' => 2,
        'description' => 'Manage banner contents',
    ],
    'manageFeedbacks' => [
        'type' => 2,
        'description' => 'Manage feedbacks',
    ],
    'manageMenu' => [
        'type' => 2,
        'description' => 'Manage menus',
    ],
    'manageOrders' => [
        'type' => 2,
        'description' => 'Manage orders',
    ],
    'manageReviews' => [
        'type' => 2,
        'description' => 'Manage reviews',
    ],
    'manageSubjectCategories' => [
        'type' => 2,
        'description' => 'Manage subject categories',
    ],
    'manageSubjects' => [
        'type' => 2,
        'description' => 'Manage subjects',
    ],
    'manageSubjectPages' => [
        'type' => 2,
        'description' => 'Manage subject pages',
    ],
    'viewMySchedule' => [
        'type' => 2,
        'description' => 'View my schedule',
        'ruleName' => 'canViewSchedule',
        'children' => [
            'viewSchedule',
        ],
    ],
    'viewSchedule' => [
        'type' => 2,
        'description' => 'View schedule',
    ],
    'manageGroups' => [
        'type' => 2,
        'description' => 'Manage pupil groups',
    ],
    'manageHighSchools' => [
        'type' => 2,
        'description' => 'Manage high schools',
    ],
    'manageQuiz' => [
        'type' => 2,
        'description' => 'Manage quizes',
    ],
    'moneyManagement' => [
        'type' => 2,
        'description' => 'Manage money',
    ],
    'manageWidgetHtml' => [
        'type' => 2,
        'description' => 'Manage blocks',
    ],
];
