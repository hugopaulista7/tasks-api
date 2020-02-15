<?php

use Illuminate\Database\Seeder;

use App\Status;
class StatusTableSeeder extends Seeder
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
                'name'        => 'Arquivado',
                'description' => 'Tarefas que foram arquivadas'
            ],
            [
                'name'        => 'Ativo',
                'description' => 'Tarefas ativas'
            ]
        ];

        foreach($data as $item) {
            $status = (new Status)->fill($item);
            $status->save();
        }
    }
}
