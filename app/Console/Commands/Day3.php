<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Day3 extends Command
{
    protected $signature = 'app:day3';

    protected $description = 'Command description';

    public function handle()
    {
        $this->input = Storage::get('input/day-3.txt');

        $this->info("Total Result for step 1 : ".$this->step1());
        $this->info("Total Result for step 2 : ".$this->step2());
    }

    public function step1()
    {
        $pattern = '/\b[a-z_]*mul\((-?\d+),\s*(-?\d+)\)/';

        preg_match_all($pattern, $this->input, $matches, PREG_SET_ORDER);

        $totalResult = 0;
        foreach ($matches as $match) {
            $totalResult = $totalResult + ($match[1] * $match[2]);
        }

        return $totalResult;
    }

    public function step2()
    {
        $splitElements = preg_split('/(?=\b[a-z_]*mul|\bdo\(\)|\bdon\'t\(\))/', $this->input, -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        $enabled = true;
        $totalResult = 0;
        $mulPattern = '/\b[a-z_]*mul\((-?\d+),\s*(-?\d+)\)/';
        $doPattern = '/\bdo\(\)/';
        $dontPattern = '/\bdon\'t\(\)/';

        foreach ($splitElements as $token) {
            if (preg_match($doPattern, $token)) {
                $enabled = true;
                continue;
            }

            if (preg_match($dontPattern, $token)) {
                $enabled = false;
                continue;
            }

            if ($enabled && preg_match($mulPattern, $token, $match)) {
                $totalResult += $match[1] * $match[2];
            }
        }

        return $totalResult;
    }
}
