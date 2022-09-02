<template>
  <Carousel :items-to-show="1" :autoplay="5000" :wrap-around="true" :transition="500">
    <Slide v-for="banner in banners" :key="banner.id">
      <div class="banner">
        <div class="d-none d-lg-block">
          <img
            :src="banner.picture_desktop"
            :alt="banner.title"
            style="width: 100%"
            width="1920"
            height="400"
          >
        </div>
        <div class="d-block d-lg-none">
          <img
            :src="banner.picture_mobile"
            :alt="banner.title"
            style="width: 100%"
            width="991"
            height="400"
          >
        </div>
      </div>
    </Slide>
  </Carousel>
</template>

<script>
import {Carousel, Slide} from 'vue3-carousel'

export default {
  name: 'Banners',
  props: {
    banners: {
      type: Array,
      required: true,
    },
  },
  components: {
    Carousel,
    Slide,
  }
}
</script>

<style>
.banner {
  width: 100%;
}
</style>