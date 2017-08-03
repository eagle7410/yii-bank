<?php
use \kartik\datecontrol\Module;

return [
    'datecontrol' =>  [
        'class' => Module::class,
        // format settings for displaying each date attribute (ICU format example)
        'displaySettings' => [
            Module::FORMAT_DATE => 'dd-MM-yyyy',
            Module::FORMAT_TIME => 'hh:mm:ss a',
            Module::FORMAT_DATETIME => 'dd-MM-yyyy hh:mm:ss a',
        ],

        // format settings for saving each date attribute (PHP format example)
        'saveSettings' => [
            Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
            Module::FORMAT_TIME => 'php:H:i:s',
            Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
        ],
        'widgetSettings' => [
            Module::FORMAT_DATE => [
                'class' => 'yii\jui\DatePicker', // example
                'options' => [
                    'dateFormat' => 'php:d-M-Y',
                    'options' => ['class'=>'form-control'],
                ]
            ]
        ]
    ],
];
