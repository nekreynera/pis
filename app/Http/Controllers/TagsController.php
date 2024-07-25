<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Clinic;

class TagsController extends Controller
{

    public function store($cid, $clinic)
    {
        $checkIfAlreadyInserted = Tag::where('consultations_id', '=', $cid)
                                        ->where('clinic', '=', $clinic)->count();
        if ($checkIfAlreadyInserted > 0){
            return redirect()->back()->with('toaster', array('error', 'Consultation already tagged to this clinic'));
        }else{
            $tag = new Tag();
            $tag->consultations_id = $cid;
            $tag->clinic = $clinic;
            $tag->save();
            return redirect()->back()->with('toaster', array('success', 'Consultation succesfully tagged'));
        }
    }


}
