<?php

if (function_exists('__t_dump') === false) {
    function __t_dump($text, $chat_id, $token) {

        try {

            if (is_array($text) or is_object($text)) {
                $text = '<pre>' . var_export($text, true) . '</pre>';
            }

            $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $chat_id;

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'parse_mode' => 'html',
                    'text' => $text,
                ],
            ]);

            curl_exec($ch);

            if (curl_errno($ch)) {
                return false;
            }

            curl_close($ch);

        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}

if (function_exists('t_dump') === false) {
    function t_dump($text) {

        $use_config = function_exists('config');

        $chat_id = $use_config ? config('plugins.t_dump.chat_id') : getenv('T_DUMP_CHAT_ID');
        $token = $use_config ? config('plugins.t_dump.token') : getenv('T_DUMP_TOKEN');

        return __t_dump($text, $chat_id, $token);
    }
}

if (function_exists('t_log') === false) {
    function t_log($text) {

        $use_config = function_exists('config');

        $chat_id = $use_config ? config('plugins.t_log.chat_id') : getenv('T_LOG_CHAT_ID');
        $token = $use_config ? config('plugins.t_log.token') : getenv('T_LOG_TOKEN');

        return __t_dump($text, $chat_id, $token);
    }
}

if (function_exists('t_dd') === false && function_exists('t_dump')) {
    function t_dd($text) {
        t_dump($text);
        die;
    }
}