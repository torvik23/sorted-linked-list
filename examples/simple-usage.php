<?php

/**
 * Basic usage example Sorted Linked List library.
 */

declare(strict_types=1);

use Torvik23\SortedLinkedList\SortedLinkedListFactory;

require_once __DIR__ . '/../vendor/autoload.php';

echo '=== Sorted Linked List Usage Examples ===' . PHP_EOL;

echo '(1) Integer List With Default Parameters (ascending = true, allowDuplicates = true, comparator = null):' . PHP_EOL;
$integerlist = SortedLinkedListFactory::integerList();
$integerlist->add(3);
$integerlist->add(2);
$integerlist->add(1);
$integerlist->add(4);
$integerlist->add(5);
echo 'Added: 3, 2, 1, 4, 5' . PHP_EOL;
echo 'Sorted result: ' . implode(', ', $integerlist->toArray()) . PHP_EOL;
echo '------------------------------------------' . PHP_EOL;
echo 'Count: ' . $integerlist->count() . PHP_EOL;
echo 'First: ' . $integerlist->first() . PHP_EOL;
echo 'Last: ' . $integerlist->last() . PHP_EOL;
echo '------------------------------------------' . PHP_EOL;
echo 'Contains 4 in the list... ' . ($integerlist->contains(4) ? 'Yes' : 'No') . PHP_EOL;
echo 'Contains 10 in the list... ' . ($integerlist->contains(10) ? 'Yes' : 'No') . PHP_EOL;
echo '------------------------------------------' . PHP_EOL;
echo 'Remove 3 from the list... ' . ($integerlist->remove(3) ? 'DONE' : 'NOT FOUND') . PHP_EOL;
echo 'Remove 20 from the list (non-existing element)... ' . ($integerlist->remove(20) ? 'DONE' : 'NOT FOUND') . PHP_EOL;
echo 'List after removal: ' . implode(', ', $integerlist->toArray()) . PHP_EOL;
echo '------------------------------------------' . PHP_EOL;
echo 'Clear the list... ' . $integerlist->clear() . PHP_EOL;
$listIntStatus = implode(', ', $integerlist->toArray());
echo 'List after clearing: ' . ($listIntStatus === '' ? 'EMPTY' : $listIntStatus) . PHP_EOL . PHP_EOL . PHP_EOL;

echo '(2) String List With Default Parameters (ascending = true, allowDuplicates = true, comparator = null):' . PHP_EOL;
$stringlist = SortedLinkedListFactory::stringList();
$stringlist->add('red');
$stringlist->add('green');
$stringlist->add('yellow');
$stringlist->add('blue');
$stringlist->add('orange');
$stringlist->add('black');
echo 'Added: red, green, yellow, blue, orange, black' . PHP_EOL;
echo 'Sorted result: ' . implode(', ', $stringlist->toArray()) . PHP_EOL;
echo '------------------------------------------' . PHP_EOL;
echo 'Count: ' . $stringlist->count() . PHP_EOL;
echo 'First: ' . $stringlist->first() . PHP_EOL;
echo 'Last: ' . $stringlist->last() . PHP_EOL;
echo '------------------------------------------' . PHP_EOL;
echo 'Contains "blue" in the list... ' . ($stringlist->contains('blue') ? 'Yes' : 'No') . PHP_EOL;
echo 'Contains "white" in the list... ' . ($stringlist->contains('white') ? 'Yes' : 'No') . PHP_EOL;
echo '------------------------------------------' . PHP_EOL;
echo 'Remove "black" from the list... ' . ($stringlist->remove('black') ? 'DONE' : 'NOT FOUND') . PHP_EOL;
echo 'Remove "grey" from the list (non-existing element)... ' . ($stringlist->remove('grey') ? 'DONE' : 'NOT FOUND') . PHP_EOL;
echo 'List after removal: ' . implode(', ', $stringlist->toArray()) . PHP_EOL;
echo '------------------------------------------' . PHP_EOL;
echo 'Clear the list... ' . $stringlist->clear() . PHP_EOL;
$listStringStatus = implode(', ', $stringlist->toArray());
echo 'List after clearing: ' . ($listStringStatus === '' ? 'EMPTY' : $listStringStatus) . PHP_EOL;

echo '=== End of Examples ===' . PHP_EOL;