import Vue from 'vue'
import VueRouter from 'vue-router'

// import Home from '@/views/main/Home.vue'
// import Main from '@/views/main/Main.vue'

import Login from './pages/Login.vue'
import Info from './pages/Info.vue'
import ShopList from './pages/ShopList.vue'
import ShopDetail from './pages/ShopDetail.vue'
import ProductCategoryList from './pages/ProductCategoryList.vue'
import ProductCategoryDetail from './pages/ProductCategoryDetail.vue'
import ProductList from './pages/ProductList.vue'
import ProductDetail from './pages/ProductDetail.vue'

import store from './store'
import route from './config/route'

Vue.use(VueRouter)

const routes = [
  {
    path: `/${route.LOGIN}`,
    component: Login,
    // beforeEnter(to, from, next) {
    //   if (store.getters['auth/check']) {
    //     next('/')
    //   } else {
    //     next()
    //   }
    // },
  },
  {
    // path: '/',
    // component: Main,
    // meta: { requiresAuth: true },
    // children: [
    //   {
    //     path: '/',
    //     component: Home,
    //     name: 'home',
    //   },
    // ],
    path: `/`,
    component: Info,
    meta: { requiresAuth: true },
  },
  {
    path: `/${route.INFO}`,
    component: Info,
    meta: { requiresAuth: true },
  },
  // 店舗
  {
    path: `/${route.SHOP_LIST}`,
    component: ShopList,
    meta: { requiresAuth: true },
  },
  {
    path: `/${route.SHOP_DETAIL}/new`,
    component: ShopDetail,
    meta: { requiresAuth: true },
  },
  {
    path: `/${route.SHOP_DETAIL}/:id`,
    component: ShopDetail,
    props: true,
    meta: { requiresAuth: true },
  },
  // 商品カテゴリ
  {
    path: `/${route.PRODUCT_CATEGORY_LIST}`,
    component: ProductCategoryList,
    meta: { requiresAuth: true },
  },
  {
    path: `/${route.PRODUCT_CATEGORY_LIST}/new`,
    component: ProductCategoryDetail,
    meta: { requiresAuth: true },
  },
  {
    path: `/${route.PRODUCT_CATEGORY_LIST}/:id`,
    component: ProductCategoryDetail,
    props: true,
    meta: { requiresAuth: true },
  },
  {
    path: `/${route.PRODUCT_CATEGORY_LIST}/:categoryId/${route.PRODUCT_CATEGORY}/new`,
    props: true,
    component: ProductCategoryDetail,
    meta: { requiresAuth: true },
  },
  {
    path: `/${route.PRODUCT_CATEGORY_LIST}/:categoryId/${route.PRODUCT_CATEGORY}/:id`,
    component: ProductCategoryDetail,
    props: true,
    meta: { requiresAuth: true },
  },
  // 商品
  {
    path: `/${route.PRODUCT}`,
    component: ProductList,
    meta: { requiresAuth: true },
  },
  {
    path: `/${route.PRODUCT}/new`,
    component: ProductDetail,
    meta: { requiresAuth: true },
  },
  {
    path: `/${route.PRODUCT}/:id`,
    component: ProductDetail,
    props: true,
    meta: { requiresAuth: true },
  },
]

const routePush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
  return routePush.call(this, location).catch(() => {})
}

const router = new VueRouter({
  mode: 'history',
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  base: process.env.BASE_URL,
  routes,
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // 未認証の場合はログインページにリダイレクトします。
    if (!store.getters['auth/check']) {
      console.log('未認証')
      next({
        path: `/${route.LOGIN}`,
        // query: { redirect: to.fullPath },
      })
    } else {
      console.log('認証１')
      next()
    }
  } else {
    console.log('認証２')
    next()
  }
})

export default router
