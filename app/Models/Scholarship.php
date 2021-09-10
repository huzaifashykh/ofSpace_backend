<?php

namespace App\Models;

use App\Models\Extras\Category;
use App\Models\Extras\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $casts = [
        'deadline' => 'datetime',
    ];

    protected $fillable = [
        "title",
        "description",
        "thumbnail",
        'country_id',
        'category_id',
        'created_by',
        'deadline'
    ];

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function category() {
        return $this->belongsTo(Category::class );
    }

    public function user() {
        return $this->belongsTo(User::class, "created_by");
    }
}
