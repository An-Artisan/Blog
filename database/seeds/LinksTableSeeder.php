<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
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
                'link_name' => '刘强个人网站',
                'link_title' => '刘强个人的网站，用来学习，交流使用',
                'link_url' => 'http://www.joker1996.com',
                'link_order' => 1,

            ],
            ['link_name' => '刘强个人论坛',
            'link_title' => '刘强个人的论坛，用来学习，交流使用',
            'link_url' => 'http://utopia.joker1996.com',
            'link_order' => 2,

        ]
        ];
        DB::table('links')->insert($data);
//        数据填充
    }
}
