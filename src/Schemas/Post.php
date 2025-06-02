<?php

namespace App\Schemas;

use AltoRouter;
use App\DbHandler;
use App\Router;
use DateTime;

class Post
{
    private int $id;
    private string $title;
    private string $slug;
    private string $content;
    private string $created_at;

    

    public function getExcerpt(string $content, int $limit = 100): string
    {
        if (mb_strlen($content) <= $limit) {
            return $content;
        }
        $lastSpace=mb_strpos($content, " ", $limit);
        return mb_substr($content, 0, $lastSpace);
    }


    public function formatCard(int $id, Router $router): string
    {
        $db_handler = new DbHandler();
        $parameter = ["id" => $id]; 
        $query = $db_handler->db_query(true,self::class, Query::QUERY_FMT_CARD_POST, $parameter);
        $post = $query[0];
        $get_categories = $db_handler->db_query(true, Category::class, Query::QUERY_FMT_CARD_CATEGORIES, $parameter);

        $anchors = array_map( function (Category $category) {
            return "<a class='text-decoration-none' href='#'>{$category->getName()}</a>";
        },$get_categories);

        $categories = join(" | ",$anchors);

        //protect from malicious input
        $protectedTitle = htmlentities($post->title);
        // $protectedCategories = htmlentities($categories);
        $protectedExcerpt = htmlentities($post->getExcerpt($post->content));

        $postlink = $router->getRoute('Post', ["slug"=>$post->getSlug(),"id"=>$id]);

        $card =
        "<div class='col p-0 d-flex justify-content-center'>
            <div class='card m-0' style='width: 15rem;'>
                <div class='card-body'>
                    <h5 class='card-title'>$protectedTitle</h5>
                    <h6 class='card-subtitle mb-2 text-body-secondary'>$categories</h6>
                    <p class='card-text'>$protectedExcerpt ...</p>
                    <button class='btn btn-primary'>
                        <a class='text-decoration-none text-light' href='$postlink' class='card-link'>
                            Watch post
                        </a>
                    </button>
                </div>
            </div>
        </div>
        ";

        return $card;
    }

    public static function renderCards(array $posts, Router $router): string
    {
        //We will render 12 posts per page
        $grid = '<div class="row row-cols-lg-3 row-cols-xl-4 row-cols-md-2 row-cols-sm-1 gy-5 row-cols-1">
                ';
        
        foreach ($posts as $post) {
            $grid .= $post->formatCard($post->id, $router);
        }

        $grid .= '</div>';
        return $grid;
    }



    
    public function getId(): int
    {
        return $this->id;
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }


    public function getContent(): string
    {
        return $this->content;
    }

    public function getDate(): string
    {
        $datetime = new DateTime($this->created_at);
        return $datetime->format("d F Y");
    }

    public function getCategories(): string
    {
        return 'wip';
    }

    public static function displayTable(Post $posts) {
        
    }
}
