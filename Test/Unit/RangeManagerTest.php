<?php

declare(strict_types=1);

namespace ReadyToGo\Numbers\Test\Unit;

use PHPUnit\Framework\TestCase;
use ReadyToGo\Numbers\RangeManager;

class RangeManagerTest extends TestCase
{
    /**
     * @var RangeManager
     */
    private $rangeManager;

    public function setUp(): void
    {
        $this->rangeManager = new RangeManager;
    }

    public function testIdealCase()
    {
        $this->assertSame(
            ['1-7', '9-11', '22-23', '64-64'],
            $this->rangeManager->getRanges([1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 64, 23, 22])
        );
    }

    public function testStringInsteadOfIntCase()
    {
        $this->assertSame(
            ['1-7', '9-11', '22-23', '64-64'],
            $this->rangeManager->getRanges(['1', '2', '3', '4', '5', '6', '7', '9', '10', '11', '64', '23', '22'])
        );
    }

    public function testLeadingZeroCase()
    {
        $this->assertSame(
            ['01-07', '09-011', '022-023', '064-064'],
            $this->rangeManager->getRanges([
                '01',
                '02',
                '03',
                '04',
                '05',
                '06',
                '07',
                '09',
                '010',
                '011',
                '064',
                '023',
                '022'
            ])
        );
    }

    public function testNullCase()
    {
        $this->assertSame(
            ['1-7', '10-11', '22-23', '64-64'],
            $this->rangeManager->getRanges([1, 2, 3, 4, 5, 6, 7, null, 10, 11, 64, 23, 22])
        );
    }

    public function testOneNumberCase()
    {
        $this->assertSame(
            ['100-100'],
            $this->rangeManager->getRanges([100])
        );
    }

    public function testSequenceWithoutGapsCase()
    {
        $this->assertSame(
            ['1-7'],
            $this->rangeManager->getRanges([1, 2, 3, 4, 5, 6, 7])
        );
    }
}
