<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Kost;
use App\Model\Category;
use App\Model\Fasilitas;
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
            $products = Kost::with(['kampus', 'rooms'])->where(['added_by' => 'admin']);
        } else {
            $products = Kost::with(['kampus', 'rooms'])->where('added_by', 'seller');
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
        $auth = 0;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'penghuni' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
        ], [
            'name.required' => 'Nama kos diperlukan!',
            'penghuni.required' => 'Jenis Penghuni diperlukan!',
            'province.required' => 'Mohon provinsi nya di isi!',
            'city.required' => 'Mohon kota nya di isi!',
            'district.required' => 'Mohon kecamatannya nya di isi!',
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $img = [
            'depan' => ImageManager::upload('kost/', 'png', $request->file('depan')),
            'dalam' => ImageManager::upload('kost/', 'png', $request->file('dalam')),
            'jalan' => ImageManager::upload('kost/', 'png', $request->file('jalan')),
        ];
        $prov = Province::where('id', $request['province'])->first();
        $city = City::where('id', $request['city'])->first();

        $kost = new Kost();
        $kost->province = $prov->name;
        $kost->city = $city->name;
        $kost->district = $request['district'];
        $kost->note_address = $request['noteAddress'];
        $kost->seller_id = $auth;
        $kost->added_by = 'admin';
        $kost->category_id = $request['category'];
        $kost->ptn_id = $request['ptn'];
        $kost->name = $request['name'];
        $kost->penghuni = $request['penghuni'];
        $kost->deskripsi = $request['description'];
        $kost->note = $request['note'];
        $kost->aturan_id = json_encode($request['aturan']);
        $kost->address = $request['address'];
        $kost->images = json_encode($img);
        $kost->fasilitas_id = json_encode($request['fasilitas']);
        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            $kost->save();

            Toastr::success('Property berhasil ditambahkan!');

            return redirect()->route('admin.property.list', ['type' => 'in_house']);
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
