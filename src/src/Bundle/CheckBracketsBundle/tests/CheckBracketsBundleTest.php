<?php

declare(strict_types=1);

namespace Bundle\CheckBracketsBundle\Test;

use Bundle\CheckBracketsBundle\CheckBracketsBundle;
use PHPUnit\Framework\TestCase;

class CheckBracketsBundleTest extends TestCase
{
    public function testFilter(): void
    {
        $this->assertEquals(
            '()(',
            CheckBracketsBundle::filter('^*&()kd(')
        );

        $this->assertEquals(
            '',
            CheckBracketsBundle::filter('^*&kd3343')
        );

        $this->assertEquals(
            '()()()()',
            CheckBracketsBundle::filter('(fsafa$$)(4)324(Ff)(f)')
        );

        $this->assertEquals(
            '()(())(((()))())',
            CheckBracketsBundle::filter('(fsafa$$)((4))(((324(Ff)))(f))')
        );
    }

    public function testAreBracketsCorrect(): void
    {
        $this->assertEquals(
            false,
            CheckBracketsBundle::areBracketsCorrect('^*&()kd(')
        );

        $this->assertEquals(
            true,
            CheckBracketsBundle::areBracketsCorrect('^*&kd3343')
        );

        $this->assertEquals(
            true,
            CheckBracketsBundle::areBracketsCorrect('(fsafa$$)(4)324(Ff)(f)')
        );

        $this->assertEquals(
            true,
            CheckBracketsBundle::areBracketsCorrect('(fsafa$$)((4))(((324(Ff)))(f))')
        );

        $this->assertEquals(
            false,
            CheckBracketsBundle::areBracketsCorrect('(((((((((())')
        );

        $this->assertEquals(
            false,
            CheckBracketsBundle::areBracketsCorrect(')')
        );

        $this->assertEquals(
            false,
            CheckBracketsBundle::areBracketsCorrect(')(')
        );

        $this->assertEquals(
            true,
            CheckBracketsBundle::areBracketsCorrect('()')
        );
    }
}