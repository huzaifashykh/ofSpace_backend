<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForumRequest;
use App\Http\Resources\ForumCollection;
use App\Models\Forum;
use App\Http\Resources\Forum as ForumResource;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ForumCollection
     */
    public function index()
    {
        return new ForumCollection(Forum::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ForumResource
     */
    public function store(ForumRequest $request)
    {
        $forums = Forum::create([
            "title" => $request->title,
            "description" => $request->description,
            "created_by" => $request->createdBy,
        ]);

        return new ForumResource($forums);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return ForumResource
     */
    public function show(Forum $forum)
    {
        return new ForumResource($forum);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forum  $forum
     * @return ForumResource
     */
    public function update(ForumRequest $request, Forum $forum)
    {
        $forum->update([
            "title" => $request->title,
            "description" => $request->description,
            "created_by" => $request->createdBy,
        ]);

        return new ForumResource($forum);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum)
    {
        $forum->delete();
        return response("Delete Successfully", 200);
    }
}
