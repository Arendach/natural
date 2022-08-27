import {createApp} from 'vue'
import VueCookies from 'vue-cookies'
import store from '@/store'
import VueLazyLoad from 'vue-lazyload'
import Category from '@/pages/category/Category'
import Cart from '@/components/cart/Cart'
import ScrollUp from "@/components/common/ScrollUp";

createApp({})
  .component('category', Category)
  .use(store)
  .use(VueCookies)
  .use(VueLazyLoad, {loading: '/images/no_photo.png', error: '/images/no_photo.png'})
  .mount('#category-app')

createApp({})
  .component('cart', Cart)
  .use(store)
  .use(VueCookies)
  .use(VueLazyLoad, {loading: '/images/no_photo.png', error: '/images/no_photo.png'})
  .mount('#cart-app')

createApp({})
  .component('scroll-up', ScrollUp)
  .mount('#scroll-up')