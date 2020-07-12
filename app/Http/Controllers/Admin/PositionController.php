<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Position;
use DataTables;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $position="";
        if($request->query('edit')){
            $position = Position::findOrFail($request->query('edit'));
        }
        return view('pages.position.index', compact('position'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.position.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = "";
        try {
            if(!empty($request->id))
            {
                $message = "Edit";
                $position = Position::findOrFail($request->id);
                $position->update([
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
            }
            else
            {
                $message = "Add";
                $position = Position::create([
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
            }

            \Session::flash('success.message', 'Success to '.$message);
           return redirect('position');

        } catch(\Exception $e) {
        	\Session::flash('error.message', 'Failed to '.$message);
            return redirect('position');
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
        $delete = Position::findOrFail($id);
        $delete->delete();

        \Session::flash('success.message', trans("Success To Delete"));

        return redirect()->back();
    }
    public function getdata()
    {
    	$position = Position::all();
        return Datatables::of($position)

            ->addColumn('action',  function ($position) {

            	$action = '<div class="btn-group"> <a href="position?edit='.$position->id.'" data-toggle="tooltip" title="Update" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                <a href="position/delete/'.$position->id.'"  data-id="'.$position->id.'" title="Delete" class="sa-remove btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></div>';

                return $action;
            })

            ->rawColumns(['action'])
            ->make(true);

    }
}
