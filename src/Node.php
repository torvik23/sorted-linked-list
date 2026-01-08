<?php

/**
 * Copyright © Viktor Tokar. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Torvik23\SortedLinkedList;

/**
 * Class represents a node in a linked list structure.
 *
 * @template T The type of the value stored in the node.
 */
final class Node
{
    /**
     * Constructor.
     *
     * @param T $value The value to be stored in the node.
     * @param Node<T>|null $next Reference to the next node in the list, or null if this is the last node.
     */
    public function __construct(
        public readonly mixed $value,
        public ?self $next = null,
    ) {
    }
}
