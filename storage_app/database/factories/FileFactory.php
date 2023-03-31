<?php

namespace Database\factories;

use App\Containers\Files\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'         => $this->faker->randomDigit,
            'uuid'       => $this->faker->uuid,
            'user_id'    => 1,
            'creator_id' => 1,
            'name'       => $this->faker->word,
            'basename'   => Str::slug($this->faker->name),
            'mimetype'   => $this->faker->mimeType,
            'filesize'   => $this->faker->numberBetween(10000, 99999),
            'type'       => $this->faker->randomElement(
                ['image', 'file', 'video', 'audio']
            ),
            'created_at' => $this->faker->dateTimeBetween('-36 months'),
            'file_storage_option_id' => 1,
            'file_hash' => hash('sha256', 'test')
        ];
    }
}
