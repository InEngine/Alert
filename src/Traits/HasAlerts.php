<?php

namespace InEngine\Alert\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use InEngine\Alert\Facades\Alert;

/**
 * HasAlerts
 * Composes Laravel's Notifiable trait and exposes an alerts() relationship scoped to configured alert types.
 */
trait HasAlerts
{
    use Notifiable;

    /**
     * alerts
     * Unread database notifications whose type is registered in alert.Alerts config.
     *
     * @return MorphMany
     */
    public function alerts(): MorphMany
    {
        return $this->notifications()->whereIn('type', Alert::getAlertTypes())->where('read_at', null);
    }
}
