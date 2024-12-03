<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Day2 extends Command
{
    protected $signature = 'app:day2';

    protected $description = 'Command description';

    public function handle(): void
    {
        $this->info('The answer to step 1 is '.$this->step1());
        $this->info('The answer to step 2 is '.$this->step2());
    }

    private function step1(): int
    {
        $input = explode("\r\n", Storage::get('input/day-2.txt'));

        $safeElements = 0;
        foreach ($input as $line) {
            $individualRow = explode(' ', $line);

            if ($this->isSafe($individualRow)) {
                $safeElements++;
            }
        }

        return $safeElements;
    }

    public function step2(): int
    {
        $safeElements = 0;
        $input = explode("\r\n", Storage::get('input/day-2.txt'));

        foreach ($input as $item) {
            $individualRow = explode(' ', $item);
            $possibleCombinations = $this->getPossibleCombinationsOfRow($individualRow);

            foreach ($possibleCombinations as $possibleCombination) {
                if ($this->isSafe($possibleCombination)) {
                    $safeElements++;
                    break;
                }
            }
        }

        return $safeElements;
    }

    public function getPossibleCombinationsOfRow(array $row): array
    {
        return array_map(fn ($index) => $this->removeItemFromArrayAndPreserveOriginal($row, $index), array_keys($row));
    }

    private function isOrdered(array $array): bool
    {
        return $array === Arr::sort($array) || $array === array_reverse(Arr::sort($array));
    }

    public function isSafe($array): bool
    {
        return $this->isOrdered($array) && $this->hasSafeDifferences($array);
    }

    private function removeItemFromArrayAndPreserveOriginal(
        array $array,
        int $index
    ): array {
        $copiedArray = $array;
        array_splice($copiedArray, $index, 1);

        return $copiedArray;
    }

    private function hasSafeDifferences(array $array): bool
    {
        for ($i = 1; $i < count($array); $i++) {
            if (! in_array(abs($array[$i] - $array[$i - 1]), [1, 2, 3])) {
                return false;
            }
        }

        return true;
    }
}
