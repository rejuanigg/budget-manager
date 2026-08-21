<?php
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Transaction;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

test('Test Store Transaction API', function () {
    $user = User::factory()->create();

    $category = Category::create([
    'name' => 'Test',
    'user_id' => $user->id
    ]);

    $response = $this->actingAs($user)
    ->postJson(
        'api/transactions',
        [
            'transaction_date' => '2023-02-02',
            'type' => 'expense',
            'detail' => 'Testing Api',
            'amount' => '9999',
            'category_id' => $category->id
        ]
    );

    $response->assertStatus(201);
});

test('Test Update Transaction API', function(){
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Test',
        'user_id' => $user->id
    ]);
    $transaction = Transaction::create(
        [
            'user_id' => $user->id,
            'transaction_date' => '2023-02-02',
            'type' => 'expense',
            'detail' => 'Testing Api',
            'amount' => '9999',
            'category_id' => $category->id
        ]
    );

    $resource = $this->actingAs($user)
    ->patchJson("api/transactions/{$transaction->id}",
        [
            'transaction_date' => '2023-02-02',
            'type' => 'expense',
            'detail' => 'Testing Api',
            'amount' => '1231',
            'category_id' => $category->id
        ]
    );

    $resource->assertStatus(200);

    assertDatabaseHas('transactions', ['amount'=>'1231']);

});

test('Test Destroy Transaction API', function(){
    $user = User::factory()->create();

    $category = Category::create([
    'name' => 'Test',
    'user_id' => $user->id
    ]);

    $transaction = Transaction::create([
        'user_id' => $user->id,
        'transaction_date' => '2023-02-02',
        'type' => 'expense',
        'detail' => 'Testing Api',
        'amount' => '9999',
        'category_id' => $category->id
    ]);

    $response = $this->actingAs($user)
    ->deleteJson("api/transactions/{$transaction->id}");

    $response->assertStatus(204);
});

test('Test Store Transaction API with tags', function () {
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Test',
        'user_id' => $user->id,
    ]);

    $comida = Tag::create(['name' => 'Comida']);
    $extra = Tag::create(['name' => 'Extra']);

    $response = $this->actingAs($user)
        ->postJson('api/transactions', [
            'transaction_date' => '2023-02-02',
            'type' => 'expense',
            'detail' => 'Almuerzo',
            'amount' => '1500',
            'category_id' => $category->id,
            'tag_ids' => [$comida->id, $extra->id],
        ]);

    $response->assertStatus(201)
        ->assertJsonCount(2, 'data.tags');

    $transactionId = $response->json('data.id');

    assertDatabaseHas('tag_transaction', [
        'transaction_id' => $transactionId,
        'tag_id' => $comida->id,
    ]);

    assertDatabaseHas('tag_transaction', [
        'transaction_id' => $transactionId,
        'tag_id' => $extra->id,
    ]);
});

test('Test Update Transaction API syncs tags', function () {
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Test',
        'user_id' => $user->id,
    ]);

    $comida = Tag::create(['name' => 'Comida']);
    $extra = Tag::create(['name' => 'Extra']);

    $transaction = Transaction::create([
        'user_id' => $user->id,
        'transaction_date' => '2023-02-02',
        'type' => 'expense',
        'detail' => 'Almuerzo',
        'amount' => '1500',
        'category_id' => $category->id,
    ]);
    $transaction->tags()->attach($comida->id);

    $response = $this->actingAs($user)
        ->patchJson("api/transactions/{$transaction->id}", [
            'transaction_date' => '2023-02-02',
            'type' => 'expense',
            'detail' => 'Almuerzo',
            'amount' => '1500',
            'category_id' => $category->id,
            'tag_ids' => [$extra->id],
        ]);

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data.tags')
        ->assertJsonPath('data.tags.0.id', $extra->id);

    assertDatabaseHas('tag_transaction', [
        'transaction_id' => $transaction->id,
        'tag_id' => $extra->id,
    ]);

    assertDatabaseMissing('tag_transaction', [
        'transaction_id' => $transaction->id,
        'tag_id' => $comida->id,
    ]);
});

test('Test Destroy Transaction API detaches tags', function () {
    $user = User::factory()->create();

    $category = Category::create([
        'name' => 'Test',
        'user_id' => $user->id,
    ]);

    $tag = Tag::create(['name' => 'Comida']);

    $transaction = Transaction::create([
        'user_id' => $user->id,
        'transaction_date' => '2023-02-02',
        'type' => 'expense',
        'detail' => 'Almuerzo',
        'amount' => '1500',
        'category_id' => $category->id,
    ]);
    $transaction->tags()->attach($tag->id);

    $response = $this->actingAs($user)
        ->deleteJson("api/transactions/{$transaction->id}");

    $response->assertStatus(204);

    assertDatabaseMissing('tag_transaction', [
        'transaction_id' => $transaction->id,
        'tag_id' => $tag->id,
    ]);
});

