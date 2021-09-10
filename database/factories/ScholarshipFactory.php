<?php

namespace Database\Factories;

use App\Models\Extras\Category;
use App\Models\Extras\Country;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScholarshipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Scholarship::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->sentence(15, true),
            "description" => $this->faker->text(700),
            "thumbnail" => $this->faker->imageUrl(900, 600),
            "country_id" => Country::all()->random()->id,
            "category_id" => Category::all()->random()->id,
            "created_by" => User::all()->random()->id,
            "deadline" => $this->faker->dateTime(),
        ];
    }
}
