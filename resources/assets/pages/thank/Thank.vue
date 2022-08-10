<template>
  <Banners :banners="banners"/>

  <div class="container">
    <h2>{{ order.name }}, спасибі Вам за замовлення</h2>
    <p>Ваше замовлення приняте! Найближчим часом з Вами зв'яжеться менеджер за номером <b>{{ order.phone }}</b></p>
    <table class="table table-dark table-bordered">
      <thead>
      <tr>
        <th scope="col">Фото</th>
        <th scope="col">Товар</th>
        <th scope="col">Кількість</th>
        <th scope="col">Сума</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="product in products">
        <th scope="row">
          <a :href="product.url">
            <img v-lazy="product.picture" :alt="product.title" style="width: 80px">
          </a>
        </th>
        <td style="vertical-align: middle">
          <a :href="product.url">
            {{ product.title }}
          </a>
        </td>
        <td style="vertical-align: middle">
          {{ product.count }}
        </td>
        <td style="vertical-align: middle">
          {{ product.count * product.price }}
        </td>
      </tr>
      <tr>
        <td colspan="4">
          Сума замовлення: <b>{{ productsSum }}</b> грн
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Banners from "../Index/Banners"

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
    products: {
      type: Array,
      require: true,
    }
  },
  computed: {
    productsSum() {
      return this.products.map(product => product.count * product.price).reduce((a, b) => a + b, 0)
    }
  }
}
</script>

<style>
.container {
  text-align: center;
  padding: 30px 0;
}
</style>