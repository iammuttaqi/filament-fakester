<?php

namespace Iammuttaqi\FilamentFakester\Commands;

use Illuminate\Console\Command;

class FilamentFakesterCommand extends Command
{
    public $signature = 'filament-fakester';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
