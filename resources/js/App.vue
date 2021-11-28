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
    <notifications position="top left"  group='app'   />





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
  computed:{

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



                 // get count not read
            var path =    firebase.database().ref("notification")
            path.on('value',(data) => {

                if(data.val() != null){

                    var notifications = Object.values(data.val())
                    var unseen = []
                    this.$store.dispatch('unSeenNotification', unseen)
                    notifications.map((item,index) => {

                        if(item.read == 0){

                            unseen.push(item)

                        }

                    })

                    this.$store.dispatch('unreadNotificationNumber', unseen.length)

                }

            })

            // to get notification content
            var path =    firebase.database().ref("notification").limitToLast(3)
            path.on('value',(data) => {

                if(data.val() != null){

                    var notifications = Object.values(data.val())
                    var unseen = []
                    notifications.map((item,index) => {

                        if(item.read == 0){

                            unseen.push(item)

                        }

                    })

                    unseen.sort(function(a,b){

                            return new Date(b.created_at) - new Date(a.created_at);
                    });


                    this.$store.dispatch('unSeenNotification', unseen)



                }

            })














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
