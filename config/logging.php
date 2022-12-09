<?php

use Monolog\Handler\StreamHandler;

$channels = ['single'];

if(env('APP_ENV') !== 'testing' && env('APP_ENV') !== 'local') {
    $channels[] = 'graylog';
}

if(env('APP_ENV') === 'production') {
    $channels[] = 'mm';
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => $channels,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL', ''),
            'username' => config('app.url') . ' ' . config('app.env') . ' ' . config('app.name') . ' ERROR',
            'emoji' => ':boom:',
            'level' => 'error',
            'channel' => env('LOG_SLACK_CHANNEL', '')
        ],

        'mm' => [
            'driver' => 'slack',
            'url' => env('LOG_MM_WEBHOOK_URL', ''),
            'username' => config('app.url') . ' ' . config('app.env') . ' ' . config('app.name') . ' ERROR',
            'emoji' => ':boom:',
            'level' => 'error',
            'channel' => env('LOG_MM_CHANNEL', '')
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        'ones-errors' => [
            'driver' => 'single',
            'path' => storage_path('logs/ones_errors.log'),
            'level' => 'debug',
        ],

        'graylog' => [
            'driver' => 'custom',

            'via' => \Hedii\LaravelGelfLogger\GelfLoggerFactory::class,

            'processors' => [
                \Hedii\LaravelGelfLogger\Processors\NullStringProcessor::class,
                \Hedii\LaravelGelfLogger\Processors\RenameIdFieldProcessor::class,
                // another processor...
            ],

            'level' => 'debug',

            // This optional option determines the channel name sent with the
            // message in the 'facility' field. Default is equal to app.env
            // configuration value
            'name' => env('APP_ENV'),

            // This optional option determines the system name sent with the
            // message in the 'source' field. When forgotten or set to null,
            // the current hostname is used.
            'system_name' => env('APP_NAME'),

            // This optional option determines if you want the UDP, TCP or HTTP
            // transport for the gelf log messages. Default is UDP
            'transport' => env('LOG_GRAYLOG_TRANSPORT', 'udp'),

            'host' => env('LOG_GRAYLOG_HOST', '127.0.0.1'),
            'port' => env('LOG_GRAYLOG_PORT', 12201),
            'path' => env('LOG_GRAYLOG_PATH', '/gelf'),
            'ssl' => false,

            // This optional option determines the maximum length per message
            // field. When forgotten or set to null, the default value of
            // \Monolog\Formatter\GelfMessageFormatter::DEFAULT_MAX_LENGTH is
            // used (currently this value is 32766)
            'max_length' => null,

            // This optional option determines the prefix for 'context' fields
            // from the Monolog record. Default is null (no context prefix)
            'context_prefix' => 'ctx_',

            // This optional option determines the prefix for 'extra' fields
            // from the Monolog record. Default is null (no extra prefix)
            'extra_prefix' => null,

            // This optional option determines whether errors thrown during
            // logging should be ignored or not. Default is true.
            'ignore_error' => true,

            'extra' => [],

        ],
    ],

];
