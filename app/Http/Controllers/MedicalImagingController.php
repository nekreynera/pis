<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DirectoryIterator;
use FilesystemIterator;
use App\MedicalImaging;
use Session;
use DB;
use Auth;


class MedicalImagingController extends Controller
{

    

    public function medical_imaging()
    {
        return view('doctors.medical_images');
    }


    public function medical_img(Request $request)
    {

        define("IMAGE_TEMPLATE_TABLE", "image_templates");
        define("CLINICS_TABLE", "clinics");

        $post = json_decode($_POST['post']);

        switch ($post->flag) {
            case 'clinic_count':

                $path = "./img/clinic";
                $dir = new DirectoryIterator($path);
                $imgFolder = "";
                foreach ($dir as $folderInfo) {
                    if ($folderInfo->isDir() && !$folderInfo->isDot()) {
                        $imgFolder .= $folderInfo->getFilename() . "|";
                    }
                }

                $imgFolder = substr($imgFolder, 0, strlen($imgFolder) -1);
                $folders = json_encode(explode("|", $imgFolder));

                echo $folders;
                break;

            case 'clinic_image':

                $path = "./img/clinic/" . $post->filename;
                $img = file_get_contents($path);
                echo base64_encode($img);
                break;

            case 'gallery_count':
                $path = "./img/clinic/".$post->category."/";
                $files = new FilesystemIterator($path);
                $imgFiles = "";
                foreach ($files as $fileinfo) {
                    if ($fileinfo->isFile() && !$fileinfo->isDir()) {
                        $imgFiles .= $fileinfo->getFilename() . "|";
                    }
                }

                $imgFiles = substr($imgFiles, 0, strlen($imgFiles) -1);
                $files = json_encode(explode("|", $imgFiles));

                echo $files;
                break;

            case 'gallery_thumbnail_image':
                $path = "./img/clinic/".$post->category."/thumbs/" . $post->filename;
                $img = "";
                if(!file_exists($path)){
                    // Create the thumbnail.
                    if(MedicalImaging::createThumbnail($post->category, $post->filename)){
                        $img = file_get_contents($path);
                    }else{
                        // Draw a "Not Found" image.
                        $img = "Blang";
                    }
                }else{
                    $img = file_get_contents($path);
                }

                $file = base64_encode($img);
                echo $file;
                break;

            case 'gallery_display_image':

                $path = "./img/clinic/" . $post->path;
                $img = file_get_contents($path);
                echo base64_encode($img);
                break;

            case 'patient_id':
                $dsa = $request->session()->get('pid');
                echo json_encode(array('patient_id'=>$dsa)); 
                break;

            case 'save_template':

                // Check whether the patient has an existing record in the current cateogry/clinic,
                // if none, insert a new record, otherwise, update the existing record.
                $template = DB::table(IMAGE_TEMPLATE_TABLE)->where([
                                                                    ['patient_id', '=', $request->session()->get('pid')], 
                                                                    ['clinic', '=', $post->clinic]
                                                                ])->get();
                
                if(count($template)){
                    // Patient has an existing template record.
                    $result = DB::table(IMAGE_TEMPLATE_TABLE)->where([
                                                                ['patient_id', '=', $request->session()->get('pid')], 
                                                                ['clinic', '=', $post->clinic]
                                                            ])->update(array('template'=>$post->template));
                }else{
                    // Patient does not have an existing template record.
                    $result = DB::table(IMAGE_TEMPLATE_TABLE)->insert([
                                                                        'patient_id'=>$request->session()->get('pid'), 
                                                                        'clinic'=>$post->clinic, 
                                                                        'template'=>$post->template
                                                                    ]);
                }


                If(!$result){
                    // echo 'Saving/updating image template failed.';
                    // echo $post->clinic;
                    echo count($template);
                }else{
                    echo $result;
                }
                break;

            case 'get_template':
                $template = DB::table(IMAGE_TEMPLATE_TABLE)->where([
                                                                        ['patient_id', '=', $request->session()->get('pid')],
                                                                        ['clinic', '=', $post->clinic]
                                                                    ])->pluck('template')->first();
                
                
                // echo $post->clinic;
                if($template){
                    echo $template;
                }else{
                    // echo 'Image template retrieval failed.';
                    echo $post->clinic;
                }
                break;

            case 'get_clinic':

                // echo  Auth::user()->clinic;
                $clinic = DB::table(CLINICS_TABLE)->where('id', Auth::user()->clinic)->pluck('folder')->first();
                if($clinic){
                    echo $clinic;
                }else{
                    echo "Failed to determine the current clinic for this session.";
                }

                break;

            default:
                break;

        } // End switch()

    } // End medical_img




}
