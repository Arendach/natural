<template>
  <div data-toggle="modal" data-target="#cart" class="cart-open" v-show="productsCount" @click="switchCartModalOpen">
    <img src="/images/cart.svg" alt="Cart icon">
    <span class="cart-count">{{ productsCount }}</span>
  </div>
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