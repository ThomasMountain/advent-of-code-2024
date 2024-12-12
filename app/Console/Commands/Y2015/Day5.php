<?php

namespace App\Console\Commands\Y2015;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Day5 extends Command
{
    const DAY_NUMBER = 5;
    protected $signature = 'app:2015-day5';

    protected $description = 'Command description';

    public function handle()
    {
        $this->info("Starting processing day " . self::DAY_NUMBER);
        $input = Storage::get('input/2015/day5.txt');

        $startTime = now();

        $this->info("Step 1 Result: " . $this->step1($input));
        $this->info("Step 1 Result: " . $this->step2($input));

        $this->info("Finished processing day ".self::DAY_NUMBER." in " . $startTime->diffInSeconds(now()) . " seconds");
    }

    public function step1(string $input): int
    {
        $niceCount = 0;
        foreach (explode(PHP_EOL, $input) as $item) {
            if($this->isNiceAccordingToStep1Rules($item)) {
                $niceCount++;
            }
        }

        return $niceCount;
    }

    public function step2(string $input)
    {
        $niceCount = 0;
        foreach (explode(PHP_EOL, $input) as $item) {
            if($this->isNiceAccordingToStep2Rules($item)) {
                $niceCount++;
            }
        }

        return $niceCount;
    }

    private function isNiceAccordingToStep1Rules(string $item): bool
    {
        if (!$this->vowelCount($item)) {
            return false;
        }
        if (!$this->containsSequentialDuplicates($item)) {
            return false;
        }
        if ($this->containsIllegalStrings($item)) {
            return false;
        }

        return true;

//    It contains at least one letter that appears twice in a row, like xx, abcdde (dd), or aabbccdd (aa, bb, cc, or dd).
//It does not contain the strings ab, cd, pq, or xy, even if they are part of one of the other requirements.
    }

    private function isNiceAccordingToStep2Rules(): bool
    {
        // It contains a pair of any two letters that appears at least twice in the string without overlapping,
        // like xyxy (xy) or aabcdefgaa (aa), but not like aaa (aa, but it overlaps).

        //It contains at least one letter which repeats with exactly one letter between them, like xyx, abcdefeghi (efe), or even aaa.
        return false;
    }

    private function vowelCount($item): bool
    {
        $a = Str::substrCount($item, "a");
        $e = Str::substrCount($item, "e");
        $i = Str::substrCount($item, "i");
        $o = Str::substrCount($item, "o");
        $u = Str::substrCount($item, "u");

        return ($a + $e + $i + $o + $u) >= 3;
    }

    private function containsSequentialDuplicates(string $item): bool
    {
        $alphabet = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o',
            'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        ];
        foreach ($alphabet as $letter) {
            if (Str::contains($item, $letter.$letter)) {
                return true;
            }
        }

        return false;
    }

    private function containsIllegalStrings($item): bool
    {
        $illegalStrings = [
            'ab', 'cd', 'pq', 'xy'
        ];
        foreach ($illegalStrings as $illegalString) {
            if(Str::contains($item, $illegalString)){
                return true;
            }
        }
        return false;
    }

}
