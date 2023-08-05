<?php

namespace Aryala7\Chapaar\Commands;

use Illuminate\Console\Command;

class ChapaarCommand extends Command
{
    public $signature = 'chapaar';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
