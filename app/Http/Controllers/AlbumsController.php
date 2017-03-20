<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class AlbumsController extends Controller
{

    protected $album;

    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * Action for the list of Albums
     * 
     * @return type
     */
    public function index()
    {
        $albums = $this->album->all();

        return view('albums.index', compact('albums'));
    }

    /**
     * Action for the add new Album form
     * 
     * @return type
     */
    public function add()
    {
        $album = new Album();

        return view('albums.form', compact('album'));
    }

    /**
     * Form action for saving new Album
     * 
     * @param Request $request
     * @return type
     */
    public function store(Request $request)
    {
        $album = new Album();
        $this->validate($request, $album->getValidationRules());
        if (!$request->errors) {
            $album = $this->album->create($request->all());
            $request->session()->flash('message', 'Album data was added');
        }

        return redirect(route('album.list'));
    }

    /**
     * View action (shows Album photos)
     * 
     * @param string $id
     * @return type
     */
    public function view($id)
    {
        $album       = $this->album->findOrFail($id);
        $storagePath = Storage::disk('album_photos')
                        ->getDriver()->getAdapter()->getPathPrefix();

        return view('albums.view', compact('album', 'storagePath'));
    }

    /**
     * Action for displaying edit form
     * 
     * @param string $id
     * @return type
     */
    public function edit($id = null)
    {
        $album = $this->album->findOrFail($id);

        return view('albums.form', compact('album'));
    }

    /**
     * Form action for updating existing Album
     * 
     * @param Request $request
     * @param string $id
     * @return type
     */
    public function update(Request $request, $id = null)
    {
        $album = $this->album->findOrFail($id);
        $album->fill($request->all());
        $this->validate($request, $album->getValidationRules());
        $album->save();

        if ($request->file('photo')) {
            $this->addAlbumPhoto($request, $album->id);
        }
        $request->session()->flash('message', 'Album data was updated');

        return redirect(route('album.edit', $album->id));
    }

    /**
     * Action for Album deletion
     * 
     * @param Request $request
     * @param string $id
     * @return type
     */
    public function delete(Request $request, $id)
    {
        $album = $this->album->findOrFail($id);
        $album->delete();
        $request->session()->flash('message', 'Album was deleted');

        return redirect(route('album.list'));
    }

    /**
     * Moves uploaded photo file to storage
     * @todo Place it somewhere outside controller
     * 
     * @param UploadedFile $file
     * @return type
     * @throws \RuntimeException
     */
    protected function uploadPhotoFile(UploadedFile $file)
    {
        $storagePath = Storage::disk('album_photos')
                ->getDriver()
                ->getAdapter()
                ->getPathPrefix();
        if (!File::isWritable($storagePath)) {
            throw new \RuntimeException('Photo storage directory is not writable.');
        }
        $originalName = $file->getClientOriginalName();
        $filename     = md5($file->getClientOriginalName() . time());
        $file->move($storagePath, $filename);

        return [
            'filename'      => $filename,
            'original_name' => $originalName,
        ];
    }

    /**
     * Saves new Photo
     * @todo Place it somewhere outside controller
     * @todo Use Eloquent\relationships to create/save Photo
     * 
     * @param Request $request
     * @param string $albumId
     */
    protected function addAlbumPhoto(Request $request, $albumId)
    {
        $uploadInfo                = $this->uploadPhotoFile($request->file('photo'));
        $albumPhoto                = new Photo();
        $albumPhoto->album_id      = $albumId;
        $albumPhoto->filename      = $uploadInfo['filename'];
        $albumPhoto->original_name = $uploadInfo['original_name'];
        $albumPhoto->title         = $request->input('photo_title');
        $albumPhoto->description   = $request->input('photo_description');
        $albumPhoto->save();
    }

}
