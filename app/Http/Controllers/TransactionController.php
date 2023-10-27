<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Http\Resources\UserTransactionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransactionController extends Controller
{
    public function __construct(private readonly TransactionService $transactionService)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        return UserTransactionResource::collection($this->transactionService->getTransactions(user: $request->user()));
    }
}
