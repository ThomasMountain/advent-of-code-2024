<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Day1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $input = Storage::get('input/day-1/input.txt');

        $this->step1($input);
        $this->step2($input);
    }

    public function step1($input)
    {
        foreach (explode("\n", $input) as $line) {

            $replaced = Str::replace("\r", '', $line);

            $left[] = Str::before($replaced, "   ");
            $right[] = Str::after($replaced, "   ");

        }

        $sortedLeft = array_values(Arr::sort($left));
        $sortedRight = array_values(Arr::sort($right));

        $value = 0;
        for ($i = 0; $i < count($sortedLeft); $i++) {
            $value = $value + abs($sortedLeft[$i] - $sortedRight[$i]);
        }

        $this->info("Step 1 answer: ".$value);
    }

    public function step2($input)
    {
        foreach (explode("\n", $input) as $line) {

            $replaced = Str::replace("\r", '', $line);

            $left[] = Str::before($replaced, "   ");
            $right[] = Str::after($replaced, "   ");

        }
        $overallValue = 0;
        foreach ($left as $value) {
            $countInRightArray = count(Arr::where($right, function ($item) use ($value) {
                return $item === $value;
            }));

            $overallValue = $overallValue + ($value * $countInRightArray);
        }
        $this->info("Step 2 answer: ".$overallValue);
    }
}
