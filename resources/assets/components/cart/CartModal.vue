<template>
  <MDBModal fullscreen="lg-down" size="xl" v-model="isOpened">
    <MDBModalHeader @close="closeModal">
      <MDBModalTitle id="exampleModalLabel">Корзина</MDBModalTitle>
    </MDBModalHeader>
    <MDBModalBody>
      <ProductsList/>

      <hr>

      <div style="text-align: right">
        Сума замовлення: <span style="font-weight: bolder" class="order_sum">{{ productsSum }} грн</span>
      </div>

      <hr>

      <OrderForm/>
    </MDBModalBody>
  </MDBModal>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex'
import {MDBModal, MDBModalHeader, MDBModalTitle, MDBModalBody, MDBModalFooter} from 'mdb-vue-ui-kit'
import ProductsList from "@/components/cart/ProductsList"
import OrderForm from "@/components/cart/OrderForm"

export default {
  name: 'CartModal',
  components: {
    OrderForm,
    MDBModal,
    MDBModalHeader,
    MDBModalTitle,
    MDBModalBody,
    MDBModalFooter,
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