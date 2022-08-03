import {createStore} from "vuex"

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
          item.count++
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
    addProduct({commit}, product) {
      commit('addProduct', {...product, count: 1})
    },
    changeCount({commit, getters}, {action, product}) {
      commit('changeCount', {action, product})

      if (getters.products.length === 0) {
        commit('setCartModalOpen', false)
      }
    },
    removeProduct({commit, getters}, product) {
      commit('removeProduct', product)

      if (getters.products.length === 0) {
        commit('setCartModalOpen', false)
      }
    }
  }
})