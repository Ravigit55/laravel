<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    use HasFactory;
    protected $fillable = [
    'member_id', 'points_used', 'discount_amount'
];
}
