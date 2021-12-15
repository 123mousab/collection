<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostTagsController extends Controller
{
    public function addTagsForPost($postId)
    {
        $post = Post::find($postId);


        $tagIds = $this->declarativeNormalizeTagsTolds(\request('tags'));

        $post->tags()->sync($tagIds);
        return $post->load('tags');
    }

    // imperative programming
    private function imperativeNormalizeTagsTolds($tags)
    {
        $tagIds = [];

        foreach ($tags as $nameOrId)
        {
            if (is_numeric($nameOrId)){
                $tagIds[] = $nameOrId;
            }else{
                $tag = Tag::create(['name' => $nameOrId]);
                $tagIds[] = $tag->id;
            }
        }

        return $tagIds;
    }

    // Declarative Programming
    private function declarativeNormalizeTagsTolds($tags)
    {
        return collect($tags)->map(function ($nameOrId){
           return $this->normalizeTagToTold($nameOrId);
        });
    }

    private function normalizeTagToTold($nameOrId)
    {
        if (is_numeric($nameOrId)){
            return $nameOrId;
        }

        $tag = Tag::create(['name' => $nameOrId]);
        return $tag->id;
    }
}
