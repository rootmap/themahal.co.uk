<?php

namespace App\Http\Controllers;

use App\InclusiveMeal;
use App\InclusiveMealSetting;
use Illuminate\Http\Request;

class InclusiveMealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTable=InclusiveMeal::all();
        //dd($dataTable);
        return view('inclusive-meal.product-list',compact('dataTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inclusive-meal.product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rosMenu=[];
        if(count($request->pro_opt_name)>0)
        {
            foreach ($request->pro_opt_name as $key => $value) {
                $opt=[];
                $filedName='s_name_'.$request->pro_opt_fid[$key];
                $filedPrice='s_price_'.$request->pro_opt_fid[$key];
                if(isset($_POST[$filedName]))
                {
                    if(count($_POST[$filedName])>0)
                    {
                        foreach($_POST[$filedName] as $k=>$rr)
                        {
                            $pri=$_POST[$filedPrice][$k];
                            $opt[]=['name'=>$rr,'price'=>$pri];
                        }
                        $dataArray=['pro_opt_name'=>$value,'option_param'=>$opt];
                        $rosMenu[]=$dataArray;
                    }
                    
                }
                
            }
        }

        $rosMenuJson=serialize(json_encode($rosMenu));

        $isactive = $request->isactive ? 1 : 0;
        
        $tab=new InclusiveMeal();
        $tab->name=$request->name;
        $tab->price=$request->price;
        $tab->description=$request->description;
        $tab->product_json=$rosMenuJson;
        $tab->isactive=$isactive;
        $tab->save();

        \Session::flash('status', 'Successfully Added To inclusive-meal List');
        //->with('status', 'Successfully Added To Product List.')
        return redirect()->action('InclusiveMealController@create');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InclusiveMeal  $inclusiveMeal
     * @return \Illuminate\Http\Response
     */
    public function show(InclusiveMeal $inclusiveMeal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InclusiveMeal  $inclusiveMeal
     * @return \Illuminate\Http\Response
     */



    public function inclusiveSettings()
    {
        $count=InclusiveMealSetting::orderBy('id','DESC')->count();
        $edit="";
        if($count > 0)
        {
            $edit=InclusiveMealSetting::orderBy('id','DESC')->first();
            return view('inclusive-meal.inclusive',compact('edit'));
        }
        else
        {
            return view('inclusive-meal.inclusive');
        }
        
        //dd($dataTable);
        
    }

    public function inclusiveSettingsSave(Request $request)
    {
       
        $inclusive_meal=$request->inclusive_meal?'1':'0';
        $count=InclusiveMealSetting::orderBy('id','DESC')->count();
        if($count==0)
        {
            $edit=new InclusiveMealSetting();
            $edit->inclusive_meal=$inclusive_meal;
            $edit->save();
        }
        else
        {
            $edit=InclusiveMealSetting::orderBy('id','DESC')->first();
            $edit->inclusive_meal=$inclusive_meal;
            $edit->save();
        }
        
        \Session::flash('status', 'Settings Successfully updated');
        //->with('status', 'Successfully Added To Product List.')
        return redirect()->action('InclusiveMealController@inclusiveSettings');

    }

    public function edit(InclusiveMeal $inclusiveMeal,$itemid=0)
    {
        $edit=InclusiveMeal::find($itemid);
        //dd($dataTable);
        return view('inclusive-meal.product-edit',compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InclusiveMeal  $inclusiveMeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InclusiveMeal $inclusiveMeal,$id=0)
    {
        $rosMenu=[];
        if(count($request->pro_opt_name)>0)
        {
            foreach ($request->pro_opt_name as $key => $value) {
                $opt=[];
                $filedName='s_name_'.$request->pro_opt_fid[$key];
                $filedPrice='s_price_'.$request->pro_opt_fid[$key];
                if(isset($_POST[$filedName]))
                {
                    if(count($_POST[$filedName])>0)
                    {
                        foreach($_POST[$filedName] as $k=>$rr)
                        {
                            $pri=$_POST[$filedPrice][$k];
                            $opt[]=['name'=>$rr,'price'=>$pri];
                        }
                        $dataArray=['pro_opt_name'=>$value,'option_param'=>$opt];
                        $rosMenu[]=$dataArray;
                    }
                    
                }
                
            }
        }

        $rosMenuJson=serialize(json_encode($rosMenu));

        $isactive = $request->isactive ? 1 : 0;
        
        $tab=InclusiveMeal::find($id);
        $tab->name=$request->name;
        $tab->price=$request->price;
        $tab->description=$request->description;
        $tab->product_json=$rosMenuJson;
        $tab->isactive=$isactive;
        $tab->save();

        \Session::flash('status', 'Successfully updated To inclusive-meal List');
        //->with('status', 'Successfully Added To Product List.')
        return redirect()->action('InclusiveMealController@create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InclusiveMeal  $inclusiveMeal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delinfo = InclusiveMeal::find($id);
        //dd($delinfo);
        $delinfo->delete();
        //\Session::flash('status', 'Successfully Updated To Product List');
        //
        return response()->json(1);
    }
}
