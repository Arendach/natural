@php /** @var \App\Models\Product $product */ @endphp
<div data-toggle="modal" data-target="#cart" class="cart-open {{ !$countProducts ? 'none' : '' }}">
    <i class="fa fa-shopping-cart"></i>
    <span class="cart-count">{{ $countProducts }}</span>
</div>

<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartTitle">Корзина</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cart_form" action="{{ route('order.create') }}" method="POST">
                <div class="modal-body">
                    <table class="table products {{ !$countProducts ? 'none' : '' }}">
                        <tbody>
                        @foreach($products as $product)
                            <tr class="product" data-id="{{ $product->id }}">
                                <td class="product_photo">
                                    <img
                                            width="70px"
                                            height="70px"
                                            src="{{ $product->getPictureMin() }}"
                                            alt="{{ $product->title }}"
                                    >
                                </td>
                                <td class="product_name">
                                    {{ $product->title }}
                                </td>
                                <td style="border-top: none;vertical-align: middle;text-align: right;">
                                    <span class="minus_cart action_cart">-</span>
                                    <span class="product_amount">
                                            {{ $cartProducts[$product->id] }}
                                        </span>
                                    <span class="plus_cart action_cart">+</span>
                                </td>
                                <td style="border-top: none;vertical-align: middle;text-align: right;">
                                    <span class="product_price">
                                        {{ number_format($product->price * $cartProducts[$product->id], 2) }}
                                    </span> грн
                                    <span class="un_cart">x</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <hr>

                    <div style="text-align: right">
                        Сума замовлення:
                        <span style="font-weight: bolder" class="order_sum">
                            {{ number_format($cartSum, 2) }} грн
                        </span>
                    </div>

                    <hr>

                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Імя</label>
                        <input id="name" name="name" class="form-control form-control-sm" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Номер телефону</label>
                        <input pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" required id="phone" name="phone"
                               class="form-control form-control-sm">
                    </div>

                    <div class="form-group">
                        <label for="comment">Коментар</label>
                        <textarea class="form-control form-control-sm" name="comment" id="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Згорнути</button>
                    <button class="btn btn-primary send">Оформити замовлення</button>
                </div>
            </form>
        </div>
    </div>
</div>