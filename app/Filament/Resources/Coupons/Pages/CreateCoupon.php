<?php

namespace App\Filament\Resources\Coupons\Pages;

use App\Filament\Resources\Coupons\CouponResource;
use App\Mail\NewCouponMail;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreateCoupon extends CreateRecord
{
    protected static string $resource = CouponResource::class;

    protected function afterCreate(): void
    {
        $coupon = $this->record;

        // Only send notifications if the coupon is active
        if ($coupon->is_active) {
            // Get all active users with an email
            $users = User::whereNotNull('email')->get();

            foreach ($users as $user) {
                // Queue the email to avoid timeout in the dashboard
                Mail::to($user->email)->queue(new NewCouponMail($coupon));
            }
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
