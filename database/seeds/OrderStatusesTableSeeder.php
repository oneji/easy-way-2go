<?php

use App\Language;
use App\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $langs = Language::all();

        $orderStatuses = [
            [ 'name' => 'Future', 'code' => 'future', ],
            [ 'name' => 'Start trip', 'code' => 'start', ],
            [ 'name' => 'Loading', 'code' => 'loading', ],
            [ 'name' => 'On the way', 'code' => 'on_the_way', ],
            [ 'name' => 'Load/unload', 'code' => 'load_unload', ],
            [ 'name' => 'Finish 1/2 of the trip', 'code' => 'finish_half', ],
            [ 'name' => 'Finish trip', 'code' => 'finish', ],
            [ 'name' => 'Finished', 'code' => 'finished', ],
            [ 'name' => 'Cancelled', 'code' => 'cancelled', ],
        ];

        foreach ($orderStatuses as $status) {
            $newStatus = new OrderStatus();
            foreach ($langs as $lang) {
                $newStatus->setTranslation('name', $lang->code, $status['name']);
            }
            $newStatus->code = $status['code'];
            $newStatus->save();
        }
    }
}
