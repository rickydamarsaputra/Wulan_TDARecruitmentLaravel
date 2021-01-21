<?php

namespace Database\Factories;

use App\Models\Lowongan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LowonganFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lowongan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ID_member' => 1,
            'label' => $this->faker->text(5),
            'status_aktif' => rand(0, 1),
        ];
    }
}
