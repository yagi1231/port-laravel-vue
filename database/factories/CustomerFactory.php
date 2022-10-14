<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tel = str_replace('-', '', $this->faker->unique()->phoneNumber);
        $address = mb_substr($this->faker->address, 9);

        return [
            'name' => $this->faker->name,
            'kana' => $this->faker->kanaName,
            'tel' => $tel,
            'postcode' => $this->faker->postcode,
            'address' => $address,
            'remarks' => $this->faker->realText(50),
            'user_id' => rand(1, User::count())
        ];
    }
}
