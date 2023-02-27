<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class PostObserver
{
// Если пригодиться для отчиски кэша
    public function saving()
    {

        Cache::forget('Posts');

    }
    public function update()
    {

        Cache::forget('Posts');

    }
    public function deleted()
    {

        Cache::forget('Posts');

    }
}
