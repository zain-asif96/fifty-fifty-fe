<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'main' => 'array'
    ];

    public static function ratesUpdated(){
        $websiteSettings = Setting::first();

        if(!$websiteSettings){
            return Setting::create(['main' => [ 'fetched_at' => Carbon::now()]]);
        }

        return $websiteSettings->update([
            'main' => [
                'fetched_at' => Carbon::now()
            ]
        ]);
    }

    public static function hasNewRates(): bool
    {
        $websiteSettings = Setting::first();

        if(!$websiteSettings){
            return false;
        }

        return Carbon::parse($websiteSettings->main['fetched_at'])->gt(Carbon::now()->subMinutes(15));
    }
}
