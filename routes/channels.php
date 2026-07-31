<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('business.{businessId}.orders', function ($user, $businessId) {
    return in_array($user->role, ['owner', 'staff']) && (int) $user->business_id === (int) $businessId;
});
