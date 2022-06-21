<?php

namespace Otus\Tests\Helpers;

use Otus\App\Model\Comment;
use Otus\App\Model\Post;

class Fake
{
    public static function comment($message = null, int $postId = 1): Comment
    {
        $message = empty($message) ? 'test_title-' . rand(1, 1000) ** 2 : $message;
        $comment = new Comment();
        $comment->setMessage($message);
        $comment->setPostId($postId);
        return $comment;
    }

    public static function post($title = null): Post
    {
        $title = empty($title) ? 'test_title-' . rand(1, 1000) ** 2 : $title;
        $comment = new Post();
        $comment->setTitle($title);
        return $comment;
    }
}