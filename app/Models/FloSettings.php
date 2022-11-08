<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloSettings extends Model
{
    use HasFactory;


    protected $fillable = [

        'machine',
        'du_no',
        'flo_url',
        'scan_url',
        'unit_price',
        'snap_code',
        'snap_api_key',
        'snap_webhook_key',
        'flo_active'
    ];
}
