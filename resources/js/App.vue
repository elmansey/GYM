<template>
  <div id="app">
  <!-- Loader starts-->
    <div class="loader-wrapper" :class="{'loderhide' : !show }">
      <div class="loader-index">
        <span></span>
      </div>
    </div>
  <!-- Loader ends-->

    <!--<Main/>-->

    <router-view></router-view>
  </div>
</template>

<script>
import PulseLoader from "vue-spinner/src/PulseLoader";
import axios from 'axios'
export default {
  name: 'app',

  data(){
    return{
      show: true
    }
  },
  mounted() {
      this.timeOut();
    },
    methods:{
      timeOut(){
            var self = this;
            setTimeout(function(){
                self.show = false;
            }, 1000);
      }
    },
    beforeMount() {
      if(!this.$store.getters.authentication   && this.$store.getters.AUTH_TOKEN ){
          this.$store.dispatch('userInfo')
      }


        axios.get('allSetting')
        .then(res => {

            if(res.data.success){

                this.$store.dispatch('SETTINGS',res.data.setting.setting)
            }


        })
        .catch(err => {
            console.error(err);
        })


    }
}
</script>

<style lang="scss" scoped>
.loader-wrapper.loderhide {
  display: none;
}
</style>
