<?php

namespace App\Http\Controllers;

use App\GDriveFile;
use App\GDriveService;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class GDriveFileController extends Controller
{
    /**
     * @var \App\GDriveService
     */
    private $gdrive;

    public function __construct(GDriveService $gdrive)
    {
        $this->gdrive = $gdrive;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Auth::user()->files;

        return view('gdrive.index', compact('files'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCommentsByFileId(Request $request)
    {
        $this->validate($request, [
            'fileId' => 'required|min:3',
        ]);

        $fileId = $request->get('fileId');

        if ($request->get('save')) {
            $user = Auth::user();

            $gdriveFile = GDriveFile::firstOrNew(['id' => $fileId]);

            $gdriveFile->id = $fileId;

            $gdriveFile->name = $request->get('fileName', $fileId);

            $user->files()->save($gdriveFile);
        }

        return redirect()->action('GDriveFileController@show', [$fileId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = $this->gdrive->getCommentsByFileId($id);

        return view('gdrive.file', compact('file'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file = GDriveFile::findOrFail($id);

        $this->authorize('update', $file);

        return view('gdrive.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $file = GDriveFile::findOrFail($id);

        $this->authorize('update', $file);

        $name = trim($request->get('fileName'));

        if (empty($name)) {
            $name = $id;
        }

        $file->name = $name;

        $file->save();

        return redirect('gdrive')->with('status', 'File has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = GDriveFile::findOrFail($id);

        $this->authorize('destroy', $file);

        $file->delete();

        return redirect('gdrive')->with('status', 'File has been un-saved');

    }

}
