<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->curlGet('','http://api.test/test');
        return 123;
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

    public function curlGet ($data,$route)
    {
        try {
            $curl = curl_init();
            curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json', 'Accept:application/json']);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($curl,CURLOPT_URL, $route);
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl,CURLOPT_POSTFIELDS, $data);

            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);
            if($error){
                throw new \Exception($error);
            }
            else{
                return $response;
            }
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
