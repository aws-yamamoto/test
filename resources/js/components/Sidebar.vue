<template>
  <div id="main_view" :class="[{ collapsed: collapsed }]">
    <div class="main_view">
      <RouterView />
      <sidebar-menu
        style="padding-top: 64px"
        :menu="menu"
        :collapsed="collapsed"
        :theme="'default-theme'"
        :show-one-child="true"
        @collapse="onCollapse"
      />
    </div>
  </div>
</template>

<script>
import route from '../config/route'

const separator = {
  template: `<hr style="border-color: rgba(0, 0, 0, 0.1); margin: 20px;">`,
}

export default {
  name: 'App',
  data() {
    return {
      menu: [
        {
          header: true,
          title: '店舗管理',
        },
        {
          href: '',
          title: '店舗情報',
          icon: 'fas fa-store',
          child: [
            {
              href: `/${route.SHOP_LIST}`,
              title: '店舗一覧',
              icon: 'fas fa-folder',
            },
          ],
        },
        {
          header: true,
          component: separator,
          visibleOnCollapse: true,
        },
        {
          header: true,
          title: '商品管理',
        },
        {
          href: '',
          title: '商品情報',
          icon: 'fas fa-utensils',
          child: [
            {
              href: `/${route.PRODUCT_CATEGORY_LIST}`,
              title: '商品カテゴリ管理',
              icon: 'fas fa-folder',
            },
            {
              href: `/${route.PRODUCT}`,
              title: '商品管理',
              icon: 'fas fa-hamburger',
            },
          ],
        },
        {
          header: true,
          component: separator,
          visibleOnCollapse: true,
        },
        {
          header: true,
          title: '設定',
        },
        {
          href: '',
          title: '設定',
          icon: 'fas fa-cogs',
          child: [],
        },
      ],
      collapsed: false,
      themes: ['', 'white-theme'],
      selectedTheme: 'white-theme',
    }
  },
  methods: {
    onCollapse(collapsed) {
      this.collapsed = collapsed
    },
  },
}
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600');

body,
html {
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Source Sans Pro', sans-serif;
  background-color: #f2f4f7;
}
.v-sidebar-menu.vsm-collapsed > .vsm-list,
.v-sidebar-menu.vsm-default.default-theme {
  padding-top: 56px;
}

#main_view {
  padding-left: 350px;
}
#main_view.collapsed {
  padding-left: 50px;
}

.main_view {
  padding: 50px;
}

.container {
  max-width: 600px;
}

pre {
  color: #2a2a2e;
  background: #fff;
  border-radius: 2px;
  padding: 10px;
  overflow: auto;
}
</style>
