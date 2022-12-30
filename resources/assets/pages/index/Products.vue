<template>
  <div>
    <ul class="honey__list list">
      <ProductItem v-for="product in category.products" :key="product.id" :product="product"/>
    </ul>

    <div class="ct-linc__adn" v-if="category.productsCount < category.allProductsCount">
      <a class="container__link" :href="category.url">
        Всі товари
        <svg class="container__svg">
          <use href="/images/icons.svg#icon-strilka"></use>
        </svg>
      </a>
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