<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Reservation;
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
        $times =  Reservation::TIME_ALL;
        $status = Reservation::STATUS_ALL;

        return [
            'name' => $this->faker->name,
            'kana' => $this->faker->kananame,
            'customer_id' => rand(1, Customer::count()),
            'user_id' => rand(1, User::count()),
            'tel' =>  $tel,
            'address' => $address,
            'postcode' => $this->faker->postcode,
            'sumprice' => rand(5000 , 10000) * 2,
            'delivery' =>  null,
            'time' => $this->faker->dateTime->format('Y/m/d'),
            'datetime' =>$times[array_rand($times)],
            'status' =>  $status[array_rand($status)],
            'remarks' => $this->faker->realText(50),
            'role_id' => rand(1,11),
            'after_address' => $this->faker->streetAddress
        ];
    }
}
