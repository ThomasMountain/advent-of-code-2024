<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Day1 extends Command
{
    protected $signature = 'app:day1';

    protected $description = 'Command description';

    public function handle(): void
    {
        $input = Storage::get('input/day-1.txt');

        $this->step1($input);
        $this->step2($input);
    }

    public function step1($input)
    {
        [$left, $right] = $this->processInput($input);

        $sortedLeft = array_values(Arr::sort($left));
        $sortedRight = array_values(Arr::sort($right));

        $value = 0;
        for ($i = 0; $i < count($sortedLeft); $i++) {
            $value += abs($sortedLeft[$i] - $sortedRight[$i]);
        }

        $this->info('Step 1 answer: '.$value);
    }

    public function step2($input)
    {
        [$left, $right] = $this->processInput($input);

        $overallValue = 0;
        foreach ($left as $value) {
            $countInRightArray = count(Arr::where($right, fn($item) => $item === $value));
            $overallValue += ($value * $countInRightArray);
        }
        $this->info('Step 2 answer: '.$overallValue);
    }

    private function processInput(string $input): array
    {
        $left = [];
        $right = [];

        foreach (explode("\n", $input) as $line) {
            $replaced = Str::replace("\r", '', $line);
            $left[] = Str::before($replaced, '   ');
            $right[] = Str::after($replaced, '   ');
        }

        return [$left, $right];
    }
}
