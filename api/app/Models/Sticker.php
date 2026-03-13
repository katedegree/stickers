<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sticker extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'image_id',   
  ];
}
