<?php

namespace App\Http\Controllers\player;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;

use App\Models\Albums;
use App\Models\Image;
use App\Models\User;

class AlbumController extends Controller
{
    

    public function index (Request $request ,User $user)
    {
        // $this->authorize('access_user', Albums::class);
        // Gate::authorize('access_user' ,$user);
        Gate::allowIf(fn (User $user) => $user->hasPermissionTo('RETRIVERED_ALBUMS'));
        $albums =Albums::with('genres' ,'artists' ,'posterImage' ,'backgroundImage')->simplePaginate();

        return response()->json($albums);

    }
    public function create (Request $request)
    {
        Gate::allowIf(fn (User $user) => $user->hasPermissionTo('CREATE_ALBUM'));

        $disk = 'albums';
        $validatedData = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'release_date' => ['required', 'date'],
            'description' => ['required' ,'string'],
            'artist_id' => ['required' ,'integer'],
            'genre_id' => ['required' ,'integer'],
            "album_poster" => ["required" , File::image() ] ,
            "album_background" => [File::image() ] ,


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
        
        $alubm =Albums::create([
            "name"=>$request->name,
            "description"=> $request->description,
            "release_date" => $request->release_date,
            "artist_id"=>$request->artist_id,
            "genre_id"=>$request->genre_id,
            "poster_image_id" => $image_album_poster->id,
            "background_image_id" => isset($album_background) ? $album_background->id : null
        ]);
        return response()->json(["message"=>"successfully created"]);

        

    }
    public function view(Request $request)
    {

        Gate::allowIf(fn (User $user) => $user->hasPermissionTo('RETRIVERED_ALBUM'));
        $album =Albums::with('genres' ,'artists' ,'posterImage' ,'backgroundImage' ,'songs')->find($request->id);
        return response()->json($album);

    }
    public function update (Request $request)
    {
    }
    public function softDelete (Request $request)
    {
    }
    public function deletePermanently (Request $request)
    {
        Gate::allowIf(fn (User $user) => $user->hasPermissionTo('DELETE_ALBUM'));
        $albums =Albums::where('id', $request->id)->delete();
        return response()->json(["message"=>"successfully deleted"]);
    }
    
}
