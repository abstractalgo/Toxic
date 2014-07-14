<?php

class Tag extends Model
{
    protected static $table = 'aa_tags';
    protected static $map = array
                            (
                                'post_id'   => 'post_id',
                                'tag'       => 'tag',
                            );
    public $post_id;
    public $tag;

    public static function GetFor($id)
    {
        $res = self::Query("SELECT * FROM ".self::$table." WHERE post_id=".$id);
        $result = array();
        foreach($res as $item)
        {
            $result[] = $item->tag;
        }
        return $result;
    }
}

class Post extends Model
{
    protected static $table = 'aa_post';
    protected static $map = array
                            (
                                'id'    => 'id',
                                'title' => 'title',
                                'link'  => 'link_title',
                                'text'  => 'fulltext',
                                'date'  => 'timestamp',
                            );

    public $id;
    public $title;
    public $link;
    public $text;
    public $date;

    public $tags;
    public $userVoted;
    public $votes;
    public $comments;

    public function __construct()
    {
        $this->tags         = "none tag";
        $this->userVoted    = false;
        $this->votes        = 0;
        $this->comments     = 0;
    }

    public static function Recent($num)
    {
        return self::Query("SELECT * FROM ".self::$table . " ORDER BY timestamp DESC");
    }

    public static function GetByTitle($title)
    {
        return self::Query("SELECT * FROM ".self::$table . " WHERE link_title='".$title."'")[0];
    }

    public static function Page($pg)
    {
        $perage = 2;
        return self::Query("SELECT * FROM ".self::$table . " ORDER BY timestamp DESC LIMIT ". ($pg*$perage).', '.$perage);
    }

    public static function transform($text)
    {
        $text = preg_replace("/######\s*([^\n]+)/", "<h6>$1</h6>\n", $text);
        $text = preg_replace("/#####\s*([^\n]+)/", "<h5>$1</h5>\n", $text);
        $text = preg_replace("/####\s*([^\n]+)/", "<h4>$1</h4>\n", $text);
        $text = preg_replace("/###\s*([^\n]+)/", "<h3>$1</h3>\n", $text);
        $text = preg_replace("/##\s*([^\n]+)/", "<h2>$1</h2>\n", $text);
        $text = preg_replace("/#\s*([^\n]+)/", "<h1>$1</h1>\n", $text);
        $text = preg_replace("/(\n|^)([^\n]+)(\n\n|$)/","\n<p>$2</p>\n",$text);
        
        $text = preg_replace("/\-{3}/", '<div class="hr"><span class="hrleft"></span><span class="hrright"></span></div>', $text);
        // $text = preg_replace("/\n/", '<br>', $text);

        return $text;
    }

    public function GetDate()
    {
        $date = new DateTime($this->date);
        return $date->format('d M, Y');
    }

    public function GetTags()
    {
        return join(', ', Tag::GetFor($this->id));
    }

    public function __toString()
    {
        return '['.$this->id.'] '.$this->title.' was written on '.$this->date;
    }
}