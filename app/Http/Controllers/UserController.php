<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        return new UserCollection(User::paginate(10));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "fullName" => "required|string|max:255",
            "email" => "required|string|email|max:255",
            "profile_picture" => "nullable|string",
            "bio" => "nullable",
            "countryId" => "nullable|numeric"
        ]);

        if ($validation->fails()) {
            return response(["errors" => $validation->errors()], 422);
        }

        $profilePic = $request->profilePicture;

        if ($request->hasFile("profilePicture")){
            $uploadFolder = 'users';
            $image = $request->file("profilePicture");
            $imageUploadedPath = $image->store($uploadFolder, 'public');

            $profilePic = Storage::disk('public')->url($imageUploadedPath);
        }

        $user = User::find($request->user()->id);
        $user->full_name = $request->fullName;
        $user->email = $request->email;
        $user->password = $request->user()->password;
        $user->profile_picture = $profilePic;
        $user->bio = $request->bio;
        $user->country_id = $request->country_id;
        $user->save();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = User::where("id", $id)->delete();

        if ($res) {
            return response("Delete Successfully!", 200);
        } else {
            return response("Not Deleted!", 422);
        }
    }
}
