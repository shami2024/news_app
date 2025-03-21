<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class CommentResource extends JsonResource
{

   
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
            'user_id' => $this->user_id,
            'post_id' => $this->post_id,
            'content' => $this->content,
            'created_at' => $formattedDate,
            'user' => $this->user,
 
        ];

    }
}
