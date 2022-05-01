<?php


namespace App\Dtos;


class VideoDto
{
    public string $id;

    public string $videoChanel;

    public string $videoTitle;

    public string $description = '';

    public int $videoSeconds;

    public int $like = 0;

    public int $dislike = 0;
}
