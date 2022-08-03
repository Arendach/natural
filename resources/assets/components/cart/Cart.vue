<template>
  <ModalSwitcher/>
  <CartModal/>
</template>

<script>
import ModalSwitcher from "./ModalSwitcher"
import CartModal from "./CartModal"

export default {
  name: 'Cart',
  components: {
    ModalSwitcher,
    CartModal,
  }
}
</script>