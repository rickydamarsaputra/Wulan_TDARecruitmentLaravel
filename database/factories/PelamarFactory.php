<?php

namespace Database\Factories;

use App\Models\Pelamar;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelamarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pelamar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ID_lowongan' => rand(1, 3),
            'nama_pelamar' => $this->faker->firstName,
            'kode_pelamar' => $this->faker->randomDigit,
            'keterangan' => $this->faker->text(20),
            'ktp' => $this->faker->text(5),
            'sim' => $this->faker->text(5),
            'email' => $this->faker->email,
            'web_blog' => $this->faker->text(5),
            'no_hp1' => $this->faker->phoneNumber,
            'no_hp2' => $this->faker->phoneNumber,
            'username_ig' => $this->faker->text(5),
            'link_facebook' => $this->faker->text(5),
            'username_tw' => $this->faker->text(5),
            'link_youtube' => $this->faker->text(5),
            'status' => rand(0, 2)
        ];
    }
}
