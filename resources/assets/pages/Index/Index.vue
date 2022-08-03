<template>
  <Categories :categories="categories" v-show="categories.length"/>

  <h2 v-show="!categories.length" style="text-align: center; margin: 100px 0">Тут порожньо:(</h2>
</template>

<script>
import Categories from "./Categories"

export default {
  name: 'Index',
  components: {Categories},
  props: {
    categories: {
      type: Array,
      required: true,
    }
  }
}
</script>