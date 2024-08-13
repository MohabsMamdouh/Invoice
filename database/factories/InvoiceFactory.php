<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomCustomerId = Customer::inRandomOrder()->first()->id;

        return [
            'invoice_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'customer_id' => $randomCustomerId,
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'reference' => 'REF-'.rand(10,500),
            'terms_conditions' => $this->faker->paragraph(2),
            'sub_total' => $this->faker->numberBetween(100, 1000),
            'discount' => $this->faker->numberBetween(10, 50),
            'total' => $this->faker->numberBetween(20, 2000),
            'status' => $this->faker->randomElement(['paid', 'unpaid', 'partially_paid']),
        ];
    }
}
