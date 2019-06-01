<?php

namespace App\Providers;

use App\Forum;
use App\Post;
use App\User;
use App\Tag;
use App\PostCategory;
use App\Discussion;
use App\DiscussionTag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
		$Global = array(
            '_tags' => Tag::class,
            '_users' => User::class,
			'_forums' => Forum::class, 
            '_posts' => Post::class,
            '_postCategories' => PostCategory::class,
            '_discussions' => Discussion::class,
		);
		View::share($Global);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
