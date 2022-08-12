<template>
  <ModalSwitcher/>
  <CartModal/>
</template>

<script>
import ModalSwitcher from "@/components/cart/ModalSwitcher"
import CartModal from "@/components/cart/CartModal"
import {mapActions} from "vuex"

export default {
  name: 'Cart',
  components: {
    ModalSwitcher,
    CartModal,
  },
  props: {
    products: {
      type: Array,
      required: true,
    },
  },
  created() {
    this.products.forEach((product) => this.addProduct(product))
  },
  methods: {
    ...mapActions(['addProduct'])
  }
}
</script>