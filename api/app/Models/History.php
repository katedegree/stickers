<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
  protected $fillable = [
    'receiver_user_id',
    'sticker_id',
  ];

  public function sticker()
  {
    return $this->belongsTo(Sticker::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'receiver_user_id');
  }
}
