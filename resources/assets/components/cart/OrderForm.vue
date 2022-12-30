<template>
  <form
    @submit.prevent="sendForm"
    class="modal-form"
    name="signup_form"
    autocomplete="on"
    novalidate
  >
    <h2 class="modal-form__title">
      Контактні дані
    </h2>
    <div class="form-containrt__label">
      <label class="modal-form__label">
        <input
          v-model="name"
          class="modai-form__input"
          type="text"
          placeholder="Ваше ім’я"
        />
      </label>
      <label class="modal-form__label">
        <input
          v-model="phone"
          class="modai-form__input"
          type="text"
          name="phone"
          placeholder="Ваш номер телефону"
        />
      </label>
    </div>
    <textarea
      v-model="comment"
      class="modal-form__textarea"
      placeholder="Коментар до замовлення"
    ></textarea>
    <button type="submit" class="button form-button__submit">
      Оформити замовлення
    </button>
  </form>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
  name: 'OrderForm',
  components: {},
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