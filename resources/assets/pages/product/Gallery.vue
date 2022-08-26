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
      return [
        this.product.main_picture,
        ...this.product.gallery,
      ]
    }
  }
}
</script>

<style>
.my-gallery {
  display: block;
  text-align: left;
}

.my-gallery figure {
  display: inline-block;
  height: 100px;
  margin: 3px;
}

.my-gallery figure a {
  display: inline-block;
}

.my-gallery figure img {
  height: 100px;
  display: inline-block;
}

.my-gallery figcaption {
  display: none;
}

.my-gallery figure:first-child {
  width: 100%;
  height: 100%;
  display: block;
}

.my-gallery figure:first-child img {
  height: 100%;
  width: 100%;
}

</style>