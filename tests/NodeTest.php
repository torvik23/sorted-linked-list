<?php

/**
 * Copyright © Viktor Tokar. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Torvik23\SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use Torvik23\SortedLinkedList\Node;

class NodeTest extends TestCase
{
    public function testNodeInitializesWithValue(): void
    {
        $node = new Node(7);
        $this->assertSame(7, $node->value);
        $this->assertNull($node->next);
    }

    public function testNodeInitializesWithValueAndNext(): void
    {
        $nextNode = new Node(10);
        $node = new Node(10, $nextNode);

        $this->assertSame(10, $node->value);
        $this->assertSame($nextNode, $node->next);
    }
}
