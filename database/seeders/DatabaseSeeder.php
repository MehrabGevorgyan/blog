<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Post_Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //create my account admin => user 1      
        DB::table('users')->insert([
            'name' => 'mehrab',
            'email' => 'mehrabgevorgyan@gmail.com',
            'avatar' => 'images/mehrab.jpg',
            'password' => '$2y$10$WyXSMTepR6w.PC8jFH6JKODzCKYBDXRvmVyYeq0FGLweT2n1AomEu',
            'remember_token' => 'mehrab',
            'created_at' => '1995-12-19 12:00:00',
            'updated_at' => '1995-12-19 12:00:00',
        ]);

        // create tags table
        DB::table('tags')->insert([
            ['name' => 'sport'],
            ['name' => 'programming'],
            ['name' => 'art'],
            ['name' => 'gaming'],
            ['name' => 'other'],
            ['name' => 'no-tag'],
        ]);

        // my 1 post
        DB::table('posts')->insert([
            'user_id' => 1,
            'likes' => 0,
            'views' => 0,
            'dislikes' => 0,
            'title' => 'My first blog in laravel (8.75)',
            'desc' => 'Hi, this is my first blog in the PHP framework Laravel. I worked on this project for about a week. I did everything that was implemented on my own using my knowledge and the Internet.
             The project implemented registration, authentication, authorization, validation, pagination (not completely), a mechanism for migrations, seeders and factories, working with the file system and more. To do this, I used a resource controller, request classes, middlewares, eloquent relationships, jQuery (ajax), gates, and more.
              At the end of the work, I corrected all the errors and inaccuracies in the code. I hope there are no more of them left.
               Thank you for your attention!!! 
              P.S. At the end, I was tired and fell asleep 
                 ',
            'post_img' => 'images/hello.jpg',
            'created_at' => '2025-12-19 00:00:00',
            'updated_at' => '1995-12-19 00:00:00',

        ]);

        DB::table('post_tag')->insert([
            ['post_id' => 1,'tag_id' => 2],
        ]); 

        
        \App\Models\User::factory(9)->create();
        \App\Models\Post::factory(29)->create();
        \App\Models\Comment::factory(100)->create();

        // role 1 admin
        DB::table('roles')->insert([
            'name' => 'admin',
        ]);

        // add user 1 => admin
        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]); 

        // add random tags by all posts
        $tags = ['sport','programming','art','other','gaming','no-tag'];
        for ($i = 2; $i < 31; $i++) {

            $count = rand(0,5);
            if($count == 0){
                DB::table('post_tag')->insert([
                    ['post_id' => $i,'tag_id' => 6],
                ]);
                continue;
            }

            for ($j = 1; $j < $count + 1; $j++) { 
                DB::table('post_tag')->insert([
                    ['post_id' => $i,'tag_id' => $j],
                ]);                
            }
        }
    }
}
