<?php

namespace App\Http\Controllers;

use App\File_downloads;
use App\File_purchases;
use App\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    /**
     * FilesController File Types
     * Types
     *  1   :   documents
     *  2   :   movies
     *  3   :   series
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'          =>  'required',
            'description'   =>  'required',
            'type'      =>  'required'
        ]);
        if($request->user()->hasRole('admin') || $request->user()->hasRole('shop')){
            if($request->type>1){
                $this->validate($request,[
                    'cover'=> 'required'
                ]);
                if($request->hasFile('cover')){
                    $imagemime=$request->file('cover')->getMimeType();
                    $imagemimeclient=$request->file('cover')->getClientMimeType();
                    if(!strstr($imagemime,'image') || !strstr($imagemimeclient,'image')){
                        return redirect()->back()->with('alert-danger','The cover must be an image');
                    }
                }else{
                    return redirect()->back()->with('alert-danger','Cover Image is required');
                }
            }
            if($request->hasFile('file'))
            {
                $file=new Files;
                $file->name=$request->name;
                $file->description=$request->description;
                $file->amount=$request->amount;
                $file->type=$request->type;
                $mime=$request->file('file')->getMimeType();
                $mimeclient=$request->file('file')->getClientMimeType();
                if($file->type==1) {
                    if ($mime !== 'application/x-bittorrent' || $mimeclient !== "application/x-bittorrent") {
                        return redirect()->back()->with('alert-danger', 'Only torrent files allowed');
                    }
                }
                $file->path=Storage::url($request->file('file')->store('public'));
                $file->byUser=$request->user()->id;
                if($request->type>1) {
                    $file->cover = Storage::url($request->file('cover')->store('public'));
                }
                try{
                    $file->save();
                    return redirect()->back()->with('alert-success','File Added Successfully');
                }catch (\Throwable $e){
                    return redirect()->back()->with('alert-danger','An Error Occured:'.$e->getMessage());
                }
            }
            return redirect()->back()->with('alert-danger','An Error Occurred, try again');
        }
        abort(401,'Not Authorised');
    }

    public function index(Request $request)
    {
        if($request->user()->hasRole('admin'))
        {
            return view('admin.files',['files'=>Files::all()]);
        }elseif ($request->user()->hasRole('user')){
            $files=File_purchases::with('files')
                ->where('user_id','=',$request->user()->id)
                ->get();
            return view('user.files',['files'=>$files]);
        }

    }

    public function download(Request $request,$id)
    {
        if($request->user()->hasRole('admin'))
        {
            $file=Files::find($id);
            $download=new File_downloads;
            $download->user_id=$request->user()->id;
            $download->file_id=$file->id;
            try{
                $download->save();
            }catch (\Throwable $e){

            }
            $headers=[
                'Content-Type:application/octet-stream'
            ];
            $path=$file->path;
            $path=explode('/',$path)[2];
            $name=str_replace(' ','_',Files::find($id)->name);
            $ext=explode('.',$path)[1];
            return response()->download('storage/'.$path,$name.'.'.$ext,$headers);
        }elseif ($request->user()->hasRole('user')){
            $file=Files::find($id);
            $download=new File_downloads;
            $download->user_id=$request->user()->id;
            $download->file_id=$file->id;
            if(File_purchases::where('file_id',$id)->where('user_id',$download->user_id)->count()>0){
            }else{
                return redirect()->back()->with('alert-danger','Sorry, the file has not been purchased.');
            }
            try{
                $download->save();
            }catch (\Throwable $e){

            }
            $headers=[
                'Content-Type:application/octet-stream'
            ];
            $path=$file->path;
            $path=explode('/',$path)[2];
            $name=str_replace(' ','_',Files::find($id)->name);
            $ext=explode('.',$path)[1];
            return response()->download('storage/'.$path,$name.'.'.$ext,$headers);
        }elseif ($request->user()->hasRole('shop')){
            $file=Files::find($id);
            $download=new File_downloads;
            $download->user_id=$request->user()->id;
            $download->file_id=$file->id;
            if(File_purchases::where('file_id',$id)
                    ->where('user_id',$download->user_id)->count()>0 ||
                Files::where('byUser',$request->user()->id)->where('id',$id)->count()>0){
            }else{
                return redirect()->back()->with('alert-danger','Sorry, the file has not been purchased.');
            }
            try{
                $download->save();
            }catch (\Throwable $e){

            }
            $headers=[
                'Content-Type:application/octet-stream'
            ];
            $path=$file->path;
            $path=explode('/',$path)[2];
            $name=str_replace(' ','_',Files::find($id)->name);
            $ext=explode('.',$path)[1];
            return response()->download('storage/'.$path,$name.'.'.$ext,$headers);
        }
    }

    public function about(Request $request,$id)
    {
        if($request->user()->hasRole('admin')) {
            return view('admin.fileinfo', ['file' => Files::find($id),'stats'=>File_downloads::where('file_id','=',$id)->count()]);
        }elseif($request->user()->hasRole('user')){
            return view('user.fileinfo', ['file' => Files::find($id),'stats'=>File_downloads::where('file_id','=',$id)->count()]);
        }elseif($request->user()->hasRole('shop')){
            return view('shop.fileinfo', ['file' => Files::find($id),'stats'=>File_downloads::where('file_id','=',$id)->count()]);
        }
    }

    public function list()
    {
        return view('user.filelist',['files'=>Files::all()]);
    }

    public function videos(Request $request)
    {
        if($request->user()->hasRole('admin')) {
            return view('admin.videos', ['files' => Files::where('type',2)->get()]);
        }elseif($request->user()->hasrole('user')){
            $files=File_purchases::with('files')
                ->where('user_id','=',$request->user()->id)
                ->get();
            return view('user.videos',['files'=>$files]);
        }elseif ($request->user()->hasRole('shop')){
            $files=Files::where('byUser',$request->user()->id)->where('type',2)->paginate(15);
            return view('shop.videos',['files'=>$files]);
        }
    }
    public function series(Request $request)
    {
        if($request->user()->hasRole('admin')) {
            return view('admin.series', ['files' => Files::where('type','=',3)->get()]);
        }elseif($request->user()->hasrole('user')){
            $files=File_purchases::with('files')
                ->where('user_id','=',$request->user()->id)
                ->get();
            return view('user.series',['files'=>$files]);
        }elseif ($request->user()->hasRole('shop')){
            $files=Files::where('byUser',$request->user()->id)->where('type',3)->paginate(15);
            return view('shop.series',['files'=>$files]);
        }
    }
    public function documents(Request $request)
    {
        if($request->user()->hasRole('admin')) {
            return view('admin.documents', ['files' => Files::where('type','=',1)->get()]);
        }elseif($request->user()->hasrole('user')){
            $files=File_purchases::with('files')
                ->where('user_id','=',$request->user()->id)
                ->get();
            return view('user.documents',['files'=>$files]);
        }elseif ($request->user()->hasRole('shop')){
            $files=Files::where('byUser',$request->user()->id)->where('type',1)->paginate(15);
            return view('shop.documents',['files'=>$files]);
        }
    }

    public function delete($id,Request $request)
    {
        if($request->user()->hasAnyRole(['shop','admin'])){
            $file=Files::findOrFail($id);
            try{
                $file->delete();
                return redirect()->back()->with('alert-info','File has been successfully deleted');
            }catch (\Throwable $e){
                return redirect()->back()->with('alert-danger','An error occurred');
            }
        }
    }
}
