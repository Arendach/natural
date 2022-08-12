<template>
  <div class="products-cat">
    <ProductItem v-for="product in category.products" :key="product.id" :product="product"/>

    <div class="product-cat" style="text-align: center; display: flex" v-if="category.productsCount < category.allProductsCount">
      <div style="margin: auto">
        <a :href="category.url">
          <img v-lazy="`/images/more.svg`" alt="Більше товарів даної категорії">
        </a>
        <br>
        <a style="font-size: 25px" :href="category.url">
          Більше товарів даної категорії
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import ProductItem from "@/components/products/ProductItem"

export default {
  name: 'Products',
  components: {ProductItem},
  props: {
    category: {
      type: Object,
      required: true,
    },
  }
}
</script>