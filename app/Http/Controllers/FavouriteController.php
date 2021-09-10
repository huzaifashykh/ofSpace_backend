<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavouriteRequest;
use App\Http\Resources\FavouriteCollection;
use App\Http\Resources\Favourite as FavouriteResource;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $user
     * @return FavouriteCollection
     */
    public function index($user)
    {
        $favourites = Favourite::where(["user_id" => $user])->get();
        return new FavouriteCollection($favourites);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return FavouriteResource
     */
    public function store(FavouriteRequest $request)
    {
        $favourite = Favourite::create([
            "user_id" => $request->userId,
            "scholarship_id" => $request->scholarshipId
        ]);

        return new FavouriteResource($favourite);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Favourite $favourite
     * @param $creator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favourite $favourite, $creator)
    {
        $deleteFavourite = Favourite::where(["user_id" => $creator], ["id" => $favourite])->get();
        $isDelete = Favourite::destroy($deleteFavourite);

        if ($isDelete == 0) {
            return response("Not Deleted!", 400);
        }

        return response("Delete Successfully!", 200);
    }
}
