<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait CanStartAndEnd
{
    public function end()
    {
        $this->update(['ended_at' => Carbon::now()]);
        return $this;
    }


}
