<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Transaccion</title>
</head>
<body>
    <h1>Eeditar Transaccion</h1>
    <form action="{{route('transactions.update', $transaction->id)}}" method="post">
        @csrf
        @method('PATCH')
        <span>Cambia la fecha</span>
        <br>
        <input type="date" name="transaction_date" value="{{$transaction->transaction_date}}">
        <br>
        <br>

        <span>Cambia el detalle</span>
        <br>
        <input type="text" placeholder="Cambia el detalle" name="detail" value="{{$transaction->detail}}">
        <br>
        <br>

        <span>Cambia el monto</span>
        <br>
        <input type="number" placeholder="Cambiá el monto" name="amount" value="{{$transaction->amount}}">
        <br>
        <br>

        <span>Cambia el tipo</span>
        <br>
        <select name="type">
            <option value="expense" @selected($transaction->type == 'expense')>Gasto</option>
            <option value="income" @selected($transaction->type == 'income')>Ingreso</option>
        </select>
        <br>
        <br>

        <span>Cambia de Categoria</span>
        <br>
        <select name="category_id">
            @foreach ($categories as $item)
                <option value="{{$item->id}}" @selected($transaction->category_id == $item->id)>
                    {{$item->name}}
                </option>
            @endforeach
        </select>
        <br>
        <br>

        <span>Tags</span>
        <br>
        <select name="tag_ids[]" multiple>
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" @selected($transaction->tags->contains($tag))>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
        <br>
        <br>
        <button type="submit">Enviar</button>
    </form>
    <a href="{{route('transactions.index')}}">Volver a la lista</a>
</body>
</html>
