<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = App::getLocale();

        // Format date based on locale
        if ($locale === 'ar') {
            $formattedDate = Carbon::parse($this->created_at)->locale('ar')->translatedFormat('d F Y h:i A');
        } else {
            $formattedDate = Carbon::parse($this->created_at)->locale('en')->translatedFormat('F d, Y h:i A');
        }
        return [
            'id' => $this->id,
            // 'author_id' => $this->author_id,
            // 'category_id' => $this->category_id,
            // 'category' => $this->category ? [
            //     'id' => $this->category->id,
            //     'name' => $this->category->name
            // ] : null, // Ensure category is returned correctly
            'title' => $this->title ?? '',
            'seo_title' => $this->seo_title ?? '',
            'excerpt' => $this->excerpt ?? '',
            'body' => $this->body ?? '',
            'image' => asset('storage/' . $this->image) ?? '', 
            'slug' => $this->slug ?? '',
            'meta_description' => $this->meta_description ?? '',
            'meta_keywords' => $this->meta_keywords ?? '',
            'likes_count' => $this->likes_count,
            'if_user_like' =>auth()->user() ? auth()->user()->hasLikedPost($this->id) : false,
            'comments_count' => $this->comments_count,
            'shares_count' => $this->shares_count,

            'featured' => $this->featured ?? '',
            'interests' => $this->interests ?? [],
            
            'created_at' => $formattedDate ?? '', // Locale-based formatted date 
            'category' => $this->category ? new CategoryResource($this->category) : [],
            'redaction' => $this->redaction ? new RedactionResource($this->redaction) : [],
            'comments' => $this->comments ? CommentResource::collection($this->comments) : [],


            
        ];
    }
}
