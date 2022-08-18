<template>
  <div class="my_gallery">
    <ImageGallery :items="pictures" :options="options"/>
  </div>
</template>

<script>
import ImageGallery from 'vue3-picture-swipe'

export default {
  name: 'Gallery',
  props: {
    product: {
      type: Object,
      required: true,
    }
  },
  components: {
    ImageGallery,
  },
  data() {
    return {
      options: {
        bgOpacity: 0.9
      }
    }
  },
  computed: {
    pictures() {
      return this.product.gallery
    }
  }
}
</script>

<style>
.my-gallery {
  display: block;
}

.my-gallery figure {
  display: inline-block;
  height: 100px;
  margin: 3px;
}

.my-gallery figure img {
  height: 100px;
}

.my-gallery figcaption {
  display: none;
}

figure:first-child {
  width: 100%;
  height: 100%;
}

figure:first-child img {
  height: 100%;
  width: 100%;
}

</style>