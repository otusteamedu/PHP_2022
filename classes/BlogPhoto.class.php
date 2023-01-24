<?php

/**
 * Photos from blog
 */
class BlogPhoto
{
    private array $config;

    /**
     * @throws Exception
     */
    public function __construct(array $config)
    {
        if (isset($config['blog_photo'])) {
            $this->config = $config['blog_photo'];
        } else {
            throw new \Exception("Config section 'blog_photo' is not found");
        }
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Get random photo
     * @return string
     */
    public function getRandomPhoto(): string
    {
        if (!isset($this->config['photos_list_file']) || !is_file($this->config['photos_list_file'])) {
            throw new \Exception("Error: photos file not found");
        }

        $f_contents = file($this->config['photos_list_file']);
        $line = $f_contents[rand(0, count($f_contents) - 1)];

        return $line;
    }

    /**
     * Save photo locally to read it properly
     *(cannot read from remote https:// site, incl my blog)
     */
    public function savePhoto(string $url): string|false
    {

        $url = trim($url);

        $save = file_get_contents($url);
        if (!$save) {
            return false;
        }

        $fo = fopen($this->config['photo_file'], "w");
        if ($fo) {
            fwrite($fo, $save);
            fclose($fo);
        } else {
            return false;
        }

        // example: https://develgu.ru/bots/mishaikon_bot/v1/random_photo.jpg
        $path_parts = pathinfo($_SERVER['REQUEST_URI']);
        $ret = 'https://' . $_SERVER['HTTP_HOST'] . $path_parts['dirname'] . '/' . $this->config['photo_file'];

        return $ret;
    }
}
