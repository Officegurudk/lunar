<?php

namespace Lunar\Base\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity as SpatieLogsActivity;

trait LogsActivity
{
    use SpatieLogsActivity {
        bootLogsActivity as spatieBootLogsActivity;
    }

    protected static function bootLogsActivity(): void
    {
        if (!config("lunar.features.activity_log", true)) {
            return;
        }

        self::spatieBootLogsActivity();
    }

    /**
     * Get the log options for the activity log.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName("lunar")
            ->logAll()
            ->dontSubmitEmptyLogs()
            ->logExcept(["updated_at"]);
    }
}
