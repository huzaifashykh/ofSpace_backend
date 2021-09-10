<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Http\Resources\Extras\CountryCollection;
use App\Http\Resources\Extras\Country as CountryResource;
use App\Models\Extras\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CountryCollection
     */
    public function index()
    {
        return new CountryCollection(Country::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CountryResource
     */
    public function store(CountryRequest $request)
    {
        $country = Country::create([
            "name" => $request->name,
            "phone_code" => $request->phoneCode,
            "country_code" => $request->countryCode
        ]);

        return new CountryResource($country);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Extras\Country  $country
     * @return CountryResource
     */
    public function show(Country $country)
    {
        return new CountryResource($country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Extras\Country  $country
     * @return CountryResource
     */
    public function update(Request $request, Country $country)
    {
        $country->update([
            "name" => $request->name,
            "phone_code" => $request->phoneCode,
            "country_code" => $request->countryCode
        ]);

        return new CountryResource($country);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Extras\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return response("Delete Successfully", 200);
    }
}
