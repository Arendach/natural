<template>
  <div class="feedback-open" @click="isOpened = true">
    <i class="fa fa-phone"></i>
    <span class="d-none d-sm-none d-md-none d-lg-inline d-xl-inline"> Перетелефонуйте мені</span>
  </div>

  <MDBModal v-model="isOpened">
    <MDBModalHeader @close="closeModal">
      <MDBModalTitle id="exampleModalLabel">Перетелефонуйте мені</MDBModalTitle>
    </MDBModalHeader>
    <MDBModalBody>
      <MDBRow tag="form" class="g-4 needs-validation" novalidate @submit.prevent="sendForm">
        <MDBCol col="12">
          <MDBInput
            v-model="name"
            minLength="2"
            maxLength="255"
            label="Ваше ім'я"
            valid-feedback="Чудово! Поле заповнено вірно!"
            invalid-feedback="Упс! Поле заповнено не вірно!"
            validation-event="input"
            required
          />
        </MDBCol>
        <MDBCol col="12">
          <MDBInput
            v-model="phone"
            minLength="10"
            maxLength="10"
            label="Ваш номер телефону"
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
            v-model="message"
            label="Коментар до замовлення"
            invalid-feedback="Упс! Поле заповнено не вірно!"
            validation-event="input"
          />
        </MDBCol>
        <MDBCol col="12">
          <MDBBtn color="primary" type="submit">Залишити заявку</MDBBtn>
        </MDBCol>
      </MDBRow>
    </MDBModalBody>
  </MDBModal>
</template>

<script>
import {
  MDBModal,
  MDBModalHeader,
  MDBModalTitle,
  MDBModalBody,
  MDBModalFooter,
  MDBBtn,
  MDBRow,
  MDBCol,
  MDBInput,
  MDBTextarea,
} from 'mdb-vue-ui-kit'

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
  components: {
    MDBModalBody,
    MDBModalFooter,
    MDBBtn,
    MDBModalTitle,
    MDBModalHeader,
    MDBModal,
    MDBRow,
    MDBCol,
    MDBInput,
    MDBTextarea,
  },
  methods: {
    closeModal() {
      this.isOpened = false
    },
    sendForm(event) {
      event.target.classList.add('was-validated')

      if (!event.target.checkValidity()) {
        return
      }

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