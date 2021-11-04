<template>
  <div>
    <Breadcrumbs main="dashboard" title="team Chat" />
    <!-- Container-fluid starts-->
    <div class="container-fluid">





        <div class="col call-chat-body" >
          <div class="card">
            <div class="card-body p-0">
              <div class="row chat-box">
                <!-- Chat right side start-->
                <div class="col pr-0 chat-right-aside">
                  <!-- chat start-->
                  <div class="chat mb-0 pb-0"  >
                    <!-- chat-header start-->
                    <div class="chat-header clearfix">
                          <img
                                class="rounded-circle"
                                :src=" reseverInfo.profile_picture   ? '../../profile_pictures/'+reseverInfo.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                alt=""
                              v-if="chatting"
                         />
                      <div class="about">
                        <div class="name">
                            <div class="name" style="margin-top:20px !important;" v-if="chatting">
                                {{ reseverInfo.name ? reseverInfo.name : reseverInfo.firstName }}

                            <!--<span class="font-primary f-12">Typing...</span>-->
                            </div>
                        </div>
                        <div class="status digits">

                        </div>
                      </div>
                      <ul
                        class="list-inline float-left float-sm-right chat-menu-icons"
                      >

                        <li
                          class="list-inline-item toogle-bar"
                           v-on:click="chatmenutoogle = !chatmenutoogle"
                        >
                          <a href="#"><i class="icon-menu"></i></a>
                        </li>
                      </ul>
                    </div>
                    <!-- chat-header end-->
                    <div class="chat-history chat-msg-box custom-scrollbar"  ref="lastMessage">
                      <ul>
                        <li

                        >
                          <div
                            class="message "
                            style="width:100%;">

                                <div
                                v-for="(message , index) in oldMessage"
                                        :key="index"
                                        :class="[message.from == $store.getters.USER.Personal_uuid ? ' float-left block '  : ' float-right block ']"
                                        style="clear: both ; "
                                >
                                    <div class="card d-inline-block mb-3 float-right"  style="background-color:#F3F1F5;border-radius:15px">

                                        <div class="card-body "  >
                                                <div class="d-flex flex-row pb-1">

                                                    <img   v-if="message.from == $store.getters.USER.Personal_uuid" alt=""
                                                    :src=" senderInfo.profile_picture   ? '../../profile_pictures/'+senderInfo.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                                    class="img-thumbnail  border-0 rounded-circle  mr-3  list-thumbnail align-self-center "
                                                    style="width:40px;hight:40px"
                                                    >


                                                    <img  v-if="message.from != $store.getters.USER.Personal_uuid"
                                                    alt=""
                                                    :src="  reseverInfo.profile_picture   ? '../../profile_pictures/'+reseverInfo.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                                    class="img-thumbnail  border-0 rounded-circle  mr-3  list-thumbnail align-self-center "
                                                        style="width:40px;hight:40px"
                                                    >

                                                    <div class="d-flex flex-grow-1 min-width-zero">
                                                        <div class="m-2 pl-0  align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero ">
                                                            <div class="min-width-zero">
                                                                <p class="mb-0 truncate list-item-heading">


                                                                    <span v-if="message.from == $store.getters.USER.Personal_uuid" >
                                                                        {{ senderInfo.name ? senderInfo.name : senderInfo.firstName  }}
                                                                    </span>
                                                                    <span v-if="message.from != $store.getters.USER.Personal_uuid" >
                                                                        {{ reseverInfo.name ? reseverInfo.name : reseverInfo.firstName  }}
                                                                    </span>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="chat-text-left" >
                                                    <p class="mb-0 text-semi-muted" style="max-width:200px; word-wrap:break-word;font-size:16px" >
                                                        {{  message.message }}
                                                    </p>
                                                </div>

                                            <div class=" pt-1 pr-2 r-0 float-left">
                                                <span v-for="(time,index) in message.time" :key="index" class="text-extra-small text-muted  m-3" style="font-size:9px!important;">
                                                    {{ time  }}
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>


                          </div>
                        </li>

                      </ul>
                    </div>
                    <!-- end chat-history-->
                                <form v-if="chatting" @submit.prevent="handelSubmitFormMessage" style="width:80%!important;margin:auto!important">
                                    <div class="chat-message" style="width:80%!important;margin:auto!important">
                                        <div class="row" style="width:100%!important;height: 100%;!important;padding: 0px;!important;margin:0px" >
                                            <div class="col-xl-12 d-flex" style="height: 100%!important;padding: 0px;!important;margin:0px">

                                                     <input
                                                        class="input-txt-bx"
                                                        v-model="chatInfo.message"
                                                        style="border:none;!important;width:100%;padding: 15px;!important;margin:auto"
                                                        type="text"
                                                        name="message-to-send"
                                                        placeholder="   Say something......"
                                                    />


                                                    <div>
                                                        <button class="btn btn-dark btn-sm" type="submit" style="border-radius:50%;padding:12px 14px" >
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
                <div
                  class="col pl-0 chat-menu custom-scrollbar"
                  :class="{ show: chatmenutoogle }"
                >
                  <b-tabs
                    nav-class="tabbed-card border-tab border-tab-primary custom-scrollbar"
                  >
                    <b-tab title="team" active style="margin:5px!important;padding:0px!important;">
                      <div class="people-list"  v-if="isloading">
                        <ul class="list digits">
                          <li
                            class="clearfix mb-3 border-bottom pb-3 "
                            v-for="(admin,key) in AlladminTeamToChat"
                            :key="key"
                            style="cursor: pointer; padding: 12px;!important;margin:0px!important"
                          >
                            <img
                              class="rounded-circle user-image"
                            :src=" admin.profile_picture   ? '../../profile_pictures/'+admin.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                             alt=""
                             @click.prevent="getOldMessageInChat(admin.Personal_uuid)"
                            />
                            <div class="about">
                             <div class="name"
                                @click.prevent="getOldMessageInChat(admin.Personal_uuid)"

                                >{{ admin.name }}

                            </div>
                              <div class="status"  style="display: flex;">
                                 <i class="fa fa-briefcase" style="margin: 6px;"></i>
                                  <p> {{  admin.role[0].name }}</p>

                              </div>
                            </div>
                          </li>

                        </ul>

                        <ul class="list digits">
                          <li
                            class="clearfix mb-3 border-bottom pb-3"
                            v-for="(staff,index) in AllstaffTeamToChat"
                            :key="index"
                            style="cursor: pointer; padding: 12px;!important;margin:0px!important"
                          >
                            <img
                              class="rounded-circle user-image"
                             :src=" staff.profile_picture   ? '../../profile_pictures/'+staff.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                             alt=""
                             @click.prevent="getOldMessageInChat(staff.Personal_uuid)"

                            />
                            <div class="about">
                               <h6 class="name"
                                    @click.prevent="getOldMessageInChat(staff.Personal_uuid)"
                                    >{{ staff.firstName }}
                              </h6>
                              <div class="status" style="display: flex;">

                                     <i class="fa fa-briefcase" style="margin: 6px;"> </i>
                                     <p> {{  staff.roles[0].name }}</p>

                              </div>
                            </div>
                          </li>


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


                    </b-tab>
                    <b-tab class="material-border" title="group">
                      <div>
                        <div class="user-profile">
                          <div class="image">
                            <div class="avatar text-center">
                              <img
                                alt=""
                                src=""
                              />
                            </div>
                            <div class="icon-wrapper">
                              <i class="icofont icofont-pencil-alt-5"></i>
                            </div>
                          </div>
                          <div class="user-content text-center">
                            <h5 class="text-uppercase">Elana Jecno</h5>
                            <div class="social-media">
                              <ul class="list-inline">
                                <li class="list-inline-item">
                                  <a href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                  <a href="#"
                                    ><i class="fa fa-google-plus"></i
                                  ></a>
                                </li>
                                <li class="list-inline-item">
                                  <a href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                  <a href="#"
                                    ><i class="fa fa-instagram"></i
                                  ></a>
                                </li>
                                <li class="list-inline-item">
                                  <a href="#"><i class="fa fa-rss"></i></a>
                                </li>
                              </ul>
                            </div>
                            <hr />
                            <div class="follow text-center">
                              <div class="row">
                                <div class="col border-right">
                                  <span>Following</span>
                                  <div class="follow-num">236k</div>
                                </div>
                                <div class="col">
                                  <span>Follower</span>
                                  <div class="follow-num">3691k</div>
                                </div>
                              </div>
                            </div>
                            <hr />
                            <div class="text-center digits">
                              <p class="mb-0">Mark.jecno23@gmail.com</p>
                              <p class="mb-0">+91 365 - 658 - 1236</p>
                              <p class="mb-0">Fax: 123-4560</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </b-tab>
                  </b-tabs>
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
      senderInfo:[],
      reseverInfo:[],
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
  mounted() {

       Echo.private(`chat_message.${this.chatInfo.to}`)
            .listen(".chatting_team", (e) => {
                // this.oldMessage.push(e);
                console.log(e.message)
                console.log('jjjjjjjjjj')
            });

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



    },
  },



  watch: {



  }
};
</script>
<style scoped>
::-webkit-scrollbar {
    width: 0px;
    background: transparent; /* make scrollbar transparent  hiden but still scrllo*/
}
</style>

