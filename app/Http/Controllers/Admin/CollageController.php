<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Kampus;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Provinsi as ModelsProvinsi;

class CollageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $ptn = Kampus::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        } else {
            $ptn = new Kampus();
        }
        $city = City::pluck('name', 'id');
        $provs = Province::pluck('name', 'id');
        $ptn = $ptn->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.collage.view', compact('city', 'provs', 'ptn', 'search'));
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
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'singkatan' => 'required',
            'city' => 'required',
        ], [
            'name.required' => 'Nama kampus diperlukan!',
            'image.required' => 'Logo kampus diperlukan!',
            'singkatan.required' => 'Singkatan kampus diperlukan!',
            'city.required' => 'kota kampus diperlukan!',
        ]);

        $category = new Kampus();
        $category->name = $request->name;
        $category->city_id = $request->city;
        $category->province_id = $request->province;
        $category->short = $request->singkatan;
        $category->logo = ImageManager::upload('collage/', 'png', $request->file('image'));
        $category->save();

        Toastr::success('Collage added successfully!');

        return back();
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
        $category = Kampus::with('city')->find($id);
        // dd($category);
        $city = City::pluck('name', 'id');
        $provs = ModelsProvinsi::pluck('name', 'id');

        return view('admin-views.collage.category-edit', compact('category', 'city', 'provs'));
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
        $category = Kampus::find($request->id);
        $category->name = $request->name;
        $category->city_id = $request->city;
        $category->province_id = $request->province;
        $category->short = $request->singkatan;
        if ($request->image) {
            $category->logo = ImageManager::update('collage/', $category->logo, 'png', $request->file('image'));
        }
        $category->save();

        Toastr::success('Collage updated successfully!');

        return redirect()->route('admin.collage.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $categories = Kampus::where('id', $request->id)->get();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                Kampus::destroy($category->id);
            }
        }
        Kampus::destroy($request->id);

        return response()->json();
    }
}
