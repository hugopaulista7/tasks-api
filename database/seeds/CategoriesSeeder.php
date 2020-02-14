<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Importante'
            ],
            [
                'name' => 'Secundária'
            ],
            [
                'name' => 'Talvez'
            ]
        ];

        foreach($data as $item) {
            $category = (new Category)->fill($item);

            $category->save();
        }
    }
}
