<template>
  <section class="hero section">
    <div class="hero__bg container"></div>
  </section>
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