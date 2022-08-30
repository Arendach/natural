<template>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 centered">
        <Gallery :product="product"></Gallery>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <h1 style="font-size: 32px">
          {{ product.title }}
        </h1>
        <div style="font-size: 80%;">
          Артикул: <span style="font-weight: bolder;">{{ product.article || '' }}</span>
        </div>
        <div style="margin-top: 10px">
          <span v-if="product.is_storage" class="text-success"><i class="fa fa-check"></i> Є в наявності</span>
          <span v-else class="text-danger"><i class="fa fa-remove"></i> Немає в наявності</span>
        </div>
        <div class="product-price alert alert-info">
          <span>Ціна:</span>
          <span class="badge badge-primary" style="font-weight: bolder; font-size: 130%;">
            {{ product.price }} грн
          </span>
          <div style="margin-top: 10px">
            <button class="btn btn-success btn-sm btn-block" @click="addProduct(product)">
              В корзину
            </button>
          </div>
        </div>
        <div style="margin: 10px 0">
          <a
            style="margin-right: 10px"
            target="_blank" :href="link.url"
            v-for="link in socialLinks"
            :key="link.id"
          >
            <img style="display: inline" :src="link.picture" :alt="link.title"> {{ link.title }}
          </a>
        </div>

        <div class="deliveries-list alert alert-success">
          <MDBTabs v-model="activeDeliveryTab" :model-value="activeDeliveryTab">
            <MDBTabNav fill tabsClasses="mb-3">
              <MDBTabItem
                v-for="delivery in deliveries"
                :key="delivery.slug"
                :tabId="delivery.slug"
                :href="delivery.slug"
              >
                <img :src="delivery.picture" :alt="delivery.title"> {{ delivery.title }}
              </MDBTabItem>
            </MDBTabNav>
            <MDBTabContent>
              <MDBTabPane
                v-for="delivery in deliveries"
                :key="delivery.slug"
                :tabId="delivery.slug"
              >
                <div v-html="delivery.description"></div>
              </MDBTabPane>
            </MDBTabContent>
          </MDBTabs>
        </div>

        <div v-html="product.description"></div>
      </div>
    </div>
  </div>
</template>

<script>
import Gallery from '@/pages/product/Gallery'
import {
  MDBTabs,
  MDBTabNav,
  MDBTabContent,
  MDBTabItem,
  MDBTabPane,
} from 'mdb-vue-ui-kit'
import {mapActions} from "vuex"

export default {
  name: 'Product',
  components: {
    Gallery,
    MDBTabs,
    MDBTabNav,
    MDBTabContent,
    MDBTabItem,
    MDBTabPane,
  },
  data() {
    return {
      activeDeliveryTab: 'nova_poshta'
    }
  },
  props: {
    product: {
      type: Object,
      required: true,
    },
    deliveries: {
      type: Array,
      required: true,
    },
    socialLinks: {
      type: Array,
      default: [],
      required: false,
    }
  },
  methods: {
    ...mapActions(['addProduct'])
  },
}
</script>

<style>
.deliveries-list img {
  display: inline;
}
</style>