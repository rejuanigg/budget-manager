<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Transacción</title>
</head>
<body>
    <h2>Crear nueva transaccion</h2>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <label>¿Que movimiento realizaste?</label>
        <select name="type">
            <option value="income">Ingreso</option>
            <option value="expense">Gasto</option>
        </select>

        <br>
        <br>

        <label>Fecha</label>
        <input name="transaction_date" type="date" required>

        <br>
        <br>

        <label>Detalle</label>
        <input name="detail" type="text" placeholder="No obligatorio">

        <br>
        <br>

        <label>Monto</label>
        <input name="amount" type="number" placeholder="Introduce el monto" required>

        <br>
        <br>

        <label>Categoria</label>
        <select name="category_id" required>
            @foreach ($categorias as $categoria)
                <option value="{{$categoria->id}}">
                    {{$categoria->name}}
                </option>
            @endforeach
        </select>
        <br>
        <br>

        <label>Tags (opcional, Ctrl o Cmd para elegir varios)</label>
        <select name="tag_ids[]" multiple>
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <br>
        <br>

        <button type="submit">Enviar</button>
    </form>
    <br>
    <br>
    <a href="{{route('categories.create')}}">Añadir nueva categoria</a>
    <a href="{{route('transactions.index')}}">Ver mis transacciones</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
