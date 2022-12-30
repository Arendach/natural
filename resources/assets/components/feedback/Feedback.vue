<template>
  <button class="chat-button" @click="isOpened = true">
    <svg class="feedback__phone-icon">
      <use href="/images/icons.svg#icon-phone"></use>
    </svg>
  </button>

  <div :class="{'is-hidden': !isOpened, modal: true}">
    <div class="modal-window">
      <div class="m-f">
        <h2 class="modal-title">Перетелефонуйте мені</h2>
        <button class="modal-button" @click="closeModal">
          <svg class="modal-svg">
            <use href="/images/icons.svg#icon-close"></use>
          </svg>
        </button>
      </div>

      <form @submit.prevent="sendForm">
        <input
          v-model="name"
          minLength="2"
          maxLength="255"
          placeholder="Ваше ім'я"
          required
        />

        <br>

        <input
          v-model="phone"
          minLength="10"
          maxLength="10"
          placeholder="Ваш номер телефону"
          required
          pattern="^0[0-9]{9}$"
        />

        <br>

        <textarea
          v-model="message"
          placeholder="Коментар до замовлення"
        ></textarea>

        <br>

        <button type="submit">
          Залишити заявку
        </button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Feedback',
  data() {
    return {
      isOpened: false,
      name: '',
      phone: '',
      message: '',
    }
  },
  methods: {
    closeModal() {
      this.isOpened = false
    },
    sendForm(event) {
      fetch('/feedback/create', {
        method: 'post',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf"]').content
        },
        body: JSON.stringify({
          name: this.name,
          phone: this.phone,
          message: this.message,
        })
      })
        .then(res => {
          if (!res.ok) throw res

          return res.json()
        })
        .then(res => window.location.href = res.redirectUrl)
        .catch(err => alert('Помилка, замовлення не вдалось створити!'))
    }
  },
}
</script>