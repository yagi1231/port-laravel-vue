<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
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
            'kana' => $this->faker->kananame,
            'customer_id' => rand(1, Customer::count()),
            'user_id' => rand(1, User::count()),
            'tel' => $tel ,
            'address' => $address,
            'postcode' => $this->faker->postcode,
            'order' => $this->faker->realText(50),
            'price' => rand(500 , 5000)*2 ,
            'sumprice' => rand(5000 , 10000)*2 ,
            'delivery' => $this->faker->name,
            'time' => $this->faker->date,
            'datetime' => $this->faker->time,
            'status' => $this->faker->name,
            'remarks' => $this->faker->realText(50),
            'role_id' => rand(1,11),
        ];
    }
}
