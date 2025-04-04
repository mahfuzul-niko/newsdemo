<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\News;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(100)->create();

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);
        User::create([
            'name' => fake()->name(),
            'username' => 'neutral',
            'role' => 'critic',
            'email' => 'neutral@critic.com',
            'password' => Hash::make('password'),
            'avatar' => asset('assets/neutral.webp'),
        ]);
        User::create([
            'name' => fake()->name(),
            'username' => 'right',
            'role' => 'critic',
            'email' => 'right@critic.com',
            'password' => Hash::make('password'),
            'avatar' => asset('assets/right.webp'),
        ]);
        User::create([
            'name' => fake()->name(),
            'username' => 'left',
            'role' => 'critic',
            'email' => 'left@critic.com',
            'password' => Hash::make('password'),
            'avatar' => asset('assets/left.webp'),
        ]);

        // $news = DB::connection('mysql2')->table('processed_news_table')->get();
        // $images =  DB::connection('mysql2')->table('news_images_table')->join('processed_news_table', 'processed_news_table.original_news_id', '=', 'news_images_table.image_id', 'inner')->select('news_images_table.url', 'processed_news_table.news_id')->get();

        // foreach ($news as $data) {
        //     $entry =  News::create([
        //         'category_id' =>  $data->category ? Category::firstOrCreate(['name' => $data->category])->id : Category::first()->id,
        //         'url' => $data->url,
        //         'soruce' => $data->source,
        //         'title' => $data->title_en,
        //         'summary' => $data->summary_en,
        //         'comment_neutral' => $data->comment_neutral_en,
        //         'comment_left' => $data->comment_left_en,
        //         'comment_right' => $data->comment_right_en,
        //         'location_country' => $data->location_country,
        //         'location_region' => $data->location_region,
        //         'key_figures' => $data->key_figures,
        //         'keywords' => $data->keywords,
        //         'credibility_score' => $data->credibility_score,
        //         'importance_score' => $data->importance_score,
        //         'timeliness_score' => $data->timeliness_score,
        //         'credibility_explanation' => $data->credibility_explanation,
        //         'media_bias' => $data->media_bias,
        //         'processed_timestamp' => $data->processed_timestamp,
        //         'locale' => 'en'
        //     ]);

        //     $entry->addTranslation(locale: 'cn', data: [
        //         'title' => $data->title_cn,
        //         'summary' => $data->summary_cn,
        //         'comment_neutral' => $data->comment_neutral_cn,
        //         'comment_left' => $data->comment_left_cn,
        //         'comment_right' => $data->comment_right_cn,
        //     ]);
        // }

        // foreach ($images as $image) {
        //     News::find($image->news_id)->images()->create(['url' =>  $image->url]);
        // }
        // Comment::factory(1000)->hasReplies(rand(1, 10), fn($attributes, Comment $comment) => ['news_id' => $comment->news_id])->create();

    }
}
