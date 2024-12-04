<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Day4 extends Command
{
    const LENGTH = 140;
    protected $signature = 'app:day4';

    protected $description = 'Command description';

    public function handle()
    {
        $this->input = Storage::get('input/day-4-sample.txt');

        $this->info('Total Result for step 1 : ' . $this->step1());
        $this->info('Total Result for step 2 : ' . $this->step2());
    }

    public function step1()
    {
        $lines = explode("\n", $this->input);

        // Horizontal/Backwards
        $horizontalXmases = 0;
        foreach ($lines as $item) {
            $horizontalXmases = $horizontalXmases + Str::substrCount($item, 'XMAS');
            $horizontalXmases = $horizontalXmases + Str::substrCount(Str::reverse($item), 'XMAS');
        }

        // Vertical
        $characterSplitLines = [];
        foreach ($lines as $key => $line) {
            $characterSplitLines[] = Str::ucsplit($line);
        }

        foreach ($characterSplitLines as $key => $line) {
            foreach ($line as $subKey => $subLine) {
                $transposed[$subKey][$key] = $subLine;
            }
        }

        $verticalXmases = 0;
        foreach ($transposed as $item) {
            $verticalString = implode('', $item);
            $verticalXmases = $verticalXmases + Str::substrCount($verticalString, 'XMAS');
            $verticalXmases = $verticalXmases + Str::substrCount(Str::reverse($verticalString), 'XMAS');
        }

        // Diagonal

        // Similar to the transpose above but we need to look at X either side on the next line

        return $verticalXmases + $horizontalXmases;
    }

    public function step2()
    {

    }
}
