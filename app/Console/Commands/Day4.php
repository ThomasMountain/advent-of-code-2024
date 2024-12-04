<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Day4 extends Command
{
    protected $signature = 'app:day4';

    protected $description = 'Command description';

    public function handle()
    {
        $this->input = Storage::get('input/day-3.txt');

        $this->info('Total Result for step 1 : ' . $this->step1());
        $this->info('Total Result for step 2 : ' . $this->step2());
    }

    public function step1()
    {

    }

    public function step2()
    {

    }
}
