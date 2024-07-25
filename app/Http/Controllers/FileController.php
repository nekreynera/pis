<?php

namespace App\Http\Controllers;
use App\FileManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Patient;
use Validator;
use Carbon;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filemanager' => 'required|mimes:jpeg,jpg,png,bmp,pdf,gif,svg,doc,docx,txt,xlsx,xls,pdf,ppt,pptx',
        ]);
        if ($validator->passes()){
            if ($request->has('editCID') && !empty($request->editCID)) {
                $pid = $request->editCID;
            }else{
                $pid = $request->session()->get('pid');
            }
            $patient = Patient::find($pid);
            $random = random_int(000001, 600000);
            $directory = 'EVRMC-'.$pid.'-'.$patient->last_name;
            $filename = time().'.'.$request->filemanager->getClientOriginalExtension();
            $filepath1 = $request->filemanager->move('C:/xampp/htdocs/PatientFiles/'.$directory.'/', $filename);
            $filepath = '/PatientFiles/'.$directory.'/'.$filename;
            $filesize = $request->filemanager->getClientSize() / 1000;
            $filetype = $request->filemanager->getClientMimeType();
            $uploadDate = Carbon::now()->format('jS \o\f F, Y');
            $extension = $request->filemanager->getClientOriginalExtension();
            return response()->json(['filename'=>$filename,'filesize'=>$filesize,'filetype'=>$filetype,
                                    'filepath'=>$filepath,'uploadDate'=>$uploadDate,'extension'=>strtolower($extension),
                                    'random'=>$random]);
        }else{
            return response()->json(['uploadError'=>'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deletefile(Request $request, $file, $pd)
    {
        if (!empty($pd) && $pd != 0) {
            $pid = $pd;
        }else{
            $pid = $request->session()->get('pid');
        }
        $patient = Patient::find($pid);
        $deletefile = 'C:\xampp\htdocs\PatientFiles/EVRMC-'.$pid.'-'.$patient->last_name.'/'.$file;
        unlink($deletefile);
        FileManager::where('filename', '=', $file)->delete();
        return;
    }



    public function removefile(Request $request, $id = false)
    {
        $patient = Patient::find($request->session()->get('pid'));
        $file = FileManager::find($id);
        $deletefile = 'C:\xampp\htdocs\PatientFiles/EVRMC-'.$patient->id.'-'.$patient->last_name.'/'.$file->filename;
        if (file_exists($deletefile)){
            unlink($deletefile);
        }
        FileManager::where('id', $id)->delete();
        Session::flash('toaster', array('error','File deleted.'));
        return redirect()->back();
    }


}
