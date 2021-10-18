<?php

declare(strict_types=1);

namespace ReadyToGo\Numbers;

class RangeManager
{
    /**
     * Input: 19,4,3,16,7,15,2,18,1
     * Output: [
     *     '1-4',
     *     '7-7',
     *     '15-19',
     * ]
     *
     * @param int[] $numbers
     * @return array
     */
    public function getRanges(array $numbers): array
    {
        $numbers = array_unique(array_filter($numbers));
        if ($this->isSequenceWithoutGaps($numbers)) {
            return [min($numbers) . '-' . max($numbers)];
        }

        sort($numbers);
        $sequence = [];
        $ranges = [];

        foreach ($numbers as $key => $number) {
            if ($this->canNumberBeAddedToTheSequence((int) $number, $sequence)) {
                $sequence[] = $number;
                unset($numbers[$key]);
            } else {
                $ranges = array_merge(
                    [min($sequence) . '-' . max($sequence)],
                    $this->getRanges($numbers)
                );
                break;
            }
        }

        return $ranges;
    }

    /**
     * @param array $numbers
     * @return bool
     */
    private function isSequenceWithoutGaps(array $numbers): bool
    {
        $max = (int) max($numbers);
        $min = (int) min($numbers);

        if ($max === $min) {
            return true;
        }

        return ($max - $min + 1) === count($numbers);
    }

    /**
     * @param int $nextNumber
     * @param array $sequence
     * @return bool
     */
    private function canNumberBeAddedToTheSequence(int $nextNumber, array $sequence): bool
    {
        $lastItemFromTheSequence = (int) end($sequence);

        if (!$lastItemFromTheSequence) {
            return true;
        }

        return ($lastItemFromTheSequence + 1) === $nextNumber;
    }
}
