<template>
  <div>
    <Breadcrumbs main="dashboard" title="team Chat" />
    <!-- Container-fluid starts-->
    <div class="container-fluid">

        <div class="row">

            <div class="col call-chat-sidebar col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body chat-body">

                <div  class="chat-box">
                    <!-- Chat left side Start-->
                    <div class="chat-left-aside">
                    <div class="media">
                        <router-link
                        :to="{name : 'TeamChat'}"

                        >
                            <img
                            class="rounded-circle user-image"
                                :src=" this.$store.getters.USER['profile_picture'] ? '../../profile_pictures/'+this.$store.getters.USER['profile_picture'] :  '../../profile_pictures/DefaultProfile.jpg'"
                                style="cursor: pointer;"
                                alt=""
                            />
                        </router-link>


                        <div class="about">
                        <div class="name f-w-600">
                            {{ this.$store.getters.USER.name ? this.$store.getters.USER.name : this.$store.getters.USER.firstName }}
                        </div>
                        <div class="status">Status...</div>
                        </div>
                    </div>
                    <div class="people-list custom-scrollbar" id="people-list">
                        <div class="search">
                        <form class="theme-form">
                            <div class="form-group">
                            <input
                                v-model="search"
                                class="form-control"
                                type="text"
                                placeholder="search"
                            /><i class="fa fa-search"></i>
                            </div>
                        </form>
                        </div>

                            <div v-if="isloading">
                                <ul  class="list" >
                                    <label>staff</label>
                                <li
                                    class="clearfix"
                                    v-for="(staff,index) in AllstaffTeamToChat"
                                    :key="index"
                                    style="cursor: pointer;"

                                >
                                    <img
                                    class="rounded-circle user-image"
                                    :src=" staff.profile_picture   ? '../../profile_pictures/'+staff.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                    alt=""
                                    @click.prevent="getOldMessageInChat(staff.Personal_uuid)"
                                    />
                                    <div class="status-circle away"></div>
                                    <div class="about">
                                    <div class="name"
                                    @click.prevent="getOldMessageInChat(staff.Personal_uuid)"
                                    >{{ staff.firstName }}</div>
                                    <div class="status"
                                    @click.prevent="getOldMessageInChat(staff.Personal_uuid)"
                                    >{{ staff.email }}</div>
                                    </div>
                                </li>
                                <div >
                                    <div v-if="!AllstaffTeamToChat && !AlladminTeamToChat" class="search-not-found chat-search text-center">
                                    <div>
                                        <!-- <img src="../../assets/images/search-not-found.png" alt="" class="second-search"> -->
                                        <p>
                                        Sorry, We didn't find any results matching this
                                        search
                                        </p>
                                    </div>
                                    </div>
                                </div>
                                </ul>

                                <ul class="list" >
                                    <label>admin</label>

                                    <li
                                        class="clearfix"
                                        v-for="(admin,key) in AlladminTeamToChat"
                                        :key="key"
                                        style="cursor: pointer;"
                                    >
                                        <img
                                        class="rounded-circle user-image"
                                        :src=" admin.profile_picture   ? '../../profile_pictures/'+admin.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                        alt=""
                                    @click.prevent="getOldMessageInChat(admin.Personal_uuid)"

                                        />
                                        <div class="status-circle away"></div>
                                        <div class="about">
                                        <div class="name"
                                        @click.prevent="getOldMessageInChat(admin.Personal_uuid)"

                                        >{{ admin.name }}

                                        </div>
                                        <div class="status"
                                        @click.prevent="getOldMessageInChat(admin.Personal_uuid)"

                                        >{{ admin.email }}</div>
                                        </div>
                                    </li>
                                <div >
                                    <div v-if="!AllstaffTeamToChat && !AlladminTeamToChat" class="search-not-found chat-search text-center">
                                    <div>
                                        <!-- <img src="../../assets/images/search-not-found.png" alt="" class="second-search"> -->
                                        <p>
                                        Sorry, We didn't find any results matching this
                                        search
                                        </p>
                                    </div>
                                    </div>
                                </div>
                                </ul>
                            </div>

                            <div
                                v-else
                                class="col-md-3"
                                style="width: 60px!important;height: 60px!important;margin: auto; position: absolute;top: 50%; right: 50%;transform: translate(50%,-50%);"
                            >


                            <h6 class="sub-title mb-0 text-center"></h6>
                                <div class="loader-box">
                                    <div class="loader-15"></div>
                                </div>
                            </div>
                    </div>
                    </div>
                    <!-- Chat left side Ends-->
                </div>


                </div>
            </div>
            </div>


            <div v-if="chatting" class="col col-lg-6 col-xl-8 call-chat-body">
                <div class="card">
                    <div class="card-body p-0">
                        <div   class="row chat-box" >
                            <!-- Chat right side start-->
                            <div class="col pr-0 chat-right-aside"  >
                            <!-- chat start-->
                            <div class="chat" >
                                <!-- chat-header start-->
                                <div class="chat-header clearfix">
                                <img
                                    class="rounded-circle"
                                :src=" reseverInfo.profile_picture   ? '../../profile_pictures/'+reseverInfo.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                    alt=""
                                />

                                <div class="about">
                                    <div class="name" style="margin-top:20px !important;">
                                        {{ reseverInfo.name ? reseverInfo.name : reseverInfo.firstName }}

                                    <!--<span class="font-primary f-12">Typing...</span>-->
                                    </div>

                                </div>

                                </div>
                                <!-- chat-header end-->
                                <div class="chat-msg-box " ref="lastMessage"   >
                                <ul>
                                    <li>
                                    <div class="message"  style="width: 100%;" >


                                                    <div

                                                        v-for="(message , index) in oldMessage"
                                                        :key="index"
                                                        :class="['message-data' ,message.from == $store.getters.USER.Personal_uuid ? 'text-left float-left bg-dark  block' : 'text-right ,bg-light float-right block']"
                                                        style="padding:5px 7px;border-radius:20px 20px 0px 20px;width:40%;box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px ;word-wrap: break-word!important;overflow-wrap: anywhere;  clear: both; display: table;"
                                                    >

                                                    <div class="row">



                                                        <img
                                                        :class="['rounded-circle', 'float-left', 'chat-user-img' ]"
                                                        alt=""
                                                        v-if="message.from == $store.getters.USER.Personal_uuid"
                                                        :src=" senderInfo.profile_picture   ? '../../profile_pictures/'+senderInfo.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                                         style="width:20px;height: 20px;"
                                                        />
                                                        <img
                                                        :class="['rounded-circle', 'float-right', 'chat-user-img']"
                                                        alt=""
                                                        v-if="message.from != $store.getters.USER.Personal_uuid"
                                                        :src="  reseverInfo.profile_picture   ? '../../profile_pictures/'+reseverInfo.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                                        style="width:20px;height: 20px;"
                                                        />




                                                            {{  message.message }}

                                                        </div>





                                                    <!-- <span class="message-data-time">

                                                    </span> -->
                                                </div>




                                    </div>

                                    </li>
                                </ul>
                                </div>
                                <!-- end chat-history-->

                                <form @submit.prevent="handelSubmitFormMessage" style="width:80%!important;margin:auto!important">
                                    <div class="chat-message" style="width:80%!important;margin:auto!important">
                                        <div class="row" style="width:100%!important;height: 100%;!important;padding: 0px;!important;margin:0px" >
                                            <div class="col-xl-12 d-flex" style="height: 100%!important;padding: 0px;!important;margin:0px">

                                                    <input
                                                        class="input-txt-bx"
                                                        v-model="chatInfo.message"
                                                        style="border:none;!important;width:100%;padding: 0px;!important;margin:auto"
                                                        type="text"
                                                        name="message-to-send"
                                                        placeholder="   Say something......"
                                                    />

                                                    <div>
                                                        <button class="btn btn-dark btn-sm" type="submit" style="border-radius:50%;padding:12px 13px" >
                                                        <i  class="fa fa-send center" ></i>
                                                        </button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- end chat-message-->
                                <!-- chat end-->
                                <!-- Chat right side ends-->
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


      </div>
    </div>

    <!-- Container-fluid Ends-->
  </div>
</template>
<script>
import axios from "axios";

export default {
  name: "Chat",
  data() {
    return {
      text: "",
      search: "",
      currentchat: [],
      chatmenutoogle: false,


      AllstaffTeamToChat:[],
      AlladminTeamToChat:[],
      chatting:false,
      isloading:false,

      chatInfo:{
          from:'',
          to:'',
          message:''
      },
      senderInfo:'',
      reseverInfo:'',
      oldMessage:[]
    };
  },

  beforeMount(){

      axios.get(`getStaffToChatIgnoreMe/${this.$store.getters.USER.email}`)
      .then(res => {
          this.AllstaffTeamToChat = res.data.staff
          this.isloading = true
      })
      .catch(err => {
          console.error(err);
      })

      axios.get(`getUserToChatIgnoreMe/${this.$store.getters.USER.email}`)
      .then(res => {
          this.AlladminTeamToChat = res.data.admins
          this.isloading = true

      })
      .catch(err => {
          console.error(err);
      })


      this.chatInfo.from = this.$store.getters.USER.Personal_uuid
  },
  components: {},

  mounted() {

  },

  methods: {

    getOldMessageInChat(Personal_uuid){

         this.chatInfo.to  =   Personal_uuid

         let formData = new FormData();
         formData.append("from", this.chatInfo.from)
         formData.append("to", this.chatInfo.to)

        axios.post('getOldMessageInChat',formData)
        .then(res => {

            this.oldMessage = res.data.messages
            this.senderInfo = res.data.from
            this.reseverInfo = res.data.to
           this.scrollChatToLastMessage()
            this.chatting = true

        })
        .catch(err => {
            console.error(err);
        })
    },



    scrollChatToLastMessage(){
        setTimeout(() => {

           this.$refs.lastMessage.scrollTop =  this.$refs.lastMessage.scrollHeight -  this.$refs.lastMessage.clientHeight

        },50)

    },

    handelSubmitFormMessage(){

        let  formData =  new FormData();
        formData.append("message", this.chatInfo.message);
        formData.append("from", this.chatInfo.from);
        formData.append("to", this.chatInfo.to);



        axios.post('addMessageInTeamChat',formData)
        .then(res => {

            if(res.data.success){
                this.chatInfo.message = ''
                this.oldMessage.push(res.data.message)
                this.scrollChatToLastMessage()
            }
        })
        .catch(err => {
            console.error(err);
        })



    }


  },

  watch: {



  }
};
</script>

