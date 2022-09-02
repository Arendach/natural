<template>
  <div>
    <Banners :banners="banners"/>

    <Categories :categories="categories" v-show="categories.length"/>

    <h2 v-show="!categories.length" style="text-align: center; margin: 100px 0">Тут порожньо:(</h2>
  </div>
</template>

<script>
import Categories from "@/pages/index/Categories"
import Banners from "@/pages/index/Banners"

export default {
  name: 'Index',
  components: {
    Categories,
    Banners,
  },
  props: {
    banners: {
      type: Array,
      required: true,
    },
    categories: {
      type: Array,
      required: true,
    },
  }
}
</script>