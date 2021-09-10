<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix("auth")->group(function () {
    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/logout", [AuthController::class, "logout"])->middleware("auth:api");
    Route::post("/user", [AuthController::class, "user"])->middleware("auth:api");

    Route::post("/forgot-password", [AuthController::class, "forgotPassword"]);
    Route::post("/reset-password", [AuthController::class, "resetPassword"]);

    Route::get("/auth-failed", [AuthController::class, "authFailed"])->name("auth-fail");
});

Route::group(["prefix" => "extras", "middleware" => "auth:api"], function () {
    Route::resource("category", CategoryController::class);
    Route::resource("country", CountryController::class);
});

Route::group(["middleware" => "auth:api"], function () {
    Route::resource("scholarships", ScholarshipController::class);

    Route::resource("forums", ForumController::class);
    // Comments Route
    Route::get("/comments/{forum?}", [CommentController::class, "index"]);
    Route::post("/comments", [CommentController::class, "store"]);
    Route::patch("/comments/{comment}", [CommentController::class, "update"]);
    Route::delete("/comments/{comment}/{creator}", [CommentController::class, "destroy"]);

    // Favourite
    Route::get("/favourites/{user}", [FavouriteController::class, "index"]);
    Route::post("/favourites", [FavouriteController::class, "store"]);
    Route::delete("/favourites/{favourite}/{creator}", [FavouriteController::class, "destroy"]);

    // Update User Info
    Route::get("/user", [UserController::class, "index"]);
    Route::patch("/user", [UserController::class, "update"]);
    Route::delete("/user/{user}", [UserController::class, "destroy"]);
});

