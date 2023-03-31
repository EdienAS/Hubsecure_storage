<?php

namespace Database\factories;

use App\Containers\Teams\Models\TeamFolderInvitation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFolderInvitationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeamFolderInvitation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'                => $this->faker->id,
            'uuid'              => $this->faker->uuid,
            'parent_folder_id'  => $this->faker->id,
            'inviter_id'        => $this->faker->id,
            'email'             => $this->faker->email,
            'permission'        => $this->faker->randomElement(['can-edit', 'can-view']),
            'status'            => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
