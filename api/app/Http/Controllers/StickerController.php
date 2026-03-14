<?php

namespace App\Http\Controllers;

use App\Http\Requests\StickerStoreRequest;
use App\Models\History;
use App\Models\Sticker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StickerController extends Controller
{
  public function index(Request $request)
  {
    // FLOW: 1
    $authUser = request()->user();

    // FLOW: 2
    $offset = $request->input('offset');
    $limit = $request->input('limit');

    // FLOW: 3
    $query = History::where('receiver_user_id', $authUser->id)
      ->whereHas('sticker')
      ->with('sticker.image')
      ->orderByDesc('created_at');

    // FLOW: 4
    $total = $query->count() ?? 1;
    $lastPage = (int) ceil($total / ($limit ?? $total));

    // FLOW: 5
    if (!is_null($offset)) {
      $query->offset($offset);
    }
    if (!is_null($limit)) {
      $query->limit($limit);
    }
    $histories = $query->get();

    // FLOW: 6
    $stickers = $histories->map(function ($history) {
      return [
        'id'  => $history->sticker->id,
        'url' => $history->sticker->image->url,
      ];
    });
    return response()->json([
      'stickers' => $stickers,
      'lastPage' => $lastPage,
    ]);
  }

  public function store(StickerStoreRequest $request)
  {
    // FLOW: 1
    $authUser = request()->user();

    // FLOW: 2
    $imageId = $request->input('imageId');

    // FLOW: 3
    if ($authUser->madeStickers()->count() >= 5) {
      return response()->json([
        'type' => 'error',
        'message' => 'ステッカーが埋まっているので、削除してください。'
      ], 400);
    }

    DB::transaction(function () use ($authUser, $imageId) {
      // FLOW: 4
      $sticker = $authUser->madeStickers()->create([
        'image_id' => $imageId,
      ]);

      // FLOW: 5
      $authUser->ownedStickers()->attach($sticker->id);

      // FLOW: 6
      $authUser->histories()->create([
        'sticker_id' => $sticker->id,
      ]);
    });

    // FLOW: 6
    return response()->noContent(201);
  }

  public function show(int $stickerId)
  {
    // FLOW: 1
    $authUser = request()->user();

    // FLOW: 2
    $sticker = Sticker::with([
      'image',
      'madeUser.iconImage',
      'histories' => fn($q) => $q->orderByDesc('created_at')->with('user.iconImage')
    ])
      ->whereHas('histories', fn($q) => $q->where('receiver_user_id', $authUser->id))
      ->find($stickerId);

    // FLOW: 3
    if (!$sticker) {
      abort(404);
    }

    // FLOW: 4
    return response()->json([
      'sticker' => [
        'id'  => $sticker->id,
        'url' => $sticker->image->url,
        'user' => [
          'id'      => $sticker->madeUser->id,
          'name'    => $sticker->madeUser->name,
          'iconUrl' => $sticker->madeUser->iconImage?->url,
        ],
        'histories' => $sticker->histories->map(fn($history) => [
          'id'      => $history->user->id,
          'name'    => $history->user->name,
          'iconUrl' => $history->user->iconImage?->url,
        ]),
      ],
    ]);
  }

  public function destroy(int $stickerId)
  {
    // FLOW: 1
    $authUser = request()->user();

    // FLOW: 2
    Sticker::where('id', $stickerId)
      ->where('user_id', $authUser->id)
      ->delete();

    // FLOW: 3
    return response()->noContent(200);
  }

  public function trade(int $stickerId)
  {
    // FLOW: 1
    $authUser = request()->user();

    // FLOW: 2
    $hasSticker = DB::table('user_stickers')
      ->where('user_id', $authUser->id)
      ->where('sticker_id', $stickerId)
      ->exists();
    if (!$hasSticker) {
      abort(404);
    }

    // FLOW: 3
    $newSticker = Sticker::query()
      ->whereDoesntHave('ownedUsers', function ($query) use ($authUser) {
        $query->where('user_id', $authUser->id);
      })
      ->inRandomOrder()
      ->first();

    // FLOW: 4
    if (!$newSticker) {
      return response()->json([
        'type'    => 'error',
        'message' => '交換できるステッカーがありませんでした。',
      ], 404);
    }

    DB::transaction(function () use ($authUser, $stickerId, $newSticker) {
      // FLOW: 5
      $authUser->histories()->create([
        'sticker_id' => $newSticker->id,
      ]);

      // FLOW: 6
      $authUser->ownedStickers()->detach($stickerId);
      $authUser->ownedStickers()->attach($newSticker->id);
    });

    // FLOW: 7
    return response()->json([
      'stickerId' => $newSticker->id,
    ]);
  }
}
