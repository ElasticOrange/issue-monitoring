<?php

namespace Issue\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Issue\Document;
use Issue\UploadedFile;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('frontend.partials.user', function($view)
        {
            $view->with('user', Auth::user()); 
        });

        Document::deleted(function($document)
        {
            $fileToDelete = UploadedFile::where('id', '=', $document['uploaded_file_id'])->get();
            $fileToDelete = $fileToDelete[0]['file_name'];
            File::delete(storage_path().'/documents/'.$fileToDelete);

            $document->file()->delete();
            return true;
        });
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
