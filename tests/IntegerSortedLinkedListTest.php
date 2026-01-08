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

final class IntegerSortedLinkedListTest extends TestCase
{
    /**
     * @var SortedLinkedListInterface<int>
     */
    private SortedLinkedListInterface $list;

    protected function setUp(): void
    {
        $this->list = SortedLinkedListFactory::integerList();
    }

    public function testEmptyListHasZeroElements(): void
    {
        $this->assertEquals(0, $this->list->count());
    }

    public function testClearEmptyList(): void
    {
        $this->list->bulkAdd([1, 2, 3, 4]);
        $this->assertEquals(4, $this->list->count());
        $this->list->clear();
        $this->assertEquals(0, $this->list->count());
    }

    public function testAddInteger(): void
    {
        $this->list->add(5);
        $this->assertEquals(1, $this->list->count());
        $this->assertTrue($this->list->contains(5));
    }

    public function testAddBulkIntegers(): void
    {
        $this->list->bulkAdd([67, 12, 34]);
        $this->assertTrue($this->list->contains(67));
        $this->assertTrue($this->list->contains(12));
        $this->assertTrue($this->list->contains(34));
        $this->assertEquals(3, $this->list->count());
    }

    public function testAddBulkIntegersInOrder(): void
    {
        $this->list->bulkAdd([12, 34, 56, 78]);
        $expectedOrder = [12, 34, 56, 78];
        $this->assertEquals($expectedOrder, $this->list->toArray());
    }

    public function testAddBulkIntegersOutOfOrder(): void
    {
        $this->list->bulkAdd([56, 78, 12, 34]);
        $expectedOrder = [12, 34, 56, 78];
        $this->assertEquals($expectedOrder, $this->list->toArray());
    }

    public function testAddNegativeIntegers(): void
    {
        $this->list->add(-1);
        $this->list->add(-34);
        $this->list->add(-87);
        $this->list->add(-23);
        $this->assertEquals(4, $this->list->count());
        $this->assertTrue($this->list->contains(-34));
    }

    public function testAddDuplicateIntegers(): void
    {
        $this->list->add(44);
        $this->list->add(44);
        $this->list->add(44);
        $this->list->add(44);
        $this->assertEquals(4, $this->list->count());
        $this->assertTrue($this->list->contains(44));
    }

    public function testRemoveExistingInteger(): void
    {
        $this->list->bulkAdd([34, -12, 56]);
        $this->assertTrue($this->list->remove(-12));
        $this->assertEquals(2, $this->list->count());
        $this->assertFalse($this->list->contains(-12));
        $this->assertTrue($this->list->contains(56));
        $this->assertTrue($this->list->contains(34));
    }

    public function testRemoveNonExistentInteger(): void
    {
        $this->list->bulkAdd([34, -12, 56]);
        $this->assertFalse($this->list->remove(-99));
        $this->assertEquals(3, $this->list->count());
    }

    public function testRemoveFirstInteger(): void
    {
        $this->list->bulkAdd([34, -12, 56]);
        $this->assertTrue($this->list->remove(-12));
        $this->assertEquals(2, $this->list->count());
        $this->assertFalse($this->list->contains(-12));
    }

    public function testRemoveLastInteger(): void
    {
        $this->list->bulkAdd([34, -12, 56]);
        $this->assertTrue($this->list->remove(56));
        $this->assertEquals(2, $this->list->count());
        $this->assertFalse($this->list->contains(56));
    }

    public function testAddZero(): void
    {
        $this->list->add(0);
        $this->assertEquals(1, $this->list->count());
        $this->assertTrue($this->list->contains(0));
    }

    public function testAddArrayThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only integer values.');

        $this->list->add([23, 45]);
    }

    public function testAddStringThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only integer values.');

        $this->list->add('23');
    }

    public function testAddFloatThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only integer values.');

        $this->list->add(23.5);
    }

    public function testAddBooleanThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only integer values.');

        $this->list->add(true);
    }

    public function testAddNullThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only integer values.');

        $this->list->add(null);
    }

    public function testRemoveWithWrongTypeThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only integer values.');
        $this->list->bulkAdd([23, 45, 67]);

        $this->list->remove('23');
    }

    public function testContainsWithWrongTypeThrowsException(): void
    {
        $this->expectException(TypeMismatchException::class);
        $this->expectExceptionMessage('The linked list accepts only integer values.');
        $this->list->bulkAdd([23, 45, 67]);

        $this->list->contains('23');
    }

    public function testIntegerIteratorWithEmptyIntegerList(): void
    {
        $items = [];
        foreach ($this->list as $key => $value) {
            $items[$key] = $value;
        }
        $this->assertEmpty($items);
    }

    public function testIteratorWithSingleElement(): void
    {
        $this->list->add(34);
        $items = [];
        foreach ($this->list as $key => $value) {
            $items[$key] = $value;
        }
        $this->assertEquals([0 => 34], $items);
    }

    public function testIteratorWithMultipleElements(): void
    {
        $this->list->add(34);
        $this->list->add(25);
        $this->list->add(-43);
        $items = [];
        foreach ($this->list as $key => $value) {
            $items[$key] = $value;
        }
        $this->assertEquals([0 => -43, 1 => 25, 2 => 34], $items);
    }
}
