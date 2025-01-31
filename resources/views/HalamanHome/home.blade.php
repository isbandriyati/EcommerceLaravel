@extends('HalamanHome.layouts')

@section('title', 'Contoh Halaman')

@section('content')
    <h1>Contoh Halaman</h1>

<div class="row">    
<div class="col-md-4">  
    <x-card 
        image="https://uwitan.id/wp-content/uploads/2019/09/1-furniture-meja-makan-m-natural.jpg"
        name="Card"
        description="This is product1 description."
        price="299"
        button_text="Buy now"
    />
</div>

<div class="col-md-4">  
    <x-card 
        image="https://uwitan.id/wp-content/uploads/2019/09/1-furniture-meja-makan-m-natural.jpg"
        name="Card"
        description="This is product1 description."
        price="299"
        button_text="Buy now"
    />
</div>
</div>

@endsection
