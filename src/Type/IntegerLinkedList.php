<?php

/**
 * Copyright © Viktor Tokar. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Torvik23\SortedLinkedList\Type;

use Torvik23\SortedLinkedList\Exception\TypeMismatchException;
use Torvik23\SortedLinkedList\SortedLinkedList;
use Torvik23\SortedLinkedList\SortedLinkedListInterface;

use function is_int;

/**
 * A sorted linked list for integer values.
 *
 * @extends SortedLinkedList<int>
 */
final class IntegerLinkedList extends SortedLinkedList
{
    /**
     * @inheritDoc
     */
    protected function assertValueType(mixed $value): void
    {
        if (!is_int($value)) {
            throw new TypeMismatchException('The linked list accepts only integer values.');
        }
    }

    /**
     * @inheritDoc
     */
    protected function compare(mixed $a, mixed $b): int
    {
        $result = is_callable($this->comparator)
            ? ($this->comparator)($a, $b)
            : $a <=> $b;

        return $this->ascending ? $result : -$result;
    }

    /**
     * @inheritDoc
     */
    public function fromArray(array $values): SortedLinkedListInterface
    {
        $list = new self($this->ascending, $this->allowDuplicates, $this->comparator);
        $list->bulkAdd($values);

        return $list;
    }
}
