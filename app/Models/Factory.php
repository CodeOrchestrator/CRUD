<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{

    protected $table = 'factories';
    use HasFactory;
    protected $fillable = ['name', 'motto', 'user_id', 'logo_image'];
}
