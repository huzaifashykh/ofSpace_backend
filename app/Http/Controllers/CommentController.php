<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\Comment as CommentResource;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $forum
     * @return CommentCollection
     */
    public function index($forum = null)
    {
        $comments = Comment::paginate(10);
        if ($forum != null) {
            $comments = Comment::where(["forum_id" => $forum])->get();
        }
        return new CommentCollection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommentRequest  $request
     * @return CommentResource
     */
    public function store(CommentRequest $request)
    {
        $comments = Comment::create([
            "comment" => $request->comment,
            "forum_id" => $request->forumId,
            "created_by" => $request->createdBy,
        ]);
        return new CommentResource($comments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return CommentResource
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update([
            "comment" => $request->comment,
            "forum_id" => $request->forumId,
            "created_by" => $request->createdBy,
        ]);
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Comment $comment
     * @param $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment, $creator)
    {
        $deleteComment = Comment::where(["created_by" => $creator], ["id" => $comment])->get();
        Comment::destroy($deleteComment);
        return response("Delete Successfully", 200);
    }
}
