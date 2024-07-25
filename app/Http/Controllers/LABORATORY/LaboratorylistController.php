<?php

namespace App\Http\Controllers\LABORATORY;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LaboratoryModel;
use App\LaboratorySub;
use App\LaboratorySubList;
use Auth;
use Validator;
use Response;
use DB;

class LaboratorylistController extends Controller
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
        $id = null; 
        $rules = array(
                'laboratory_sub_id' => 'required',
                'name' => 'required|unique:laboratory_sub_list',
                'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'status' => 'required',
                );

        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                $data = LaboratorySubList::create($request->all());
                $id = $data->id;
            }
        echo json_encode(['laboratory_sub_id' => $request->laboratory_sub_id, 'id' => $id]);
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo json_encode(LaboratorySubList::where('laboratory_sub_id', $id)->orderBy('name', 'ASC')->get());
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('laboratory_sub_list')
                ->leftJoin('laboratory_sub', 'laboratory_sub.id', '=', 'laboratory_sub_list.laboratory_sub_id')
                ->leftJoin('laboratory', 'laboratory.id', '=', 'laboratory_sub.laboratory_id')
                ->select('laboratory_sub.laboratory_id as lab_id', 
                        'laboratory_sub.id as sub_id',
                        'laboratory.name as cat_name',
                        'laboratory_sub.name as sub_name',
                        'laboratory_sub_list.name',
                        'laboratory_sub_list.price',
                        'laboratory_sub_list.status',
                        'laboratory_sub_list.created_at',
                        'laboratory_sub_list.updated_at')
                ->where('laboratory_sub_list.id', '=', $id)
                ->first();
        echo json_encode($data);
        return;
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
        $rules = array(
               'name' => 'required',
               'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
               'status' => 'required',
               );

        $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Response::json(array(
                    'errors' => $validator->getMessageBag()->toArray()
                ));
            }else{
                $list = LaboratorySubList::find($id);
                $list->fill($request->all());
                $list->save();
            }

        echo json_encode(['laboratory_sub_id' => $request->laboratory_sub_id, 'id' => $id]);
        return;
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
    public function search(Request $request)
    {

        echo json_encode(LaboratorySubList::search($request->list_search));
        return;
    }
}
