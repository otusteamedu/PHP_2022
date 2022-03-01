<?php

namespace KonstantinDmitrienko\App;

/**
 * Class for showing/return phrases
 */
class Phrases
{
    /**
     * @var array|string[]
     */
    protected static array $phrases = [
        'enter_message'    => 'Enter your message: ',
        'server_response'  => "Server response: {text}\n\n",
        'waiting_messages' => "Waiting for incoming messages...\n\n",
        'received_message' => "Received message: \"{message}\"\n",
        'received_bytes'   => "Received {bytes} bytes",
    ];

    /**
     * @param string $key
     * @param array  $replacements
     *
     * @return void
     */
    public static function show(string $key, array $replacements = []): void
    {
        self::prepare('show', $key, $replacements);
    }

    /**
     * @param string $key
     * @param array  $replacements
     *
     * @return string
     */
    public static function get(string $key, array $replacements = []): string
    {
        return self::prepare('get', $key, $replacements);
    }

    /**
     * @param string $action
     * @param string $key
     * @param array  $replacements
     *
     * @return mixed|string|void
     */
    protected static function prepare(string $action, string $key, array $replacements = [])
    {
        if (!($phrase = self::$phrases[$key])) {
            throw new \InvalidArgumentException("Error: Missing phrase with key {$key}");
        }

        if ($replacements) {
            $phrase = strtr($phrase, $replacements);
        }

        switch ($action) {
            case 'show':
                echo $phrase;
                break;
            case 'get':
                return $phrase;
        }
    }
}
