<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $comments = [
            [
                'id' => 1,
                'product_id' => 1,
                'customer_id' => 1,
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'created_at' => DB::raw("NOW()")
            ],
            [
                'id' => 2,
                'product_id' => 1,
                'customer_id' => 2,
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'created_at' => DB::raw("NOW()")
            ],[
                'id' => 3,
                'product_id' => 1,
                'customer_id' => 3,
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'created_at' => DB::raw("NOW()")
            ],[
                'id' => 4,
                'product_id' => 1,
                'customer_id' => 4,
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'created_at' => DB::raw("NOW()")
            ],[
                'id' => 5,
                'product_id' => 2,
                'customer_id' => 2,
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'created_at' => DB::raw("NOW()")
            ],
            [
                'id' => 6,
                'product_id' => 3,
                'customer_id' => 3,
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'created_at' => DB::raw("NOW()")
            ],[
                'id' => 7,
                'product_id' => 4,
                'customer_id' => 3,
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'created_at' => DB::raw("NOW()")
            ],[
                'id' => 8,
                'product_id' => 5,
                'customer_id' => 4,
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'created_at' => DB::raw("NOW()")
            ]

        ];

        DB::table('comments')->insert($comments);

        $ratings = [];

        for($i = 1; $i <= 20; $i++) {
            foreach ($comments as $c) {
                $ratings[] =  [
                    'comment_id' => $c['id'],
                    'mark' => mt_rand(1,5)
                ];
            }
        }

        DB::table('ratings')->insert($ratings);

    }
}
