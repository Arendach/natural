<template>
  <div v-for="category in categories" v-show="categories.length">
    <h2 class="category-title" v-html="category.title"></h2>
    <div class="category-description" v-html="category.description"></div>
    <div class="container">
      <Products :category="category"/>
    </div>
  </div>
</template>

<script>
import Products from "@/pages/Index/Products"

export default {
  name: 'Categories',
  components: {Products},
  props: {
    categories: {
      type: Array,
      required: true,
    }
  }
}
</script>