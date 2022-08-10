<template>
  <div class="products">
    <div class="row product align-items-center" v-for="product in products">
      <div class="col-3">
        <img v-lazy="getPicture(product)" :alt="product.title" style="height: 100px">
      </div>
      <div class="col-3">
        <a :href="product.url" target="_blank">
          <b>{{ product.title }}</b>
        </a>
      </div>
      <div class="col-3">
        <span class="action_cart" @click="changeCount({product: product, action: 'minus'})">-</span>
        <span class="product_amount">{{ product.count }}</span>
        <span class="action_cart" @click="changeCount({product: product, action: 'plus'})">+</span>
      </div>
      <div class="col-3">
        <span class="product_price">{{ product.count * product.price }}</span> грн
        <span class="un_cart" @click="removeProduct(product)">x</span>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex"

export default {
  name: 'ProductsList',
  computed: {
    ...mapGetters(['products']),
  },
  methods: {
    ...mapActions(['changeCount', 'removeProduct']),
    getPicture: (item) => item.picture !== null ? item.picture : ''
  }
}
</script>