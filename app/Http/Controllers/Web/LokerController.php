<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Apply;
use App\Model\Jobs;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class LokerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $job = Jobs::where('id', $id)->first();
    }

    public function order()
    {
        $check = Auth('customer')->user();
        if (!$check) {
            return redirect()->route('customer.auth.login');
        }
        $orders = Apply::with('job')->where('customer_id', auth('customer')->id())->orderBy('id', 'DESC')->get();
        // dd($orders);

        return view('web-views.users-profile.account-apply', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $on = 0;
        if ($request->onsite == 'on') {
            $on = 1;
        } else {
            $on = 0;
        }
        $apply = new Apply();
        $apply->name = $request->name;
        $apply->customer_id = auth('customer')->id();
        $apply->job_id = $request->id;
        $apply->email = $request->email;
        $apply->phone = $request->phone;
        $apply->address = $request->address;
        $apply->pendidikan = $request->pendidikan;
        $apply->keahlian = $request->keahlian;
        $apply->experience = $request->experience;
        $apply->penghasilan = $request->penghasilan;
        $apply->gaji = $request->gaji;
        $apply->onsite = $on;
        $apply->save();
        Toastr::success('Lamaran anda berhasil dikirim, mohon tunggu info selanjutnya..');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
