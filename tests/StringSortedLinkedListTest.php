<?php

/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */

declare(strict_types=1);

namespace Torvik23\SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use Torvik23\SortedLinkedList\Exception\TypeMismatchException;
use Torvik23\SortedLinkedList\SortedLinkedListFactory;
use Torvik23\SortedLinkedList\SortedLinkedListInterface;

class StringSortedLinkedListTest extends TestCase
{
    /**
     * @var SortedLinkedListInterface<string>
     */
    private SortedLinkedListInterface $list;

    protected function setUp(): void
    {
        $this->list = SortedLinkedListFactory::stringList();
    }

    public function testEmptyListHasZeroElements(): void
    {
        $this->assertEquals(0, $this->list->count());
    }

    public function testClearEmptyList(): void
    {
        $this->list->bulkAdd(['apple', 'banana', 'lemon', 'mango']);
        $this->assertEquals(4, $this->list->count());
        $this->list->clear();
        $this->assertEquals(0, $this->list->count());
    }

    public function testAddString(): void
    {
        $this->list->add('kiwi');
        $this->assertEquals(1, $this->list->count());
        $this->assertTrue($this->list->contains('kiwi'));
    }

    public function testAddBulkStrings(): void
    {
        $this->list->bulkAdd(['mango', 'apple', 'banana']);
        $this->assertTrue($this->list->contains('mango'));
        $this->assertTrue($this->list->contains('banana'));
        $this->assertTrue($this->list->contains('apple'));
        $this->assertEquals(3, $this->list->count());
    }

    public function testAddBulkStringsInOrder(): void
    {
        $this->list->bulkAdd(['apple', 'banana', 'lemon', 'mango']);
        $expectedOrder = ['apple', 'banana', 'lemon', 'mango'];
        $this->assertEquals($expectedOrder, $this->list->toArray());
    }

    public function testAddBulkStringsOutOfOrder(): void
    {
        $this->list->bulkAdd(['lemon', 'mango', 'apple', 'banana']);
        $expectedOrder = ['apple', 'banana', 'lemon', 'mango'];
        $this->assertEquals($expectedOrder, $this->list->toArray());
    }

    public function testAddEmptyString(): void
    {
        $this->list->add('');
        $this->assertEquals(1, $this->list->count());
        $this->assertTrue($this->list->contains(''));
    }

    public function testAddDuplicateStrings(): void
    {
        $this->list->add('currant');
        $this->list->add('currant');
        $this->list->add('currant');
        $this->list->add('currant');
        $this->list->add('currant');
        $this->assertEquals(5, $this->list->count());
        $this->assertTrue($this->list->contains('currant'));
    }

    public function testRemoveExistingString(): void
    {
        $this->list->bulkAdd(['mango', 'apple', 'banana']);
        $this->assertTrue($this->list->remove('mango'));
        $this->assertEquals(2, $this->list->count());
        $this->assertFalse($this->list->contains('mango'));
        $this->assertTrue($this->list->contains('apple'));
        $this->assertTrue($this->list->contains('banana'));
    }

    public function testRemoveNonExistentString(): void
    {
        $this->list->bulkAdd(['mango', 'apple', 'banana']);
        $this->assertFalse($this->list->remove('cherry'));
        $this->assertEquals(3, $this->list->count());
    }

    public function testRemoveFirstString(): void
    {
        $this->list->bulkAdd(['mango', 'apple', 'banana']);
        $this->assertTrue($this->list->remove('apple'));
        $this->assertEquals(2, $this->list->count());
        $this->assertFalse($this->list->contains('apple'));
    }

    public function testRemoveLastString(): void
    {
        $this->list->bulkAdd(['mango', 'apple', 'banana']);
        $this->assertTrue($this->list->remove('mango'));
        $this->assertEquals(2, $this->list->count());
        $this->assertFalse($this->list->contains('mango'));
    }

    public function testAddArrayThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only string values.');

        $this->list->add(['mango', 'apple']);
    }

    public function testAddIntegerThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only string values.');

        $this->list->add(23);
    }

    public function testAddFloatThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only string values.');

        $this->list->add(23.5);
    }

    public function testAddBooleanThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only string values.');

        $this->list->add(false);
    }

    public function testAddNullThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only string values.');

        $this->list->add(null);
    }

    public function testRemoveWithWrongTypeThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only string values.');
        $this->list->bulkAdd(['mango', 'apple', 'banana']);

        $this->list->remove(true);
    }

    public function testContainsWithWrongTypeThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only string values.');
        $this->list->bulkAdd(['mango', 'apple', 'banana']);

        $this->list->contains(123);
    }

    public function testIteratorWithEmptyStringList(): void
    {
        $items = [];
        foreach ($this->list as $key => $value) {
            $items[$key] = $value;
        }
        $this->assertEmpty($items);
    }

    public function testIteratorWithSingleStringElement(): void
    {
        $this->list->add('mango');
        $items = [];
        foreach ($this->list as $key => $value) {
            $items[$key] = $value;
        }
        $this->assertEquals([0 => 'mango'], $items);
    }

    public function testIteratorWithMultipleElements(): void
    {
        $this->list->add('mango');
        $this->list->add('apple');
        $this->list->add('banana');
        $items = [];
        foreach ($this->list as $key => $value) {
            $items[$key] = $value;
        }
        $this->assertEquals([0 => 'apple', 1 => 'banana', 2 => 'mango'], $items);
    }
}
