<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photographer;
use App\Album;


// removed all unwantwed methods such as create(), store(), destroy()
class PhotographerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return "I will be use to fetch all photographers";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPhotographerById($photographer_id)
    {

        // fetch photographer details from photographers table
        $photographer = Photographer::find($photographer_id);

        if ($photographer['name'] == null) {
            return response()->json(['message' => 'invalid photographer id given'], 200);
        }

        // fetching albums for specific photographer
        $photographer_album = Album::where('photographer_id', $photographer_id)->get();

        $album_array = array();
        // to exclude unwanted album table property from the response amd format the response as per requirement
        foreach ($photographer_album as $item) {
            array_push($album_array, ['id' => $item['id'], 'title' => $item['title'], 'description' => $item['description'], 'img' => $item['img'], 'date' => date('Y-m-d', strtotime($item['created_at'])), 'featured' => $item['featured'] ? true : false]);
        }
        
        return response()->json([ 'name'=> $photographer['name'], 'phone' => $photographer['phone'], 'email' => $photographer['email'], 'bio' => $photographer['bio'], 'profile_picture' => $photographer['profile_picture'], 'album' => $album_array], 200);
    }

}
