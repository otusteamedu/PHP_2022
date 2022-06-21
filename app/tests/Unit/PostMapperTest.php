<?php

namespace Otus\Tests\Unit;

use Otus\App\Factory\CommentMapperFactory;
use Otus\App\Model\Comment;
use Otus\App\Model\Post;
use Otus\Core\Database\Exception\DBSQLNotFoundException;
use Otus\Tests\AppTestCase;
use Otus\Tests\Helpers\Fake;
use Otus\App\Factory\PostMapperFactory;

class PostMapperTest extends AppTestCase
{
    public function test_can_get_posts()
    {
        $postMapper = PostMapperFactory::make();
        $count = 10;;
        for ($i = 0; $i < $count; $i++) {
            $post = Fake::post();
            $postMapper->insert($post);
        }
        $posts = $postMapper->fetchAll();
        foreach ($posts->list() as $post) {
            $this->assertTrue($post instanceof Post);
        }
        $this->assertEquals($posts->count(), $count);
    }

    public function test_can_create_post()
    {
        $postMapper = PostMapperFactory::make();
        $title = 'test_title-' . rand(1, 1000) * rand(1, 1000);
        $post = Fake::post($title);
        $postMapper->insert($post);

        $stmt = $this->pdo->prepare("SELECT * FROM {$postMapper->table} WHERE id=?");
        $stmt->execute([$post->getId()]);
        $row = $stmt->fetch();
        $stmt->closeCursor();

        $this->assertEquals($row['title'], $title);
    }

    public function test_can_update_post_title()
    {
        $postMapper = PostMapperFactory::make();
        $post = Fake::post();
        $postMapper->insert($post);

        $title = 'test_title-' . rand(1, 1000) ** 2;
        $post->setTitle($title);
        $postMapper->update($post);

        $stmt = $this->pdo->prepare("SELECT * FROM {$postMapper->table} WHERE id=?");
        $stmt->execute([$post->getId()]);
        $row = $stmt->fetch();
        $stmt->closeCursor();

        $this->assertEquals($row['title'], $title);
    }

    public function test_can_delete_post_by_id()
    {
        $postMapper = PostMapperFactory::make();
        $post = Fake::post();
        $postMapper->insert($post);

        $postMapper->deleteById($post->getId());

        $stmt = $this->pdo->prepare("SELECT * FROM {$postMapper->table} WHERE id=?");
        $stmt->execute([$post->getId()]);
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $this->assertFalse($row);
    }

    public function test_can_get_post_with_comments()
    {
        $postMapper = PostMapperFactory::make();
        $post = Fake::post();
        $postMapper->insert($post);

        $commentMapper = CommentMapperFactory::make();

        $comments = [
            Fake::comment('test_1', $post->getId()),
            Fake::comment('test_2', $post->getId()),
            Fake::comment('test_3', $post->getId()),
        ];
        array_map(fn($comment) => $commentMapper->insert($comment), $comments);

        $post = $postMapper->findById($post->getId());
        $postComments = $post->getComments();
        foreach ($postComments->list() as $comment) {
            $this->assertTrue($comment instanceof Comment);
        }
        $this->assertEquals($postComments->count(), count($comments));
    }

    public function test_identity_post_objects()
    {
        $postMapper = PostMapperFactory::make();
        $preObj = Fake::post();
        $postMapper->insert($preObj);
        $currentObj = $postMapper->findById($preObj->getId());
        $this->assertTrue($preObj === $currentObj);

        $postMapper->deleteById($currentObj->getId());
        try {
            $postMapper->findById($preObj->getId());
            $this->fail();
        } catch (DBSQLNotFoundException) {
            $this->assertTrue(true);
        } catch (\Throwable) {
            $this->fail();
        }
    }
}