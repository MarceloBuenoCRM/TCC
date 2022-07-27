<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected User $model;
    protected UserTransformer $transformer;
    protected UserService $service;

    public function __construct(UserTransformer $transformer, UserService $service)
    {
        $this->transformer = $transformer;
        $this->service     = $service;
    }

    public function index(Request $request)
    {
        $rows = $this->service->index($request->all())->paginate(10);

        $rows = $this->transformer->transform($rows);

        return response()->json([
            'data' => $rows
        ]);
    }

    public function show($id)
    {
        $row = $this->service->show($id)->paginate(1);

        $row = $this->transformer->transform($row);

        return response()->json([
            'data' => $row
        ]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();

        $data['cad_senha'] = Hash::make($request->cad_senha);

        $row = $this->service->create($data);

        return response($row, 201);
    }

    public function update($id, UserRequest $request)
    {
        $data = $request->only('cad_email', 'cad_nome');

        $this->service->update($id, $data);

        return response([], 204);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return response([], 204);
    }

    public function alteraModoEscuro($id)
    {
        $modoEscuro = $this->service->updateModoEscuro($id);

        return response([], 204)->withCookie(cookie()->make('modo_escuro', (string)(int)$modoEscuro, 60, null, null, false, false))
        ->withCookie(cookie()->make('token_api', Cookie::get('token_api'), 60, null, null, false, false));
    }
}
