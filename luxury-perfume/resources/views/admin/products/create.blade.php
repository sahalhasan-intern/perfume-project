<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Create Product</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body style="font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;padding:24px;">
    <h1>Create Product</h1>

    @if ($errors->any())
        <div style="color:#b91c1c;margin-bottom:12px;">
            <strong>There were some problems with your input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf

        <div style="margin-bottom:8px;">
            <label for="name">Name</label><br>
            <input id="name" name="name" value="{{ old('name') }}" required style="width:320px;padding:6px;" />
        </div>

        <div style="margin-bottom:8px;">
            <label for="price">Price</label><br>
            <input id="price" name="price" value="{{ old('price') }}" required style="width:160px;padding:6px;" />
        </div>

        <div style="margin-bottom:8px;">
            <label for="stock">Stock</label><br>
            <input id="stock" name="stock" value="{{ old('stock') }}" style="width:160px;padding:6px;" />
        </div>

        <div style="margin-bottom:12px;">
            <label for="description">Description</label><br>
            <textarea id="description" name="description" style="width:420px;height:120px;padding:6px;">{{ old('description') }}</textarea>
        </div>

        <button type="submit" style="padding:8px 12px;background:#111;color:#fff;border-radius:4px;border:0;">Create</button>
        <a href="{{ route('admin.products.index') }}" style="margin-left:12px;">Cancel</a>
    </form>
</body>
</html>
