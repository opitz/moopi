<?php

namespace Database\Factories;

use App\Models\Commit;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'plugin_id' => \App\Models\Plugin::factory(),
            'collection_id' => $this->faker->randomDigitNotNull,
            'commit_id' => $this->faker->randomDigitNotNull,
            'tag' => $this->faker->word,
            'version' => $this->faker->randomNumber(8)
            //
        ];
    }
}
