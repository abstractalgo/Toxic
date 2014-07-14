<?php

class ArchiveController extends Controller {

    private static $perPage = 5;

    public function run()
    {
        Model::Load('Post');

        // ----------------------------------------------------------------------
        // ----------------------------------------------------------------------
        // ----------------------------------------------------------------------

        $page = isset(Request::GET()['page'])
                ? (int)Request::GET('page')-1
                : 0;
        $posts = Post::Page($page);

        // ----------------------------------------------------------------------
        // ----------------------------------------------------------------------
        // ----------------------------------------------------------------------


        Template::load('basic')
            ->title("Archive")
            ->header
            (
                Template::Load('header')
                    ->postPage(false)
                    ->get()
            )
            ->content
            (
                Template::load('list_posts')
                    ->posts($posts)
                    ->get()
            )
            ->render();
    }

    public static function kapitalizuj($str)
    {
        return ucfirst($str).'*^&%*$';
    }
}