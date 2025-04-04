<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Keyword; // Import the Keyword model
use App\Models\News;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $news = DB::connection('mysql2')->table('processed_news_table')->where('fetched', 0)->get();
        $images =  DB::connection('mysql2')->table('news_images_table')->join('processed_news_table', 'processed_news_table.original_news_id', '=', 'news_images_table.image_id', 'inner')->where('processed_news_table.fetched', 0)->select('news_images_table.url', 'processed_news_table.news_id')->get();

        foreach ($news as $data) {
            // Create news entry
            $entry = News::create([
                'category_id' => $data->category ? Category::firstOrCreate(['name' => $data->category])->id : Category::first()->id,
                'url' => $data->url,
                'soruce' => $data->source,
                'title' => $data->title_en,
                'summary' => $data->summary_en,
                'comment_neutral' => $data->comment_neutral_en,
                'comment_left' => $data->comment_left_en,
                'comment_right' => $data->comment_right_en,
                'location_country' => $data->location_country,
                'location_region' => $data->location_region,
                'key_figures' => $data->key_figures,
                'credibility_score' => $data->credibility_score,
                'importance_score' => $data->importance_score,
                'timeliness_score' => $data->timeliness_score,
                'credibility_explanation' => $data->credibility_explanation,
                'media_bias' => $data->media_bias,
                'processed_timestamp' => $data->processed_timestamp,
                'locale' => 'en'
            ]);

            // Add translations for 'cn' locale
            $entry->addTranslation(locale: 'cn', data: [
                'title' => $data->title_cn,
                'summary' => $data->summary_cn,
                'comment_neutral' => $data->comment_neutral_cn,
                'comment_left' => $data->comment_left_cn,
                'comment_right' => $data->comment_right_cn,
            ]);

            // Process and attach keywords to the news
            $keywords = explode(',', $data->keywords); // Split the keywords by commas
            foreach ($keywords as $keywordName) {
                $keywordName = trim($keywordName); // Remove extra spaces
                if (!empty($keywordName)) {
                    // Find or create the keyword
                    $keyword = Keyword::firstOrCreate(['name' => $keywordName]);
                    // Attach the keyword to the news (avoiding duplication by using syncWithoutDetaching)
                    $entry->keywords()->syncWithoutDetaching($keyword->id);
                }
            }

            // Add comments
            if ($entry->comment_neutral) {
                $comment = Comment::create([
                    'user_id' => User::where('role', 'critic')->where('username', 'neutral')->first()->id,
                    'news_id' => $entry->id,
                    'comment' => $data->comment_neutral_en,
                    'score' => 13
                ]);
                $comment->addTranslation(locale: 'cn', data: [
                    'comment' => $data->comment_neutral_cn,
                ]);
            }

            if ($entry->comment_right) {
                $comment = Comment::create([
                    'user_id' => User::where('role', 'critic')->where('username', 'right')->first()->id,
                    'news_id' => $entry->id,
                    'comment' => $data->comment_right_en,
                    'score' => 12
                ]);
                $comment->addTranslation(locale: 'cn', data: [
                    'comment' => $data->comment_right_cn,
                ]);
            }

            if ($entry->comment_left) {
                $comment = Comment::create([
                    'user_id' => User::where('role', 'critic')->where('username', 'left')->first()->id,
                    'news_id' => $entry->id,
                    'comment' => $data->comment_left_en,
                    'score' => 11
                ]);
                $comment->addTranslation(locale: 'cn', data: [
                    'comment' => $data->comment_left_cn,
                ]);
            }

            // Mark the news entry as fetched
            DB::connection('mysql2')->table('processed_news_table')
                ->where('news_id', $data->news_id)
                ->update(['fetched' => 1]);
        }

        // Process images
        foreach ($images as $image) {
            News::find($image->news_id)->images()->create(['url' =>  $image->url]);
        }
    }
}
