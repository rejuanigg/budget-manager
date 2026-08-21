<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis transacciones</title>
</head>
<body>
    <h1>Mis transacciones</h1>
    <table style="width:80%" border="2px">
        <tr>
            <th>Fecha</th>
            <th>Detalle</th>
            <th>Monto</th>
            <th>Tipo</th>
            <th>Categoria</th>
            <th>Tags</th>
            <th>Opciones</th>
        </tr>
        @foreach ($misTransacciones as $item)
            <tr>
                <td>{{$item->transaction_date}}</td>
                <td>{{$item->detail}}</td>
                <td>{{$item->amount}}</td>
                <td>{{$item->type}}</td>
                <td>{{$item->category->name}}</td>
                <td>{{ $item->tags->pluck('name')->join(', ') }}</td>
                <td>
                    <form action="{{route('transactions.destroy', $item->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar ❎</button>
                    </form>
                    <a href="{{route('transactions.edit', $item->id)}}">Editar ✏️</a>
                </td>
            </tr>
        @endforeach


    </table>
    <br>
    <br>
    <a href=" {{route('transactions.create')}} ">Volver al Inicio</a>
</body>
</html>
