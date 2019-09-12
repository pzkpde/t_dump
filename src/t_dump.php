<?php

if (function_exists('t_dump') === false) {
    function t_dump($text) {

        $use_config = function_exists('config');

        $display_errors = $use_config ? config('plugins.t_dump.display_errors') : getenv('T_DUMP_DISPLAY_ERRORS');

        try {

            $chat_id = $use_config ? config('plugins.t_dump.chat_id') : getenv('T_DUMP_CHAT_ID');
            $token = $use_config ? config('plugins.t_dump.token') : getenv('T_DUMP_TOKEN');

            if (strlen($chat_id) > 0 === false) {
                if ($display_errors) {
                    throw new \Exception('Chat ID not specified');
                }
                return false;
            }

            if (strlen($token) > 0 === false) {
                if ($display_errors) {
                    throw new \Exception('Token not specified');
                }
                return false;
            }

            if (is_array($text) or is_object($text)) {
                $text = '<pre>' . var_export($text, true) . '</pre>';
            }

            $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=html';

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'text' => $text,
                ],
            ]);

            curl_exec($ch);

            if (curl_errno($ch)) {
                if ($display_errors) {
                    throw new \Exception(curl_error($ch));
                }
                return false;
            }

            curl_close($ch);

        } catch (\Exception $e) {
            if ($display_errors) {
                throw new \Exception($e->getMessage(), $e->getCode());
            }
            return false;
        }

        return true;
    }
}

if (function_exists('t_dd') === false && function_exists('t_dump')) {
    function t_dd($text) {
        t_dump($text);
        die;
    }
}