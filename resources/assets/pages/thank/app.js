import {createApp} from 'vue'
import VueLazyLoad from "vue-lazyload"
import Thank from '@/pages/thank/Thank'

createApp({})
  .component('thank', Thank)
  .use(VueLazyLoad, {loading: '/images/no_photo.png', error: '/images/no_photo.png'})
  .mount('#thank-app')