<?php 

namespace App\Schemas;



class Query {

    const QUERY_BLOG = "SELECT * FROM post ORDER BY id DESC LIMIT ? OFFSET ?";
    const QUERY_BLOG_COUNT = "SELECT COUNT(*) FROM post";
    const QUERY_FMT_CARD_CATEGORIES = "SELECT id, name, slug from category c join post_category pc on c.id=pc.category_id where post_id=:id"; 
    const QUERY_FMT_CARD_POST = "SELECT * FROM post WHERE id=:id";
    const QUERY_USER = "SELECT * FROM user WHERE username=:username";
    const QUERY_POSTS_ADMIN =  "SELECT * FROM post";
    const QUERY_POST_EDIT = "UPDATE post SET title=:title, content=:content WHERE id=:id";
    const QUERY_POST_DELETE = "DELETE FROM post WHERE id=:id";
}