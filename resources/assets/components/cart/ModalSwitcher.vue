<template>
  <button class="header__button" type="button" @click="switchCartModalOpen">
    <svg class="header__button__icon-svg">
      <use href="/images/icons.svg#icon-koshik__white"></use>
    </svg>
    Кошик <span v-if="productsCount > 0" v-html="productsCount" class="counter"></span>
  </button>
</template>

<script>
import {mapMutations, mapGetters} from "vuex"

export default {
  name: 'ModalSwitcher',
  data() {
    return {}
  },
  computed: {
    ...mapGetters(['cartModalOpen', 'productsCount']),
  },
  methods: {
    ...mapMutations(['setCartModalOpen']),
    switchCartModalOpen() {
      this.setCartModalOpen(true)
    }
  },
}
</script>

<style>
.counter {
  color: red;
  margin-left: 10px;
}
</style>