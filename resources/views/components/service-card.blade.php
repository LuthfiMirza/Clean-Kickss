<div class="menu__content">
    <img src="{{ asset('assets/img/' . $service['image']) }}" alt="{{ $service['name'] }}" class="menu__img" />
    <h3 class="menu__name">{{ $service['name'] }}</h3>
    <span class="menu__detail">{{ $service['detail'] }}</span>
    <span class="menu__preci">{{ $service['price'] }}</span>
    <a href="#" class="button menu__button" onclick="addToCart('{{ $service['name'] }}', {{ $service['price_numeric'] }})">
        <i class="bx bx-cart-alt"></i>
    </a>
</div>