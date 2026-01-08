<?php

/**
 * Copyright © Viktor Tokar. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Torvik23\SortedLinkedList;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Interface for a sorted type-specific linked lists.
 *
 * @template T The type of the elements in the linked list.
 * @extends Iterator<int, T>
 * @extends ArrayAccess<int, T>
 */
interface SortedLinkedListInterface extends Iterator, Countable, ArrayAccess
{
    /**
     * Adds a value to the linked list in sorted order.
     *
     * @param T $value The value to add.
     *
     * @return void
     */
    public function add(mixed $value): void;

    /**
     * Adds multiple values to the linked list in sorted order.
     *
     * @param T[] $values An array of values to add.
     *
     * @return void
     */
    public function bulkAdd(array $values): void;

    /**
     * Removes the first occurrence of a given value from the linked list.
     *
     * @param T $value The value to remove.
     *
     * @return bool True if the value was found and removed, false otherwise.
     */
    public function remove(mixed $value): bool;

    /**
     * Clears the linked list.
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Checks if the linked list contains a given value.
     *
     * @param T $value The value to check for.
     *
     * @return bool True if the value is found, otherwise false.
     */
    public function contains(mixed $value): bool;

    /**
     * Converts the linked list to an array.
     *
     * @return T[] An array containing all elements of the linked list in order.
     */
    public function toArray(): array;

    /**
     * Creates a linked list from an array of values.
     *
     * @param T[] $values An array of values to populate the linked list.
     *
     * @return SortedLinkedListInterface<T>
     */
    public function fromArray(array $values): SortedLinkedListInterface;

    /**
     * Retrieves the first element of the linked list.
     *
     * @return T|null The first element.
     */
    public function first(): mixed;

    /**
     * Retrieves the last element of the linked list.
     *
     * @return T|null The last element.
     */
    public function last(): mixed;

    /**
     * Serializes the linked list.
     *
     * @return string|null The serialized representation of the linked list.
     */
    public function serialize(): ?string;

    /**
     * Unserializes the linked list from a serialized string.
     *
     * @param string $data The serialized representation of the linked list.
     *
     * @return void
     */
    public function unserialize(string $data): void;
}
