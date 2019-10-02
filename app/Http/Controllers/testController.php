<?php

namespace App\Http\Controllers;

use App\Models\HdrsArea;
use App\Models\HdrsComplaints;
use App\Models\HdrsGroup;
use App\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class testController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$user = User::first();

		$a = auth()->attempt();
		var_dump(auth('api')->login($user));die;
//		auth()->attempt()
//		var_dump(\Admin::user());die;
//    	$a = HdrsGroup::select(['id', 'name'])->get()->mapWithKeys(function ($item) {
//			return [$item['id'] => $item['name']];
//		});
//    	var_dump($a);
//    	$user = User::find(2);
//    	$user->name = "Imfan";
//    	var_dump($user->name);

//		$hdrs_com = new HdrsComplaints(['title' => 'ruewioruiowruoq', 'content' => 'fssss']);
//		$hdrs_com = HdrsComplaints::find(1);
//		$user = User::find(3);
////		$user = new User();
//		$s = $hdrs_com->user()->dissociate();
//		$hdrs_com->title='dfas';
//		$hdrs_com->save();
		var_dump(1);

//    	$user = User::all();
////    	$user->load('hdrsComplaints');
//    	foreach ($user as $v)
//		{
//			var_dump($v->hdrsComplaints->title);
//		}
//    	if (!empty($user)) {
//			foreach ($user->hdrsComplaints as $v)
//			{
//				var_dump($v);
//			}
//		}
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
        //
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
}
