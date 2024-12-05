<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Day4 extends Command
{
    protected $signature = 'app:day4';

    protected $description = 'Search for the word "XMAS" in a word search grid';

    protected $grid = [];

    const WORD = 'XMAS';

    const WORD_LENGTH = 4;

    // Execute the console command.
    public function handle()
    {
        // Load the word search grid from a file
        $this->grid = $this->loadGridFromFile('input/day-4.txt');

        $this->info('The answer for step 1: '.$this->step1());
        $this->info('The answer for step 2: '.$this->step2());
    }

    private function loadGridFromFile($filePath)
    {
        $fileContent = Storage::get($filePath);
        $lines = explode("\n", trim($fileContent));

        return array_map(fn ($line) => str_split($line), $lines);
    }

    private function step1()
    {
        $count = 0;
        $rowCount = count($this->grid);
        $colCount = count($this->grid[0]);

        // Check horizontal, vertical, and diagonal occurrences
        for ($r = 0; $r < $rowCount; $r++) {
            for ($c = 0; $c < $colCount; $c++) {
                if ($c + self::WORD_LENGTH <= $colCount) {
                    $count += $this->checkHorizontalRight($r, $c);
                }

                if ($r + self::WORD_LENGTH <= $rowCount) {
                    $count += $this->checkVerticalDown($r, $c);
                }

                if ($r + self::WORD_LENGTH <= $rowCount && $c + self::WORD_LENGTH <= $colCount) {
                    $count += $this->checkDiagonalDownRight($r, $c);
                }

                if ($r - self::WORD_LENGTH >= -1 && $c + self::WORD_LENGTH <= $colCount) {
                    $count += $this->checkDiagonalUpRight($r, $c);
                }
            }
        }

        return $count;
    }

    private function step2()
    {
        $count = 0;
        foreach ($this->grid as $key => $row) {
            foreach ($row as $subKey => $cell) {
                if ($cell === 'A') {
                    if (
                        !isset($this->grid[$key - 1][$subKey - 1], $this->grid[$key - 1][$subKey + 1],
                            $this->grid[$key + 1][$subKey - 1], $this->grid[$key + 1][$subKey + 1])
                    ) {
                        continue; // Skip if any necessary cell is missing
                    }


                    // Get top left
                    $topLeft = $this->grid[$key - 1][$subKey - 1];
                    // Get top right
                    $topRight = $this->grid[$key - 1][$subKey + 1];
                    // Get bottom left
                    $bottomLeft = $this->grid[$key + 1][$subKey - 1];
                    // Get bottom right
                    $bottomRight = $this->grid[$key + 1][$subKey + 1];

                    $word = $topLeft . $topRight . $bottomLeft . $bottomRight;

                    if(in_array($word, [
                        'MMSS', 'SSMM', 'MSMS', 'SMSM'
                    ])){
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    private function checkHorizontalRight($row, $column): int
    {
        return $this->checkWord($row, $column, 0, 1);
    }

    private function checkVerticalDown($row, $column): int
    {
        return $this->checkWord($row, $column, 1, 0);
    }

    private function checkDiagonalDownRight($row, $column): int
    {
        return $this->checkWord($row, $column, 1, 1);
    }

    private function checkDiagonalUpRight($row, $column): int
    {
        return $this->checkWord($row, $column, -1, 1);
    }

    private function checkWord($r, $c, $rowIncrement, $colIncrement): int
    {
        $word = '';
        for ($i = 0; $i < self::WORD_LENGTH; $i++) {
            $row = $r + ($i * $rowIncrement);
            $col = $c + ($i * $colIncrement);

            if ($row < 0 || $row >= count($this->grid) || $col < 0 || $col >= count($this->grid[0])) {
                return 0;
            }

            $word .= $this->grid[$row][$col];
        }

        return ($word === self::WORD) || ($word === Str::reverse(self::WORD)) ? 1 : 0;
    }

    private function checkForXMas(int $r, int $c)
    {
        // Above & left needs to be
    }
}
