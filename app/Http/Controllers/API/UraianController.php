<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Uraian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UraianController extends Controller
{
    public function index()
    {
        $posts = Uraian::all()->toArray();
        return array_reverse($posts);
    }
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_akun' => 'required',
            'nama_akun' => 'required',
            'debit' => 'required',
            'kredit' => 'required',
            'saldo' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Uraian::create([
            'nomor_akun' => $request->nomor_akun,
            'nama_akun' => $request->nama_akun,
            'debit' => $request->debit,
            'kredit' => $request->kredit,
            'saldo' => $request->saldo,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'add Success!',
            'data'    => $user
        ]);
    }
    public function edit($id)
    {
        $post = Uraian::find($id);
        return response()->json($post);
    }

    public function update($id, Request $request)
    {
        $post = Uraian::find($id);
        $validator = Validator::make($request->all(), [
            'nomor_akun' => 'required',
            'nama_akun' => 'required',
            'debit' => 'required',
            'kredit' => 'required',
            'saldo' => 'required',
        ]);

        $input = $request->all();
        $post->update($input);
        return response()->json([
            'success' => true,
            'message' => 'Update Success!',
            'data'    => $input
        ]);
    }

    public function delete($id)
    {
        $post = Uraian::find($id);
        $post->delete();
        return response()->json(['success'=> 'Post deleted successfully']);

    }
    public function selectname()
    {
        $data = [];
        $posts = Uraian::distinct()->get();
        foreach ($posts as $key => $value) {
            $data[] = $value['nomor_akun']."-".$value['nama_akun'];
        }
        return response()->json($data);
    }
}
