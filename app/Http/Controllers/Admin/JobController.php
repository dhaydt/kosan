<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Fasilitas;
use App\Model\Jobs;
use App\Model\Kampus;
use App\Model\Rule;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        $query_param = [];
        $search = $request['search'];
        if ($type == 'in_house') {
            $products = Jobs::where(['added_by' => 'admin']);
        } else {
            $products = Jobs::where('added_by', 'seller');
        }

        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $products = $products->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }

        $request_status = $request['status'];
        $products = $products->orderBy('id', 'DESC')->paginate(Helpers::pagination_limit())->appends(['status' => $request['status']])->appends($query_param);

        return view('admin-views.jobs.list', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rule = Rule::get();
        $fas = Fasilitas::where('tipe', 'umum')->get();
        $cat = Category::get();
        $ptn = Kampus::get();

        return view('admin-views.jobs.add-new', compact('ptn', 'fas', 'rule', 'cat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $auth = 0;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'company_name' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'logo' => 'required',
            'penempatan' => 'required',
            'keahlian' => 'required',
            'pendidikan' => 'required',
            'status' => 'required',
            'deskripsi' => 'required',
            'gaji' => 'required',
            'satuan' => 'required',
        ], [
            'name.required' => 'Nama kos diperlukan!',
            'company_name.required' => 'Nama perusahaan diperlukan!',
            'province.required' => 'Mohon provinsi nya di isi!',
            'city.required' => 'Mohon kota nya di isi!',
            'district.required' => 'Mohon kecamatannya nya di isi!',
            'deskripsi.required' => 'Mohon isi deskripsi pekerjaan!',
            // 'noteAddress.required' => 'Mohon isi nama jalan!',
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $img = ImageManager::upload('jobs/', 'png', $request->file('logo'));
        $prov = Province::where('id', $request['province'])->first();
        $city = City::where('id', $request['city'])->first();

        $kost = new Jobs();
        $kost->company_name = $request['company_name'];
        $kost->province = $prov->name;
        $kost->city = $city->name;
        $kost->district = $request['district'];
        $kost->note_address = $request['noteAddress'];
        $kost->penempatan = $request['penempatan'];
        $kost->onsite = $request['onsite'];
        $kost->name = $request['name'];
        $kost->keahlian = $request['keahlian'];
        $kost->pendidikan = $request['pendidikan'];
        $kost->status = $request['status'];
        $kost->description = $request['deskripsi'];
        $kost->gaji = $request['gaji'];
        $kost->hide_gaji = $request['hide'];
        $kost->satuan_gaji = $request['satuan'];
        $kost->logo = $img;
        $kost->seller_id = $auth;
        $kost->added_by = 'admin';

        $kost->penanggung_jwb = $request['penanggung'];
        $kost->hp_penanggung_jwb = $request['hp'];
        $kost->email_penanggung_jwb = $request['email'];
        $kost->expire = $request['expire'];
        $kost->published = 0;
        $kost->request_status = 0;
        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            $kost->save();

            Toastr::success('Pekerjaan berhasil ditambahkan!');

            return redirect()->route('admin.jobs.list', ['type' => 'in_house']);
        }
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
        $product = Jobs::find($id);
        $rules = Rule::get();
        $fas = Fasilitas::where('tipe', 'umum')->get();
        $cat = Category::get();
        $ptn = Kampus::get();

        $rule = json_decode($product->aturan_id);
        $fasilitas = json_decode($product->fasilitas_id);

        return view('admin-views.jobs.edit', compact('ptn', 'product', 'rule', 'fasilitas', 'rules', 'fas', 'cat'));
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
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Nama properti diperlukan!',
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $prov = Province::where('id', $request['province'])->first();
        $city = City::where('id', $request['city'])->first();

        $product = Jobs::find($id);
        $product->company_name = $request['company_name'];
        $product->province = $prov->name;
        $product->city = $city->name;
        $product->district = $request['district'];
        $product->note_address = $request['noteAddress'];
        $product->penempatan = $request['penempatan'];
        $product->onsite = $request['onsite'];
        $product->name = $request['name'];
        $product->keahlian = $request['keahlian'];
        $product->pendidikan = $request['pendidikan'];
        $product->status = $request['status'];
        $product->description = $request['deskripsi'];
        $product->gaji = $request['gaji'];
        $product->hide_gaji = $request['hide'];
        $product->satuan_gaji = $request['satuan'];
        // $product->logo = $img;
        // $product->seller_id = $auth;
        // $product->added_by = 'admin';

        $product->penanggung_jwb = $request['penanggung'];
        $product->hp_penanggung_jwb = $request['hp'];
        $product->email_penanggung_jwb = $request['email'];
        $product->expire = $request['expire'];

        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            $product->logo = $request->file('logo') ? ImageManager::update('jobs/', $product->logo, 'png', $request->file('logo')) : $product->logo;
            $product->save();
            Toastr::success('Pekerjaan berhasil diupdate.');

            return redirect()->route('admin.jobs.list', ['type' => 'in_house']);
        }
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
