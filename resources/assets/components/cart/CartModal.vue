<template>
  <MDBModal fullscreen v-model="cartModalOpen">
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
    <MDBModalFooter>
      <MDBBtn color="secondary" @click="closeModal">Закрити</MDBBtn>
      <MDBBtn color="primary">Оформити замовлення</MDBBtn>
    </MDBModalFooter>
  </MDBModal>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex'
import {MDBModal, MDBModalHeader, MDBModalTitle, MDBModalBody, MDBModalFooter, MDBBtn} from 'mdb-vue-ui-kit'
import ProductsList from "./ProductsList"
import OrderForm from "./OrderForm"

export default {
  name: 'CartModal',
  components: {
    OrderForm,
    MDBModal,
    MDBModalHeader,
    MDBModalTitle,
    MDBModalBody,
    MDBModalFooter,
    MDBBtn,
    ProductsList,
  },
  computed: {
    ...mapGetters(['productsSum', 'cartModalOpen']),
  },
  methods: {
    ...mapMutations(['setCartModalOpen']),
    closeModal() {
      this.setCartModalOpen(false)
    },
  }
}
</script>