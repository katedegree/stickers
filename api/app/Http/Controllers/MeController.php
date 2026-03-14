<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MeController extends Controller
{
  public function index()
  {
    // FLOW: 1
    $authUser = request()->user();

    // FLOW: 2
    $authUser->load('ownedStickers.image', 'iconImage');

    // FLOW: 3
    return response()->json([
      'me' => [
        'id' => $authUser->id,
        'name' => $authUser->name,
        'email' => $authUser->email,
        'iconUrl' => $authUser->iconImage?->url,
        'stickers' => $authUser->ownedStickers->map(function ($sticker) {
          return [
            'id' => $sticker->id,
            'url' => $sticker->image->url
          ];
        })
      ]
    ]);
  }

  public function update(MeUpdateRequest $request)
  {
    // FLOW: 1
    $authUser = request()->user();

    // FLOW: 2
    $name = $request->input('name');
    $email = $request->input('email');
    $password = $request->input('password');
    $iconImageId = $request->input('iconImageId');

    // FLOW: 3
    if (!is_null($name)) {
      $authUser->name = $name;
    }
    if (!is_null($email)) {
      $authUser->email = $email;
    }
    if (!is_null($password)) {
      $authUser->password = Hash::make($password);
    }
    if (!is_null($iconImageId)) {
      $authUser->icon_image_id = $iconImageId;
    }
    $authUser->save();

    // FLOW: 4
    return response()->noContent(200);
  }
}
