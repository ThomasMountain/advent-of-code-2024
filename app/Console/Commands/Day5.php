<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Day5 extends Command
{
    const USES_SAMPLE = true;

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
        $this->fileContent['order'] = Storage::get(
            self::USES_SAMPLE ? 'input/day-5-sample-rules.txt' : 'input/day-5-order.txt'
        );
    }

    private function step1(): int
    {
        dd($this->fileContent);
    }

    private function step2(): int
    {
    }
}
