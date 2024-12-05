<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Day5 extends Command
{
    const USES_SAMPLE = false;

    protected $signature = 'app:day5';

    protected $description = 'Command description';

    public array $fileContent = [];

    public function handle(): void
    {
        $this->loadInput();

        $this->info('The answer for step 1: '.$this->step1());
        $this->info('The answer for step 2: '.$this->step2());
    }

    public function loadInput()
    {
        $this->fileContent['rules'] = Storage::get(
            self::USES_SAMPLE ? 'input/day-5-sample-rules.txt' : 'input/day-5-rules.txt'
        );
        $this->fileContent['orders'] = Storage::get(
            self::USES_SAMPLE ? 'input/day-5-sample-orders.txt' : 'input/day-5-orders.txt'
        );
    }

    private function step1(): int
    {
        // Iterate through the rules and build an array of before/after

        // Iterate through the order & check each one for any matching rules.
        //      Then look at the following records to see if the following records match the rules

        foreach (array_filter(explode(PHP_EOL, $this->fileContent['rules'])) as $rule) {
            $first = Str::before($rule, '|');
            $second = Str::after($rule, '|');
            $ruleLines[] = [
                'first' => $first, 'second' => $second,
            ];
        }

        $orders = array_filter(explode(PHP_EOL, $this->fileContent['orders']));
        foreach ($orders as $key => $order) {
            foreach ($ruleLines as $rule) {
                if (! $this->orderMatchesRule($order, $rule)) {
                    unset($orders[$key]);
                }
            }
        }

        // Get the middle item of each remaining array
        $total = 0;
        foreach ($orders as $order) {
            $orderArray = explode(',', $order);
            $middle = floor((count($orderArray)) / 2);
            $middleItem = array_slice($orderArray, $middle, 1)[0];
            $total = $total +  $middleItem;
        }

        return $total;
    }

    private function step2(): int
    {
        return 0;
    }

    private function orderMatchesRule(string $order, array $rule)
    {
        $order = explode(',', $order);

        if (!in_array($rule['first'], $order)) {
            return true; // Rule does not apply since 'first' is missing
        }

        $firstIndex = array_search($rule['first'], $order);
        $secondIndex = array_search($rule['second'], $order);

        if ($secondIndex === false) {
            return true; // Rule does not apply since 'second' is missing
        }

        return $firstIndex < $secondIndex; // 'First' must come before 'Second'
    }

}
