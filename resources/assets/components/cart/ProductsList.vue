<template>
<!--  <div class="products">
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
  </div>-->

  <section class="modal__section">
    <ul class="modal__list list">
      <li class="modal__item" v-for="product in products">
        <div class="modal__wrap">
          <a :href="product.url">
            <img
              v-lazy="getPicture(product)"
              class="modal__img"
              :alt="product.title"
            />
          </a>
          <a class="modal__title" :href="product.url" v-html="product.title"></a>
        </div>
        <div class="modal__container">
          <span class="modal__span">
            <svg class="modal__icon-minus modal__svg" @click="changeCount({product: product, action: 'minus'})">
              <use href="/images/icons.svg#icon-filter-minus"></use>
            </svg>
            {{ product.count }}
            <svg class="modal__icon-plys modal__svg" @click="changeCount({product: product, action: 'plus'})">
              <use href="/images/icons.svg#icon-filter-plys"></use>
            </svg>
          </span>

          <p class="modal__text">
            {{ product.count * product.price }} ₴
            <svg class="modal__icon-koshik" @click="removeProduct(product)">
              <use href="/images/icons.svg#icon-filter-koshik"></use>
            </svg>
          </p>
        </div>
      </li>
      <li class="modal-sum__li">
        Вся сума:<span class="modal-sum__span">{{ productsSum }} ₴</span>
      </li>
    </ul>
  </section>
</template>

<script>
import {mapGetters, mapActions} from "vuex"

export default {
  name: 'ProductsList',
  computed: {
    ...mapGetters(['products', 'productsSum']),
  },
  methods: {
    ...mapActions(['changeCount', 'removeProduct']),
    getPicture: (item) => item.picture !== null ? item.picture : ''
  }
}
</script>