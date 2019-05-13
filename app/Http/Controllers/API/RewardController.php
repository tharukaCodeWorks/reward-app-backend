<?php

/*
 *
 * @coded by: Tharuka Lakshan
 * @date    : 29/04/19
 *
 * description: increase credit, decrease credit
 *
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Util\ApiWrapper;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class RewardController extends Controller
{

    /*
     * Increase rewards
     */
    public function increaseRewards(Request $request)
    {
        $user = $request->user();


        $num_of_points = $request->get('points');
        $user->points = $user->points + $num_of_points;
        $user->save();

       return ApiWrapper::wrapApiResponse(['message'=>'Value incremented success', 'user'=>$request->user()], 'success', 200);

    }

    /*
     * Decrease rewards
     */
    public function decreaseRewards(Request $request)
    {
        $user = auth('api')->user();
        if ($user->points > 0) {
            $num_of_points = $request->get('points');
            $user->points = $user->points - $num_of_points;
            $user->save();
            return ApiWrapper::wrapApiResponse(['message'=>'Value incremented success', 'user'=>$request->user()], 'success', 200);
        }
        return ApiWrapper::wrapApiResponse(['message'=>'No points available for decrement', 'user'=>$request->user()], 'failed', 200);
    }
}
