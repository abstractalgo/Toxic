<?php

class IndexController extends Controller {

    public function run()
    {
        Model::Load('Post');

        // ----------------------------------------------------------------------
        // ----------------------------------------------------------------------
        // ----------------------------------------------------------------------

        // Post::Recent(5);

        // ----------------------------------------------------------------------
        // ----------------------------------------------------------------------
        // ----------------------------------------------------------------------


        Template::load('basic')
            ->title("Home")
            ->header
            (
                Template::Load('header')
                    ->postPage(false)
                    ->get()
            )
            ->content
            (
                Template::load('home')
                    ->get()
            )
            ->script
            (
                '<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>'
                ."\n".
                '<script type="text/javascript" src="'.JS_DIR.'/myCode.js"></script>'
            )
            ->render();
    }
}