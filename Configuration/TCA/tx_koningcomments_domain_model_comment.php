<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

return [
    'ctrl' => [
        'title' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment',
        'label' => 'date',
        'hideAtCopy' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'editlock' => 'editlock',
        'dividers2tabs' => true,
        'hideTable' => false,
        'delete' => 'deleted',
        'searchFields' => 'uid, body',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:koning_comments/Resources/Public/Icons/tx_koningcomments_domain_model_comment.png',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, date, url, body, user, nonuser_username, nonuser_email, nonuser_www, reply_to, replies'
    ],
    'types' => [
        0 => [
            'showitem' => 'hidden, date, url, body, user, nonuser_username, nonuser_email, nonuser_www, reply_to, replies'
        ]
    ],
    'palettes' => [],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ],
        'date' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment.date',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime',
            ]
        ],
        'url' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment.url',
            'config' => [
                'type' => 'input',
            ]
        ],
        'body' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment.body',
            'config' => [
                'type' => 'text',
            ]
        ],
        'user' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment.user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
                'size' => 1
            ]
        ],
        'nonuser_username' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment.nonuser_username',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ]
        ],
        'nonuser_email' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment.nonuser_email',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,email',
            ]
        ],
        'nonuser_www' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment.nonuser_www',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ]
        ],
        'reply_to' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment.reply_to',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_koningcomments_domain_model_comment',
                'minitems' => 0,
                'maxitems' => 1,
                'size' => 1
            ]
        ],
        'replies' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:koning_comments/Resources/Private/Language/locallang_be.xlf:tx_koningcomments_domain_model_comment.replies',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_koningcomments_domain_model_comment',
                'foreign_field' => 'reply_to',
                'foreign_sortby' => 'date',
                'maxitems' => '9999',
            ],
        ]
    ],
];
