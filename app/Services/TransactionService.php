<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function store(array $data, int $userId): Transaction
    {
        $tagIds = $data['tag_ids'] ?? [];
        unset($data['tag_ids']);

        $data['user_id'] = $userId;
        $transaction = Transaction::create($data);
        $transaction->tags()->sync($tagIds);

        return $transaction->load('tags');
    }

    public function update(Transaction $transaction, array $data): Transaction
    {
        $tagIds = $data['tag_ids'] ?? [];
        unset($data['tag_ids']);

        $transaction->update($data);
        $transaction->tags()->sync($tagIds);

        return $transaction->load('tags');
    }

    public function destroy(Transaction $transaction): void
    {
        $transaction->tags()->detach();
        $transaction->delete();
    }
}
