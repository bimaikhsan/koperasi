<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Buku_besar_umum;
use App\Models\Posts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Buku_besar_umum::all()->toArray();
        return array_reverse($posts);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uraian' => 'required',
            'tanggal' => 'required',
            'nomor_bukti' => 'required',
            'data' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Buku_besar_umum::create([
            'uraian' => $request->uraian,
            'tanggal' => $request->tanggal,
            'nomor_bukti' => $request->nomor_bukti,
            'data' => json_encode($request->data),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'add Success!',
            'data'    => $user
        ]);
    }

    public function edit($id)
    {
        $post = Buku_besar_umum::find($id);
        return response()->json($post);
    }

    public function update($id, Request $request)
    {
        $post = Buku_besar_umum::find($id);
        $validator = Validator::make($request->all(), [
            'uraian' => 'required',
            'tanggal' => 'required',
            'nomor_bukti' => 'required',
            'data' => 'required',
        ]);

        $input = $request->all();
        // $imageName = NULL;
        // if ($image = $request->file('file')) {
        //     $destinationPath = 'img/';
        //     $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
        //     $image->move($destinationPath, $imageName);
            // $input['image'] = $imageName;
            // unlink('img/'.$post->image);
        // }

        $post->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Update Success!',
            'data'    => $input
        ]);
        // return response()->json(['success'=> 'Post update successfully']);
    }

    public function delete($id)
    {
        $post = Buku_besar_umum::find($id);
        $post->delete();
        // unlink('img/'.$post->image);
        return response()->json(['success'=> 'Post deleted successfully']);

    }

    public function cariData(Request $request)
    {
        if($request->tanggal < 10){
            $tanggal = "0".$request->tanggal;
        }else{
            $tanggal = $request->tanggal;
        }
        if($request->bulan < 10){
            $bulan = "0".$request->bulan;
        }else{
            $bulan = $request->bulan;
        }
        $tahun = $request->tahun;
        $nomor_bukti = $request->nomor_bukti;
        if (isset($request->tanggal) && isset($request->bulan) && isset($request->tahun) && isset($request->nomor_bukti) ) {
            $tanggalFull = $tahun."-".$bulan."-".$tanggal;
            $query = Buku_besar_umum::where('tanggal',$tanggalFull)->where('nomor_bukti',$nomor_bukti)->get();
        }elseif(isset($request->bulan) && isset($request->tahun) && isset($request->nomor_bukti) ){
            $tanggalFull = $tahun."-".$bulan;
            $query = Buku_besar_umum::where('tanggal','LIKE',"%{$tanggalFull}%")->where('nomor_bukti',$nomor_bukti)->get();
        }elseif(isset($request->nomor_bukti) && isset($request->tahun)){
            $tanggalFull = $tahun;
            $query = Buku_besar_umum::where('tanggal','LIKE',"%{$tanggalFull}%")->where('nomor_bukti',$nomor_bukti)->get();
        }elseif(isset($request->tanggal) && isset($request->bulan) && isset($request->tahun)){
            $tanggalFull = $tahun."-".$bulan."-".$tanggal;
            $query = Buku_besar_umum::where('tanggal',$tanggalFull)->get();
        }elseif(isset($request->bulan) && isset($request->tahun)){
            $tanggalFull = $tahun."-".$bulan;
            $query = Buku_besar_umum::where('tanggal','LIKE',"%{$tanggalFull}%")->get();
        }elseif(isset($request->tahun)){
            $tanggalFull = $tahun;
            $query = Buku_besar_umum::where('tanggal','LIKE',"%{$tanggalFull}%")->get();
        }
        // $tanggal = $request->tanggal;
        // $nomor_bukti = $request->nomor_bukti;
        // $nomor_rekening = $request->nomor_rekening;
        // if (isset($tanggal) && isset($nomor_bukti) && isset($nomor_rekening)) {
        //     $query = Buku_besar_umum::where('tanggal',$tanggal)->where('nomor_bukti',$nomor_bukti)->where('nomor_rekening',$nomor_rekening)->get();

        // }elseif(isset($tanggal)){
        //     $orderdate = explode('-', $tanggal);
        //     $year = $orderdate[0];
        //     $month   = $orderdate[1];
        //     $day  = $orderdate[2];
        //     $textTanggal = $year."-".$month;
        //     $query = Buku_besar_umum::where('tanggal','LIKE',"%{$textTanggal}%")->get();

        // }
        // $input = $request->all();
        // $imageName = NULL;
        // if ($image = $request->file('file')) {
        //     $destinationPath = 'img/';
        //     $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
        //     $image->move($destinationPath, $imageName);
            // $input['image'] = $imageName;
            // unlink('img/'.$post->image);
        // }

        return response()->json([
            'success' => true,
            'message' => 'Cari Success!',
            'data'    => $query
        ]);
    }
    public function selectname($nama)
    {
        $data = [];
        $posts = Buku_besar_umum::distinct()->get([$nama]);
        foreach ($posts as $key => $value) {
            $data[] = $value[$nama];
        }
        return $data;
    }
}
