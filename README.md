# t_dump
Dumping variables directly in Telegram

You need to specify some variables in the environment (in any way):

* `T_DUMP_CHAT_ID` - Your telegram chat ID with your bot
* `T_DUMP_TOKEN` - Your telegram bot token

* `T_LOG_CHAT_ID` - Another telegram chat ID with your bot
* `T_LOG_TOKEN` - Another telegram bot token

or in Laravel's config file ```app/plugins.php``` like:

```
return [
    't_dump' => [
        'chat_id' => env('T_DUMP_CHAT_ID', 'PUT_CHAT_ID_HERE'),
        'token' => env('T_DUMP_TOKEN', 'PUT_TOKEN_HERE'),
    ],
    't_log' => [
        'chat_id' => env('T_LOG_CHAT_ID', 'PUT_CHAT_ID_HERE'),
        'token' => env('T_LOG_TOKEN', 'PUT_TOKEN_HERE'),
    ],
];
```