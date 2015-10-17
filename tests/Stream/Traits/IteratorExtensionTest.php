<?php
/**
 * This file is part of the Stream package.
 *
 * (c) Hunts Chen <hunts.c@gmail.com>
 */

namespace Stream\Traits;

use Stream\ComparatorFactory;
use Stream\IteratorClass;
/**
 * Test cases for class: Stream\Traits\IteratorExtension
 */
class IteratorExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param \Iterator $it
     * @param mixed $first
     * @param mixed $last
     * @param int $count
     * @param callable $predicate
     *
     * @dataProvider dataProvider
     */
    public function testFirst(\Iterator $it, $first, $last, $count, callable $predicate = NULL)
    {
        $this->assertEquals($first, $it->first($predicate));
    }

    /**
     * @param \Iterator $it
     * @param mixed $first
     * @param mixed $last
     * @param int $count
     * @param callable $predicate
     *
     * @dataProvider dataProvider
     */
    public function testLast(\Iterator $it, $first, $last, $count, callable $predicate = null)
    {
        $this->assertEquals($last, $it->last($predicate));
    }

    /**
     * @param \Iterator $it
     * @param mixed $first
     * @param mixed $last
     * @param int $count
     * @param callable $predicate
     *
     * @dataProvider dataProvider
     */
    public function testCount(\Iterator $it, $first, $last, $count, callable $predicate = null)
    {
        $this->assertEquals($count, $it->count($predicate));
    }

    /**
     * @param \Iterator $it
     * @param mixed $first
     * @param mixed $last
     * @param int $count
     * @param callable $predicate
     *
     * @dataProvider dataProvider
     */
    public function testEach(\Iterator $it, $first, $last, $count, callable $predicate = null)
    {
        $it->each(function($item) use(&$count) {
            $count--;
        }, $predicate);

        $this->assertEquals(0, $count);
    }

    /**
     * @param \Iterator $it
     * @param number $min
     * @param number $max
     * @param number $avg
     * @param number $sum
     * @param callable $predicate
     *
     * @dataProvider numberDataProvider
     */
    public function testMin(\Iterator $it, $min, $max, $avg, $sum, callable $predicate = null)
    {
        $this->assertEquals($min, $it->min(ComparatorFactory::intComparator(),$predicate));
    }

    /**
     * @param \Iterator $it
     * @param number $min
     * @param number $max
     * @param number $avg
     * @param number $sum
     * @param callable $predicate
     *
     * @dataProvider numberDataProvider
     */
    public function testMax(\Iterator $it, $min, $max, $avg, $sum, callable $predicate = null)
    {
        $this->assertEquals($max, $it->max(ComparatorFactory::intComparator(), $predicate));
    }

    /**
     * @param \Iterator $it
     * @param number $min
     * @param number $max
     * @param number $avg
     * @param number $sum
     * @param callable $predicate
     *
     * @dataProvider numberDataProvider
     */
    public function testAverage(\Iterator $it, $min, $max, $avg, $sum, callable $predicate = null)
    {
        $this->assertEquals($avg, $it->average($predicate));
    }

    /**
     * @param \Iterator $it
     * @param number $min
     * @param number $max
     * @param number $avg
     * @param number $sum
     * @param callable $predicate
     *
     * @dataProvider numberDataProvider
     */
    public function testSum(\Iterator $it, $min, $max, $avg, $sum, callable $predicate = null)
    {
        $this->assertEquals($sum, $it->sum($predicate));
    }

    public function dataProvider()
    {
        $emptyIterator = new IteratorClass();

        $func = new IteratorClass(5);
        $func[0] = '0';
        $func[1] = null;
        $func[2] = 'x';
        $func[3] = 'xyz';
        $func[4] = 'kkx';

        return array(
            array($emptyIterator, null, null, 0),
            array($func, '0', 'kkx', 5),
            array($func, 'x', 'kkx', 3, function($item) {
                return strpos($item, 'x') !== false;
            }),
            array($func, null, null, 1, function($item) {
                return $item === null;
            }),
            array($func, '0', 'kkx', 4, function($item) {
                return $item !== null;
            })
        );
    }

    public function numberDataProvider()
    {
        $emptyIterator = new IteratorClass();

        $func = new IteratorClass(5);
        $func[0] = -2;
        $func[1] = 1;
        $func[2] = 7;
        $func[3] = 3;
        $func[4] = 4;

        return array(
            array($emptyIterator, null, null, null, null),
            array($func, -2, 7, 2.6, 13),
            array($func, 1, 7, 3.75, 15, function($item) {
                return $item > 0;
            }),
        );
    }
}

?>