<?php

namespace Database\Factories;

use App\Models\Plugin;
use Illuminate\Database\Eloquent\Factories\Factory;

class PluginFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plugin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'github_url' => $this->faker->url(),
            'developer' => $this->faker->name(),
            'install_path' => $this->faker->filePath(),
            'wiki_url' => $this->faker->url(),
            'category_id' => \App\Models\Category::factory(),
            'description' => $this->faker->paragraphs(3),
        ];
    }
}
