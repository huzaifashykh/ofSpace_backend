<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScholarshipRequest;
use App\Http\Resources\ScholarshipCollection;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use App\Http\Resources\Scholarship as ScholarshipResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ScholarshipCollection
     */
    public function index()
    {
        return new ScholarshipCollection(Scholarship::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ScholarshipResource
     */
    public function store(ScholarshipRequest $request)
    {
        $uploadFolder = 'scholarship';
        $image = $request->file("thumbnail");
        $imageUploadedPath = $image->store($uploadFolder, 'public');

        $scholarship = Scholarship::create([
            "title" => $request->title,
            "description" => $request->description,
            "thumbnail" => Storage::disk('public')->url($imageUploadedPath),
            "country_id" => $request->countryId,
            "category_id" => $request->categoryId,
            "created_by" => $request->createdBy,
            "deadline" => $request->deadline,
        ]);

        return new ScholarshipResource($scholarship);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Scholarship  $scholarship
     * @return ScholarshipResource
     */
    public function show(Scholarship $scholarship)
    {
        return new ScholarshipResource($scholarship);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Scholarship  $scholarship
     * @return ScholarshipResource
     */
    public function update(ScholarshipRequest $request, Scholarship $scholarship)
    {
        $thumbnail = $request->thumbnail;

        if ($request->hasFile("thumbnail")){
            $uploadFolder = 'scholarships';
            $image = $request->file("thumbnail");
            $imageUploadedPath = $image->store($uploadFolder, 'public');

            $thumbnail = Storage::disk('public')->url($imageUploadedPath);
        }

        $scholarship->update([
            "title" => $request->title,
            "description" => $request->description,
            "thumbnail" => $thumbnail,
            "country_id" => $request->countryId,
            "category_id" => $request->categoryId,
            "created_by" => $request->createdBy,
            "deadline" => $request->deadline,
        ]);

        return new ScholarshipResource($scholarship);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scholarship  $scholarship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();
        return response("Delete Successfully!", 200);
    }
}
