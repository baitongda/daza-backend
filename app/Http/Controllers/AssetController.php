<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asset;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;

class AssetController extends Controller
{

    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.auth');
    }

    public function index(Request $request)
    {
        $target_type = $request->query('target_type');
        $target_id   = $request->query('target_id');

        $query = Asset::orderBy('created_at', 'asc')
            ->where('user_id', Auth::id())
            ->where('target_type', $target_type)
            ->where('target_id', $target_id);

        return $this->pagination($query->paginate());
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => Auth::id()]);
        $params = $request->all();

        $this->validate($request, [
            'mime_type' => 'required',
            'size'      => 'required',
            'url'       => 'required',
        ]);

        $data = Asset::create($params);
        if ($data) {
            return $this->success($data);
        }
        return $this->failure();
    }

    public function show(Request $request, $id)
    {
        return $this->success();
    }

    public function update(Request $request)
    {
        return $this->failure();
    }

    public function destroy(Request $request)
    {
        return $this->failure();
    }

}
