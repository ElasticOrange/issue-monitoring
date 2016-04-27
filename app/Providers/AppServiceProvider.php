<?php

namespace Issue\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Issue\Document;
use Issue\Domain;
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
        view()->composer('frontend.layout.header', function($view)
        {
            $view->with('user', Auth::user());
        });

        view()->composer('frontend.partials.domainsTree', function($view)
        {
            $domains = Domain::getCurrentDomains();
            $tree = Domain::getTree(Domain::getDomainsForTree($domains));

            $view->with([
                  'tree' => $tree,
                  'domains' => $tree[1]['subdomains']
              ]);
        });

        view()->composer('frontend.partials.domainsTreeForReports', function($view)
        {
            $domains = Domain::getCurrentDomains();
            $tree = Domain::getTree(Domain::getDomainsForTree($domains));

            $view->with([
                  'tree' => $tree,
                  'domains' => $tree[1]['subdomains']
              ]);
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
