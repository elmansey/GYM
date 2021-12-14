<template>
  <div class="container-fluid">
    <div class="row">
      <!--      <div class="col-xl-7">-->
      <!--        <img-->
      <!--          class="bg-img-cover bg-center"-->
      <!--          :src="require('@/assets/images/login/2.jpg').default"-->
      <!--          alt="looginpage"-->
      <!--        />-->
      <!--      </div>-->
      <div class="col-xl-12 p-0">
        <div class="login-card">
          <div>
            <!-- <div >
                            <a class="logo text-center mb-3" >
                                <img
                                    class="img-fluid for-light"
                                    :src="require('@/assets/images/avtar/3.jpg').default"
                                    style="width: 60px;height: 60px;border-radius:50%;margin: auto;"
                                    alt="looginpage"
                                />
                                <img
                                    class="img-fluid for-dark"
                                 :src="require('@/assets/images/avtar/3.jpg').default"
                                    style="width: 60px;height: 60px;border-radius:50%;"
                                    alt="looginpage"
                                />
                            </a>
                        </div> -->
            <div class="login-main login-form-card">
              <form class="theme-form" method="post" @submit.prevent="login">
                <h4>{{ $t("Sign in to account") }}</h4>
                <p>{{ $t("Enter your email & password to login") }}</p>
                <div class="form-group">
                  <label class="col-form-label">{{ $t("email") }}</label>
                  <input
                    :class="[
                      'form-control',
                      this.$store.getters.AllError.email ? 'is-invalid' : '',
                    ]"
                    type="email"
                    :placeholder="$t('email')"
                    v-model="user.email"
                  />
                  <div
                    v-if="this.$store.getters.AllError.email"
                    style="color: red"
                  >
                    {{ this.$store.getters.AllError.email[0] }}
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-form-label">{{ $t("password") }}</label>
                  <input
                    :class="[
                      'form-control',
                      this.$store.getters.AllError.password ? 'is-invalid' : '',
                    ]"
                    type="password"
                    name="login[password]"
                    :placeholder="$t('password')"
                    v-model="user.password"
                  />

                  <div
                    v-if="this.$store.getters.AllError.password"
                    style="color: red"
                  >
                    {{ this.$store.getters.AllError.password[0] }}
                  </div>
                </div>
                <div class="form-group mb-0">
                  <button class="btn btn-primary btn-block" type="submit">
                    {{ $t("Sign in") }}
                  </button>
                </div>
              </form>
              <h6 class="mt-3">
                <router-link :to="{ name: 'forgotPassword' }"
                  >{{ $t("forget password") }} ?</router-link
                >
              </h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        email: "",
        password: "",
      },
    };
  },

  methods: {
    login() {
      this.$store.dispatch("loginUser", this.user);
    },
  },
};
</script>
