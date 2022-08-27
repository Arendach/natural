<template>
  <MDBRow tag="form" class="g-4 needs-validation" novalidate @submit.prevent="sendForm">
    <MDBCol col="6">
      <MDBInput
        minLength="2"
        maxLength="255"
        label="Ваше ім'я"
        v-model="name"
        valid-feedback="Чудово! Поле заповнено вірно!"
        invalid-feedback="Упс! Поле заповнено не вірно!"
        validation-event="input"
        required
      />
    </MDBCol>
    <MDBCol col="6">
      <MDBInput
        minLength="10"
        maxLength="10"
        label="Ваш номер телефону"
        v-model="phone"
        required
        valid-feedback="Чудово! Поле заповнено вірно!"
        invalid-feedback="Упс! Поле заповнено не вірно!"
        validation-event="input"
        placeholder="0999999999"
        pattern="^0[0-9]{9}$"
      />
    </MDBCol>
    <MDBCol col="12">
      <MDBTextarea
        label="Коментар до замовлення"
        v-model="comment"
        valid-feedback="Чудово! Поле заповнено вірно!"
        invalid-feedback="Упс! Поле заповнено не вірно!"
        validation-event="input"
      />
    </MDBCol>
    <MDBCol col="12">
      <MDBBtn color="primary" type="submit">Оформити замовлення</MDBBtn>
    </MDBCol>
  </MDBRow>
</template>

<script>
import {MDBInput, MDBRow, MDBTextarea, MDBContainer, MDBBtn, MDBCol} from 'mdb-vue-ui-kit'
import {mapGetters} from 'vuex'

export default {
  name: 'OrderForm',
  components: {
    MDBInput,
    MDBRow,
    MDBTextarea,
    MDBContainer,
    MDBBtn,
    MDBCol,
  },
  data() {
    return {
      name: '',
      phone: '',
      comment: '',
    }
  },
  computed: mapGetters(['products']),
  methods: {
    sendForm(event) {
      event.target.classList.add('was-validated')

      if (!event.target.checkValidity()) {
        return;
      }

      let products = this.products.map(product => {
        return {
          product_id: product.id,
          count: product.count,
          price: product.price,
        }
      })

      fetch('/order/create', {
        method: 'post',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf"]').content
        },
        body: JSON.stringify({
          name: this.name,
          phone: this.phone,
          comment: this.comment,
          products: products,
        })
      })
        .then(res => {
          if (!res.ok) throw res

          return res.json()
        })
        .then(res => window.location.href = res.redirectUrl)
        .catch(err => alert('Помилка, замовлення не вдалось створити!'))
    }
  }
}
</script>