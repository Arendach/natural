<template>
  <div class="form-group">
    <label for="name">Імя</label>
    <input id="name" name="name" class="form-control form-control-sm" required>
  </div>

  <div class="form-group">
    <label for="phone">Номер телефону</label>
    <input pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" required id="phone" name="phone"
           class="form-control form-control-sm">
  </div>

  <div class="form-group">
    <label for="comment">Коментар</label>
    <textarea class="form-control form-control-sm" name="comment" id="comment"></textarea>
  </div>
</template>

<script>
export default {
  name: 'OrderForm',
}
</script>