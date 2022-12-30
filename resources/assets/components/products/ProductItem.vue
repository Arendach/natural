<template>
  <li class="honey__item">
    <a class="honey__link" :href="product.url">
      <img
        v-lazy="product.mainPicture.thumbnail"
        class="honey__img img"
        :alt="product.title"
      />
    </a>
    <h4 class="honey__title">
      {{ product.title }}
    </h4>
    <p class="honey__text">Є в наявності</p>
    <div class="honey__tablet-ct">
      <a class="honey__text-sum">
        {{ product.price }} ₴
      </a>
      <button class="button" type="button" v-if="!inCart(product)" @click="addProduct(product)">
        <svg class="plus__icon-svg">
          <use href="/images/icons.svg#icon-plus"></use>
        </svg>
        Придбати
      </button>
      <button class="curent__btn" type="button" data-modal-open v-else>
        <svg class="curent__icon-svg">
          <use href="/images/icons.svg#icon-koshik_plus"></use>
        </svg>
        В кошику
      </button>
    </div>
  </li>
</template>

<script>
import {mapActions, mapGetters} from "vuex"

export default {
  name: 'ProductItem',
  props: {
    product: {
      type: Object,
      required: true,
    }
  },
  computed: {
    ...mapGetters(['products']),
  },
  methods: {
    ...mapActions(['addProduct']),
    inCart(product) {
      return this.products.filter((item) => item.id === product.id).length > 0
    }
  }
}
</script>