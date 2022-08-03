<template>
  <div class="product-cat">
    <a :href="product.url">
      <img v-lazy="product.picture" :alt="product.title">
    </a>
    <h3 class="product-name">
      {{ product.title }}
    </h3>

    <div class="product-cat-footer">
      <div class="product-cat-price">
        Ціна: <b>{{ product.price }}</b> грн
      </div>
      <div class="product-cat-buttons">
        <a class="btn btn-primary" :href="product.url">
          Детальніше
        </a>
        <button class="btn btn-primary to_cart" @click="addProduct(product)">
          В корзину
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex"

export default {
  name: 'ProductItem',
  props: {
    product: {
      type: Object,
      required: true,
    }
  },
  methods: {
    ...mapActions(['addProduct'])
  }
}
</script>