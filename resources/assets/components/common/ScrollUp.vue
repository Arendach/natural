<template>
  <Transition>
    <div class="scroll-up" @click="scrollToTop" v-if="isShow">
      <svg class="scroll-up__sircle" viewBox="-2 -2 52 52">
        <path
          class="scroll-up__sircle-path"
          d="
    M24,0
    a24,24 0 0,1 0,48
    a24,24 0 0,1 0,-48"
        />
      </svg>
      <svg class="scroll-up__icon">
        <use href="/images/icons.svg#icon-halochke-top"></use>
      </svg>
    </div>
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