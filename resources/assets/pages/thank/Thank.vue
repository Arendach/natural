<template>
  <Banners :banners="banners"/>

  <div class="container scroll-to-me">
    <h2>{{ order.name }}, спасибі Вам за замовлення</h2>
    <p>Ваше замовлення приняте!</p>
    <p>Найближчим часом з Вами зв'яжеться менеджер за номером <b>{{ order.phone }}</b></p>
    <table class="table table-dark table-bordered" v-if="order.products">
      <thead>
      <tr>
        <th scope="col">Фото</th>
        <th scope="col">Товар</th>
        <th scope="col">Кількість</th>
        <th scope="col">Вартість (₴)</th>
        <th scope="col">Сума (₴)</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="product in order.products">
        <th scope="row">
          <a :href="product.url">
            <img v-lazy="product.mainPicture.thumbnail" :alt="product.mainPicture.alt" style="width: 80px">
          </a>
        </th>
        <td style="vertical-align: middle">
          <a :href="product.url">
            {{ product.title }}
          </a>
        </td>
        <td style="vertical-align: middle">
          {{ product.orderCount }}
        </td>
        <td style="vertical-align: middle">
          {{ product.orderPrice }}
        </td>
        <td style="vertical-align: middle">
          {{ product.orderCount * product.orderPrice }}
        </td>
      </tr>
      <tr>
        <td colspan="5" style="text-align: right">
          Сума замовлення: <b>{{ productsSum }}</b> грн
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Banners from '@/pages/index/Banners'

export default {
  name: 'Thank',
  components: {Banners},
  props: {
    banners: {
      type: Array,
      required: true,
    },
    order: {
      type: Object,
      required: true,
    },
  },
  computed: {
    productsSum() {
      if (!this.order.products) return 0

      return this.order.products.map(product => product.orderCount * product.orderPrice).reduce((a, b) => a + b, 0)
    }
  },
  mounted() {
    setTimeout(() => document.querySelector('.scroll-to-me').scrollIntoView(true), 500)
  }
}
</script>

<style>
.container {
  text-align: center;
  padding: 30px 0;
}
</style>