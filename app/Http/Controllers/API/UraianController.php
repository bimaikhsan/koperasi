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
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Uraian::create([
            'nama' => $request->nama,
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
            'nama' => 'required',
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
    public function selectname($nama)
    {
        $data = [];
        $posts = Uraian::distinct()->get([$nama]);
        foreach ($posts as $key => $value) {
            $data[] = $value[$nama];
        }
        return response()->json($data);
    }
}
