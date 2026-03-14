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

  public function histories()
  {
    return $this->hasMany(History::class);
  }

  public function madeUser()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
