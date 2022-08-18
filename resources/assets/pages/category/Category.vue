<template>
  <Banners :banners="banners"/>

  <div v-if="category.products.length">
    <h2 class="category-title" v-html="category.title"></h2>
    <div class="category-description" v-html="category.description"></div>
    <div class="container">
      <Products :products="category.products"/>
    </div>
  </div>

  <h2 v-show="!category.products.length" style="text-align: center; margin: 100px 0">Тут порожньо:(</h2>
</template>

<script>
import Categories from "@/pages/index/Categories"
import Banners from "@/pages/index/Banners"
import Products from '@/pages/category/Products'

export default {
  name: 'Category',
  components: {
    Categories,
    Banners,
    Products,
  },
  props: {
    banners: {
      type: Array,
      required: true,
    },
    category: {
      type: Object,
      required: true,
    },
  }
}
</script>