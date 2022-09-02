<template>
  <Transition>
    <a
      href="#"
      class="scroll-up"
      @click="scrollToTop"
      v-if="isShow"
    ></a>
  </Transition>
</template>

<script>
export default {
  name: 'ScrollUp',
  data() {
    return {
      isShow: false,
    }
  },
  created() {
    window.addEventListener('scroll', () => {
      this.isShow = window.scrollY > 100
    }, {passive: true})
  },
  methods: {
    scrollToTop() {
      window.scrollTo(0, 0)
    }
  }
}
</script>

<style>
.v-enter-active,
.v-leave-active {
  transition: all 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>