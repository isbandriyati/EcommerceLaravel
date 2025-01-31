
@props(['image', 'name', 'description', 'price', 'button_text'])

<div class="card">
    <div style="background-image: url('{{ $image }}'); widht:100%; height: 200px;background-size: cover;background-position:center;background-repeat: no-repeat;"></div>
  <div class="card-body">
    <h5 class="card-title">{{ $name }}</h5>
    <p class="card-text">{{ $description }}</p>
    <p>Rp.{{ number_format($price, 0, ",", ".") }}</p>
    <a href="#" class="btn btn-primary">{{ $button_text }}</a>

  </div>
</div>
