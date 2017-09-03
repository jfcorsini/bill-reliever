<?php

use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfPayments = config('seeder.payments');
        factory(App\Payment\Payment::class, $numberOfPayments)->create()->each(function ($property) {
            $property->save(factory(App\Payment\Payment::class)->make()->toArray());
        });
    }
}
