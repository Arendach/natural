<template>
  <div>
    <section class="section" v-for="category in categories" v-show="categories.length">
      <div class="container">
        <h2 class="section__title" v-html="category.title"></h2>
        <div class="ct-border"></div>
        <h3 class="section__title-h3" v-html="category.description"></h3>
        <Products :category="category"/>
      </div>
    </section>
  </div>
</template>

<script>
import Products from "@/pages/index/Products"

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