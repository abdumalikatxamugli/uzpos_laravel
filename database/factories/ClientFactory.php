<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $client_type = $this->faker->numberBetween(0,1);
        if($client_type == 0){
            return [
                'fname'=>$this->faker->firstName(),
                'lname'=>$this->faker->lastName(),
                'mname'=>$this->faker->firstName(),
                'client_type'=>0,
                'pinfl'=>$this->faker->randomNumber(7, true).$this->faker->randomNumber(7, true),
                'psery'=>strtoupper( $this->faker->randomLetter().$this->faker->randomLetter() ),
                'pnumber'=>$this->faker->randomNumber(7, true),
                'phone_number'=>'9'.$this->faker->randomElement([0,1,3,4,7,9]).$this->faker->randomNumber(7, true)
            ];
        }else{
            return [
                'company_name'=>$this->faker->company(),
                'client_type'=>1,
                'inn'=>$this->faker->randomNumber(9, true),
                'phone_number'=>'9'.$this->faker->randomElement([0,1,3,4,7,9]).$this->faker->randomNumber(7, true)
            ];
        }
    }
}
