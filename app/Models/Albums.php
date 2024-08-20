<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



use App\Models\Genres;
use App\Models\Artists;
use App\Models\Image;

class Albums extends Model 
{
    use HasFactory;
    

    protected $table = "albums";
    protected $fillable = ["name" ,'release_date', 'description' ,'artist_id' ,'genre_id' ,'poster_image_id' ,'background_image_id'];
    
    public function genres()
    {
        return $this->belongsTo(Genres::class ,'genre_id');
    }
    public function posterImage()
    {
        return $this->belongsTo(Image::class ,'poster_image_id');
    }
    public function backgroundImage()
    {
        return $this->belongsTo(Image::class ,'background_image_id');
    }
    public function artists()
    {
        return $this->belongsTo(Artists::class ,'artist_id');
    }
 
}
