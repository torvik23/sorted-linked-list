<?php

/**
 * Copyright © Viktor Tokar. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Torvik23\SortedLinkedList;

use Torvik23\SortedLinkedList\Type\IntegerLinkedList;
use Torvik23\SortedLinkedList\Type\StringLinkedList;

final class SortedLinkedListFactory
{
    /**
     * Create a sorted linked list for integer values.
     *
     * @param bool $ascending Whether the list should be sorted in ascending order.
     * @param bool $allowDuplicates Whether the list should allow duplicate values.
     * @param callable|null $comparator An optional custom comparator function.
     *
     * @return SortedLinkedListInterface<int> A sorted linked list for integer values.
     */
    public static function integerList(
        bool $ascending = true,
        bool $allowDuplicates = true,
        ?callable $comparator = null,
    ): SortedLinkedListInterface {
        return new IntegerLinkedList($ascending, $allowDuplicates, $comparator);
    }

    /**
     * Create a sorted linked list for string values.
     *
     * @param bool $ascending Whether the list should be sorted in ascending order.
     * @param bool $allowDuplicates Whether the list should allow duplicate values.
     * @param callable|null $comparator An optional custom comparator function.
     *
     * @return SortedLinkedListInterface<string> A sorted linked list for string values.
     */
    public static function stringList(
        bool $ascending = true,
        bool $allowDuplicates = true,
        ?callable $comparator = null,
    ): SortedLinkedListInterface {
        return new StringLinkedList($ascending, $allowDuplicates, $comparator);
    }
}
