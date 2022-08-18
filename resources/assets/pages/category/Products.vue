<template>
  <div class="products-cat">
    <ProductItem v-for="product in products" :key="product.id" :product="product"/>
  </div>
</template>

<script>
import ProductItem from '@/components/products/ProductItem'

export default {
  name: 'Products',
  components: {ProductItem},
  props: {
    products: {
      type: Array,
      required: true,
    },
  }
}
</script>