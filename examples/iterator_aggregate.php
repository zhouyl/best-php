<?php

class SimplePagination implements Countable, IteratorAggregate
{
    public function __construct(array $data)
    {
        $this->innerIterator = new ArrayObject($data);
    }

    public function getIterator()
    {
        return $this->innerIterator->getIterator();
    }

    public function count()
    {
        return count($this->innerIterator);
    }
}


$data = [
    [1, 2, 3, 4, 5],
    [6, 7, 8, 9, 10],
    [11, 12, 13, 14, 15],
    [16, 17, 18],
];


$pagination = new SimplePagination($data);

// total pages: 4
echo sprintf("total pages: %s\n", count($pagination));

// page 1 - [1,2,3,4,5]
// page 2 - [6,7,8,9,10]
// page 3 - [11,12,13,14,15]
// page 4 - [16,17,18]
foreach ($pagination as $pageNo => $pageItems) {
    echo sprintf("page %d - %s\n", $pageNo + 1, json_encode($pageItems));
}
