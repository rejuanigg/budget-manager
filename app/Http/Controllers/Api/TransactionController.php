<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requests\StoreTransactionRequest;
use App\Http\Requests\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $service
    )
    {}

    public function index(Request $request)
    {
        $misTransacciones = $request->user()->transactions()->with('tags')->get();

        return TransactionResource::collection($misTransacciones);
    }

    public function store(StoreTransactionRequest $request)
    {
        $nuevaTransaccion = $this->service->store($request->validated(), Auth::id());

        $resource = new TransactionResource($nuevaTransaccion);

        return $resource->response()->setStatusCode(201);
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        $editarTransaccion = $this->service->update($transaction, $request->validated());

        $resource = new TransactionResource($editarTransaccion);

        return $resource->response()->setStatusCode(200);
    }

    public function destroy(Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        $this->service->destroy($transaction);

        return response()->noContent();
    }
}


