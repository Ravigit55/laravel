<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'password','points_balance'];

public function transactions() {
    return $this->hasMany(Transaction::class);
}
public function redemptions() {
    return $this->hasMany(Redemption::class);
}
}
