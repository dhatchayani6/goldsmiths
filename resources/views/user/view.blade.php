
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $jewel->jewel_image }}" alt="{{ $jewel->name }}" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h1>{{ $jewel->name }}</h1>
            <p>{{ $jewel->description }}</p>
            <p><strong>Price: ${{ $jewel->price }}</strong></p>
            <a href="#" class="btn btn-success">Purchase</a>
        </div>
    </div>
</div>
@endsection
