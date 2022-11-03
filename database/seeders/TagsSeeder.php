<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tags;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tags::insert(array(
            ['name_tags' => 'Открыто', 'type_tags' => 'status', 'notif_text' => 'Статус тикета открыто'],
            ['name_tags' => 'Закрыто', 'type_tags' => 'status', 'notif_text' => 'Статус тикета закрыто'],
            ['name_tags' => 'В работе', 'type_tags' => 'status', 'notif_text' => 'Статус тикета в работе'],
            ['name_tags' => 'Ожидает ответа', 'type_tags' => 'status', 'notif_text' => 'Статус тикета ожидание ответа'],
        )

        );
    }
}
