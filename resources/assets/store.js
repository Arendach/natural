import {createStore} from 'vuex'
import cookie from 'vue-cookies'

export default createStore({
  state: {
    cartModalOpen: false,
    products: [],
  },
  getters: {
    cartModalOpen: (state) => {
      return state.cartModalOpen
    },
    products: (state) => {
      return state.products
    },
    productsCount: (state) => {
      return state.products.map(product => product.count).reduce((a, b) => a + b, 0)
    },
    productsSum: (state) => {
      return state.products.map(product => product.count * product.price).reduce((a, b) => a + b, 0)
    },
  },
  mutations: {
    setCartModalOpen(state, flag) {
      state.cartModalOpen = flag
    },
    addProduct(state, product) {
      let foundProduct = state.products.filter(item => item.id === product.id)
      if (foundProduct.length === 1) {
        return state.products.map(item => {
          if (item.id === foundProduct[0].id) item.count++
          return item
        })
      }

      state.products.push(product)
    },
    changeCount(state, {product, action}) {
      state.products = state.products.map((item) => {
        if (item.id === product.id) item.count = action === 'minus' ? item.count - 1 : item.count + 1

        return item
      })
        .filter(item => item.count)
    },
    removeProduct(state, product) {
      state.products = state.products.filter(item => item.id !== product.id)
    }
  },
  actions: {
    addProduct({commit, dispatch}, product) {
      commit('addProduct', {...product, count: product.count || 1})

      dispatch('setCookies')
    },
    changeCount({commit, getters, dispatch}, {action, product}) {
      commit('changeCount', {action, product})

      dispatch('setCookies')

      if (getters.products.length === 0) {
        commit('setCartModalOpen', false)
      }
    },
    removeProduct({commit, getters, dispatch}, product) {
      commit('removeProduct', product)

      dispatch('setCookies')

      if (getters.products.length === 0) {
        commit('setCartModalOpen', false)
      }
    },
    setCookies({getters}) {
      cookie.set('cartProducts', JSON.stringify(getters.products.map(product => ({id: product.id, count: product.count}))))
    }
  }
})