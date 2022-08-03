<template>
  <table class="table products">
    <tbody>
    <tr class="product" v-for="product in products" :key="product.id">
      <td class="product_photo">
        <img :src="product.picture" :alt="product.title" style="height: 100px">
      </td>
      <td class="product_name">
        <a :href="product.url" target="_blank">{{ product.title }}</a>
      </td>
      <td style="border-top: none;vertical-align: middle;text-align: right;">
        <span class="action_cart" @click="changeCount({product: product, action: 'minus'})">-</span>
        <span class="product_amount">{{ product.count }}</span>
        <span class="action_cart" @click="changeCount({product: product, action: 'plus'})">+</span>
      </td>
      <td style="border-top: none; vertical-align: middle;text-align: right;">
        <span class="product_price">{{ product.count * product.price }}</span> грн
        <span class="un_cart" @click="removeProduct(product)">x</span>
      </td>
    </tr>
    </tbody>
  </table>
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
  }
}
</script>