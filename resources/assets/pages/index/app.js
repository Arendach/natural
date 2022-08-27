import {createApp} from 'vue'
import VueCookies from 'vue-cookies'
import store from '@/store'
import VueLazyLoad from 'vue-lazyload'
import Index from '@/pages/index/Index'
import Cart from '@/components/cart/Cart'
import ScrollUp from '@/components/common/ScrollUp'
import Feedback from '@/components/feedback/Feedback'

createApp({})
  .component('index', Index)
  .use(store)
  .use(VueCookies)
  .use(VueLazyLoad, {loading: '/images/no_photo.png', error: '/images/no_photo.png'})
  .mount('#index-app')

createApp({})
  .component('cart', Cart)
  .use(store)
  .use(VueCookies)
  .use(VueLazyLoad, {loading: '/images/no_photo.png', error: '/images/no_photo.png'})
  .mount('#cart-app')

createApp({})
  .component('scroll-up', ScrollUp)
  .mount('#scroll-up')

createApp({})
  .component('feedback', Feedback)
  .mount('#feedback-app')