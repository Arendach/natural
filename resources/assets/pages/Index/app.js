import {createApp} from 'vue'
import store from "../../store"
import VueLazyLoad from "vue-lazyload"
import Index from './Index'
import Cart from "../../components/cart/Cart"

createApp({})
  .component('index', Index)
  .use(store)
  .use(VueLazyLoad, {loading: '/images/no_photo.png'})
  .mount('#index-app')

createApp({})
  .component('cart', Cart)
  .use(store)
  .use(VueLazyLoad, {loading: '/images/no_photo.png'})
  .mount('#cart-app')