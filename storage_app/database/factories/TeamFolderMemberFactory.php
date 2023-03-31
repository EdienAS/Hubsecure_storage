<?php

namespace Database\factories;

use App\Containers\Teams\Models\TeamFolderMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFolderMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeamFolderMember::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_folder_id'  => $this->faker->id,
            'user_id'    => $this->faker->id,
            'permission' => $this->faker->randomElement(['can-edit', 'can-view', 'owner']),
        ];
    }
}
