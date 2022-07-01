<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->name,
            'lastName' => $this->faker->lastName,
            'subject' => $this->faker->sentence,
            'country' => $this->faker->country,
            'email' => $this->faker->email,
            'birthDate' => $this->faker->date,
            'phone' => $this->faker->phoneNumber
        ];
    }
}
