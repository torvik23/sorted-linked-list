<?php

/**
 * Copyright © Viktor Tokar. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Torvik23\SortedLinkedList;

use Torvik23\SortedLinkedList\Exception\OutOfBoundsException;
use UnexpectedValueException;

use function is_array;
use function is_bool;

/**
 * Abstract base class for a sorted type-specific linked lists.
 *
 * @template T The type of the elements in the linked list.
 * @implements SortedLinkedListInterface<T>
 */
abstract class SortedLinkedList implements SortedLinkedListInterface
{
    /**
     * The head node of the linked list.
     *
     * @var Node<T>|null
     */
    protected ?Node $head = null;

    /**
     * The callable comparator.
     * Comparator signature:
     *  fn(mixed $a, mixed $b): int
     *
     * @var null|callable(T, T): int
     */
    protected $comparator;

    /**
     * Current node for iterator.
     *
     * @var Node<T>|null
     */
    private ?Node $currentNode = null;

    /**
     * Current position for the iterator.
     *
     * @var int
     */
    private int $position = 0;

    /**
     * The number of elements in the list.
     *
     * @var int
     */
    private int $count = 0;

    /**
     * Constructor.
     *
     * @param bool $ascending Whether the list is sorted in ascending order.
     * @param bool $allowDuplicates Whether to allow duplicate values.
     * @param null|callable(T, T): int $comparator Optional comparator function.
     */
    public function __construct(
        protected bool $ascending,
        protected bool $allowDuplicates,
        ?callable $comparator,
    ) {
        $this->comparator = $comparator;
    }

    /**
     * Validates that the given value is of the correct type.
     *
     * @param T $value
     *
     * @return void
     * @throws \InvalidArgumentException if the value is not of the correct type.
     */
    abstract protected function assertValueType(mixed $value): void;

    /**
     * Compare two values for sorting.
     *
     * @param T $a The first value to compare.
     * @param T $b The second value to compare.
     *
     * @return int Negative if $a < $b, positive if $a > $b, zero if equal
     */
    abstract protected function compare(mixed $a, mixed $b): int;

    /**
     * Returns the current element.
     *
     * @return T|null
     */
    public function current(): mixed
    {
        return $this->currentNode?->value;
    }

    /**
     * Moves forward to next element.
     *
     * @return void
     */
    public function next(): void
    {
        if ($this->currentNode !== null) {
            $this->currentNode = $this->currentNode->next;
            $this->position++;
        }
    }

    /**
     * Returns the key of the current element.
     *
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid.
     *
     * @return bool
     */
    public function valid(): bool
    {
        return $this->currentNode !== null;
    }

    /**
     * Rewinds the Iterator to the first element.
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->currentNode = $this->head;
        $this->position = 0;
    }

    /**
     * Returns number of elements.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * Checks whether an offset exists.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return is_int($offset) && $offset >= 0 && $offset < $this->count;
    }

    /**
     * Returns a value at specified offset.
     *
     * @return T
     */
    public function offsetGet(mixed $offset): mixed
    {
        if (!is_int($offset) || $offset < 0 || $offset >= $this->count) {
            throw new OutOfBoundsException(sprintf('Offset is out of bounds: %s given', $offset));
        }

        $current = $this->head;
        $index = 0;
        while ($current !== null) {
            if ($index === $offset) {
                return $current->value;
            }

            $current = $current->next;
            $index++;
        }

        throw new OutOfBoundsException(sprintf('Offset %s does not exist', $offset));
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->add($value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        if (!is_int($offset) || $offset < 0 || $offset >= $this->count) {
            throw new OutOfBoundsException(sprintf('Offset is out of bounds: %s given', $offset));
        }

        $current = $this->head;
        $index = 0;
        while ($current !== null) {
            if ($index === $offset) {
                $this->remove($current->value);
                return;
            }
            $current = $current->next;
            $index++;
        }
    }

    /**
     * @inheritDoc
     */
    public function serialize(): string
    {
        return \serialize([
            'ascending' => $this->ascending,
            'allowDuplicates' => $this->allowDuplicates,
            'values' => $this->toArray(),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(string $data): void
    {
        $payload = \unserialize($data, ['allowed_classes' => false]);
        if (!is_array($payload)) {
            throw new UnexpectedValueException('Invalid serialized configuration.');
        }
        $ascending = $payload['ascending'] ?? null;
        $allowDuplicates = $payload['allowDuplicates'] ?? null;
        $values = $payload['values'] ?? null;

        if (!is_bool($ascending) || !is_bool($allowDuplicates)) {
            throw new UnexpectedValueException('Invalid serialized configuration.');
        }
        if (!is_array($values)) {
            throw new UnexpectedValueException('Invalid serialized values.');
        }

        $this->ascending = $ascending;
        $this->allowDuplicates = $allowDuplicates;
        $this->clear();

        foreach ($values as $value) {
            $this->add($value);
        }
    }

    /**
     * @inheritDoc
     */
    public function add(mixed $value): void
    {
        $this->assertValueType($value);
        if (!$this->allowDuplicates && $this->contains($value)) {
            return;
        }

        $newNode = new Node($value);
        if ($this->head === null || $this->compare($value, $this->head->value) <= 0) {
            $newNode->next = $this->head;
            $this->head = $newNode;
            $this->count++;
            return;
        }

        $current = $this->head;
        while (
            $current->next !== null &&
            $this->compare($value, $current->next->value) >= 0
        ) {
            $current = $current->next;
        }

        $newNode->next = $current->next;
        $current->next = $newNode;
        $this->count++;
    }

    /**
     * @inheritDoc
     */
    public function bulkAdd(array $values): void
    {
        foreach ($values as $value) {
            $this->add($value);
        }
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $value): bool
    {
        $this->assertValueType($value);

        if ($this->head === null) {
            return false;
        }

        if ($this->compare($value, $this->head->value) === 0) {
            $this->head = $this->head->next;
            $this->count--;

            return true;
        }

        $current = $this->head;
        while ($current->next !== null) {
            if ($this->compare($value, $current->next->value) === 0) {
                $current->next = $current->next->next;
                $this->count--;

                return true;
            }
            $current = $current->next;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function clear(): void
    {
        $current = $this->head;
        while ($current !== null) {
            $next = $current->next;
            unset($current);
            $current = $next;
        }

        $this->head = null;
        $this->count = 0;
    }

    /**
     * @inheritDoc
     */
    public function contains(mixed $value): bool
    {
        $this->assertValueType($value);

        $current = $this->head;
        while ($current !== null) {
            if ($this->compare($value, $current->value) === 0) {
                return true;
            }
            $current = $current->next;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $out = [];
        $current = $this->head;
        while ($current !== null) {
            $out[] = $current->value;
            $current = $current->next;
        }

        return $out;
    }

    /**
     * @inheritDoc
     */
    public function first(): mixed
    {
        return $this->head?->value;
    }

    /**
     * @inheritDoc
     */
    public function last(): mixed
    {
        if ($this->head === null) {
            return null;
        }

        $current = $this->head;
        while ($current->next !== null) {
            $current = $current->next;
        }

        return $current->value;
    }
}
