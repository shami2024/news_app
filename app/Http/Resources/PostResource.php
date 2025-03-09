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
            'author_id' => $this->author_id,
            'category_id' => $this->category_id,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name
            ] : null, // Ensure category is returned correctly
            'title' => $this->title,
            'seo_title' => $this->seo_title,
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'image' => $this->image,
            'slug' => $this->slug,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            // 'status' => $this->status,
            'featured' => $this->featured,
            'created_at' => $formattedDate, // Locale-based formatted date
        ];
    }
}
