<?php

namespace Otus\Tests\Unit;

use Otus\App\Model\Comment;
use Otus\Tests\AppTestCase;
use Otus\Tests\Helpers\Fake;
use Otus\App\Factory\CommentMapperFactory;

class CommentMapperTest extends AppTestCase
{
    public function test_can_get_comments()
    {
        $commentMapper = CommentMapperFactory::make();
        $count = 10;;
        for ($i = 0; $i < $count; $i++) {
            $comment = Fake::comment();
            $commentMapper->insert($comment);
        }
        $comments = $commentMapper->fetchAll();
        foreach ($comments->list() as $comment) {
            $this->assertTrue($comment instanceof Comment);
        }
        $this->assertEquals($comments->count(), $count);
    }

    public function test_can_create_comment()
    {
        $commentMapper = CommentMapperFactory::make();
        $title = 'test_title-' . rand(1, 1000) * rand(1, 1000);
        $comment = Fake::comment($title);
        $commentMapper->insert($comment);

        $stmt = $this->pdo->prepare("SELECT * FROM {$commentMapper->table} WHERE id=?");
        $stmt->execute([$comment->getId()]);
        $row = $stmt->fetch();
        $stmt->closeCursor();

        $this->assertEquals($row['message'], $title);
    }

    public function test_can_update_comment_message()
    {
        $commentMapper = CommentMapperFactory::make();
        $comment = Fake::comment();
        $commentMapper->insert($comment);

        $title = 'test_title-' . rand(1, 1000) ** 2;
        $comment->setMessage($title);
        $commentMapper->update($comment);

        $stmt = $this->pdo->prepare("SELECT * FROM {$commentMapper->table} WHERE id=?");
        $stmt->execute([$comment->getId()]);
        $row = $stmt->fetch();
        $stmt->closeCursor();

        $this->assertEquals($row['message'], $title);
    }

    public function test_identity_comment_objects()
    {
        $commentMapper = CommentMapperFactory::make();
        $preObj = Fake::comment();
        $commentMapper->insert($preObj);
        $currentObj = $commentMapper->findById($preObj->getId());

        $this->assertTrue($preObj ===  $currentObj);
    }
}