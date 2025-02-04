<?php

namespace App\Services;

use App\Interfaces\PostSubscriberInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostSubscriberService implements PostSubscriberInterface
{
    public function insert($postId, $subscriberId): \Illuminate\Http\JsonResponse
    {
       try {
           DB::enableQueryLog();
           DB::beginTransaction();
           DB::table('post_subscriber')->insert([
               'post_id' => $postId,
               'user_id' => $subscriberId,
               'created_at' => now(),
               'updated_at' => now(),
           ]);

           DB::commit();
           return response()->json(['message' => 'Inserted successfully!'], 200);
       }catch (\Exception $exception){
           DB::rollBack();
           return response()->json(['message' => 'Failed to insert data.', 'error' => $exception->getMessage()], 500);
       }
    }
}
