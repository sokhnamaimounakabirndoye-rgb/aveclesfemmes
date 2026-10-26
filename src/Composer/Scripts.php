<?php

namespace App\Composer;

class Scripts
{
    public static function makeEntity(): void
    {
        $process = proc_open(
            'php bin/console make:entity',
            [0 => STDIN, 1 => STDOUT, 2 => STDERR],
            $pipes
        );

        if (is_resource($process)) {
            proc_close($process);
        }
    }
}