<?php

namespace App\Http\Controllers\player;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


use App\Models\Songs;

class SongsController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->hasPermissionTo('RETRIVERED_SONGS'));

        $songs = Songs::with(['genres' ,"artist" ,"posterImage" ,"backgroundImage" ,"album" ])->simplePaginate();
        
        return response()->json($songs);
    }
    public function create (Request $request)
    {
        $disk = 'songs';

        Gate::allowIf(fn (User $user) => $user->hasPermissionTo('CREATE_SONG'));

        $validatedData = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'release_date' => ['required', 'date'],
            'description' => ['required' ,'string'],
            'artist_id' => ['required' ,'integer'],
            'genre_id' => ['required' ,'integer'],
            'album_id' => ['integer'],
            "album_poster" => ["required" , File::image() ] ,
            "album_background" => [File::image() ] ,
            "song_file" =>[File::types(['mp3', 'wav'])],
            'duration'=>['required' , 'date_format:h:i']
        ]);
        if ($validatedData->fails()) {
        
            return response()->json($validatedData->errors());
            
        }
        $file =$request->file('album_poster');
        $filename = $file->getClientOriginalName();
        $imageName= time() .'_' . $request->name . '_' . $filename;
        $file_path =$file->storeAs('albums', $imageName, $disk);
        $image_album_poster = Image::create([
            "file_name" =>$filename,
            "url" =>Storage::disk( $disk)->url($file_path),
        ]);
        if($request->file('album_background')){
            $file_background =$request->file('album_background');
            $filename_background = $file_background->getClientOriginalName();
            $imageName_background= time() .'_' . $request->name . '_' . $filename_background;
            $file_path_background =$file_background->storeAs('albums', $imageName_background, $disk);
            $album_background = Image::create([
                "file_name" =>$filename_background,
                "url" =>Storage::disk($disk)->url($file_path_background),
            ]);
        }
        $song_file =$request->file('song_file');
        $file_song_name = $file->getClientOriginalName();
        $song_name= time() .'_' . $request->name . '_' . $file_song_name;
        $song_file_path =$song_file->storeAs('songs', $song_name, $disk);

        $song =Albums::create([
            "name"=>$request->name,
            "release_date" => $request->release_date,
            "artist_id"=>$request->artist_id,
            "genre_id"=>$request->genre_id,
            'album_id' => $request->album_id ? $request->album_id: null,
            "url"=>Storage::disk( $disk)->url($song_file_path) ,
            'duration'=>$request->duration,
        ]);

        return response()->json(["message"=>"successfully created"]);

    }
    public function view(Request $request)
    {
        Gate::allowIf(fn (User $user) => $user->hasPermissionTo('RETRIVERED_SONG'));
        $song =Songs::with('genres' ,'artist' ,'album' ,'posterImage' ,'backgroundImage' )->find($request->id);
        return response()->json($song);
    }
    public function deletePermanently (Request $request)
    {
        Gate::allowIf(fn (User $user) => $user->hasPermissionTo('DELETE_SONG'));
        $song =Songs::where('id', $request->id)->delete();
        return response()->json(["message"=>"successfully deleted"]);
    }
}
