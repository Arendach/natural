<template>
  <div :class="{'is-hidden': !isOpened, modal: true}">
    <div class="modal-window">
      <div class="m-f">
        <h2 class="modal-title">Кошик</h2>
        <button class="modal-button" @click="closeModal">
          <svg class="modal-svg">
            <use href="/images/icons.svg#icon-close"></use>
          </svg>
        </button>
        <ProductsList/>
      </div>
      <OrderForm/>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex'
import ProductsList from "@/components/cart/ProductsList"
import OrderForm from "@/components/cart/OrderForm"

export default {
  name: 'CartModal',
  components: {
    OrderForm,
    ProductsList,
  },
  computed: {
    ...mapGetters(['productsSum', 'cartModalOpen']),
    isOpened: {
      get() {
        return this.cartModalOpen
      },
      set(value) {
        this.setCartModalOpen(value)
      },
    }
  },
  methods: {
    ...mapMutations(['setCartModalOpen']),
    closeModal() {
      this.setCartModalOpen(false)
    },
  }
}
</script>