<template>
  <div class="card pmd-card col-6 mx-auto mt-5">
    <div class="card-body">
      <div class="tab-content">
        <div id="home-fixed" role="tabpanel" class="tab-pane active">
          <LoginForm />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LoginForm from '../components/LoginForm.vue'

export default {
  components: {
    LoginForm,
  },
  data() {
    return {
      tab: 1,
    }
  },
}
</script>
