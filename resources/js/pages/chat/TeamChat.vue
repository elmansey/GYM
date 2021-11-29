<template>
  <div>
    <Breadcrumbs main="dashboard" title="team Chat" />
    <!-- Container-fluid starts-->
    <div class="container-fluid">





        <div class="col call-chat-body" >
          <div class="card">
            <div class="card-body p-0">
              <div class="row chat-box" >
                <!-- Chat right side start-->
                <div class="col pr-0 chat-right-aside" >
                  <!-- chat start-->
                  <div class="chat mb-0 pb-0" >
                    <!-- chat-header start-->
                    <div class="chat-header clearfix">


                          <img
                                class="rounded-circle"
                                :src=" reseverInfo.profile_picture   ? '../../profile_pictures/'+reseverInfo.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                alt=""
                              v-if="chatting"
                         />
                      <div class="about">

                            <div class="name"  v-if="chatting">
                                <div class="status digits">
                                        <div  v-if="IsOnline(reseverInfo.id)">

                                        <i class="fa fa-circle text-success" style="font-size:8px"> </i>
                                        <span style="margin-left: 0px!important;font-size:13px" class="text-success">online</span>
                                        </div>
                                </div>
                                {{ reseverInfo.name }}
                                <br />

                            <p class="font-primary f-12" v-if="typeStatus" >{{ typeStatus}} ....</p>
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
                    <div class="chat-history chat-msg-box custom-scrollbar"  ref="lastMessage" style=" height: 400px!important;">
                      <ul>
                        <li

                        >
                          <div
                            class="message "
                            style="width:100%;"

                            >

                                <div
                                v-for="(message , index) in oldMessage"
                                        :key="index"
                                        :class="[message.from == $store.getters.USER.id ? ' float-left block '  : ' float-right block ']"
                                        style="clear: both ; "
                                >
                                    <div class="card d-inline-block mb-3 float-right"  style="background-color:#F3F1F5;border-radius:15px">

                                        <div class="card-body "  >
                                                <div class="d-flex flex-row pb-1">

                                                    <img   v-if="message.from == $store.getters.USER.id" alt=""
                                                    :src=" senderInfo.profile_picture   ? '../../profile_pictures/'+senderInfo.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                                    class="img-thumbnail  border-0 rounded-circle  mr-3  list-thumbnail align-self-center "
                                                    style="width:40px;hight:40px"
                                                    >


                                                    <img  v-if="message.from != $store.getters.USER.id"
                                                    alt=""
                                                    :src="  reseverInfo.profile_picture   ? '../../profile_pictures/'+reseverInfo.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                                                    class="img-thumbnail  border-0 rounded-circle  mr-3  list-thumbnail align-self-center "
                                                        style="width:40px;hight:40px"
                                                    >

                                                    <div class="d-flex flex-grow-1 min-width-zero">
                                                        <div class="m-2 pl-0  align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero ">
                                                            <div class="min-width-zero">
                                                                <p class="mb-0 truncate list-item-heading">


                                                                    <span v-if="message.from == $store.getters.USER.id" >
                                                                        {{  senderInfo.name   }}
                                                                    </span>
                                                                    <span v-if="message.from != $store.getters.USER.id" >
                                                                        {{ reseverInfo.name   }}
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
                                                <span v-for="(time,index) in message.send_at" :key="index" class="text-extra-small text-muted  m-3" style="font-size:9px!important;">
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
                                                     @keydown="typing"
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
                    nav-class="tabbed-card border-tab border-tab-primary custom-scrollbar mb-0"

                  >
                    <b-tab title="team" active style="margin:5px!important;padding:0px!important">
                      <div class="people-list"  v-if="isloading">
                        <ul class="list digits">
                          <li
                            class="clearfix mb-3 border-bottom pb-3 "
                            v-for="(teamPerson,key) in AllTeamToChat"
                            :key="key"
                            style="cursor: pointer; padding: 12px;!important;margin:0px!important;position: relative;"
                          >
                            <img
                              class="rounded-circle user-image"
                            :src=" teamPerson.profile_picture   ? '../../profile_pictures/'+teamPerson.profile_picture :  '../../profile_pictures/DefaultProfile.jpg'"
                             alt=""
                             @click.prevent="getOldMessageInChat(teamPerson.id)"
                            />
                            <span v-if="teamPerson.messageTeamRelationTo.length > 0" class="badge bg-success" style="    position: absolute;top: 52px;left: 270px;padding: 5px 10px;border-radius: 50%;color: white;">
                                {{ teamPerson.messageTeamRelationTo.length }}
                            </span>

                            <div class="about" >
                             <div class="name"

                                @click.prevent="getOldMessageInChat(teamPerson.id)"

                                >{{ teamPerson.name }}

                            </div>
                              <div class="status"  style="display: flex;margin-top:0px;!important">
                                 <i class="fa fa-briefcase" style="margin: 6px;"></i>
                                  <p> {{  teamPerson.role[0].name }}</p>

                              </div>
                              <div  v-if="IsOnline(teamPerson.id)">

                                   <i class="fa fa-circle text-success" style="font-size:8px"> </i>
                                   <span style="margin-left: 0px!important;font-size:13px" class="text-success">online</span>
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


      AllTeamToChat:[],
      chatting:false,
      isloading:false,

      chatInfo:{
          from:'',
          to:'',
          message:''
      },
      senderInfo:[],
      reseverInfo:[],
      oldMessage:[],
      typeStatus:'',
      selected:'',
      OnlinePerson:[]
    };
  },


  beforeMount(){



     this.getALLteamToChat()

      this.chatInfo.from = this.$store.getters.USER.id
  },


    mounted() {

        Echo.private(`team_chat.${this.chatInfo.from}`).listen('NewMessage', (e) => {

                if(e.message.to == this.$store.getters.USER.id && this.chatting &&  e.message.from == this.selected){

                        this.oldMessage.push({
                            'to' : e.message.to,
                            'from' : e.message.from,
                            'message' : e.message.message,
                            'send_at' : Array(e.message.send_at)
                        });
                        this.scrollChatToLastMessage()
                        this.readMessage()
                }
                 this.getALLteamToChat()


        })

        Echo.private('typingEvent')
           .listenForWhisper('typing', (e) => {


                     if(e.resever == this.$store.getters.USER.id && this.selected == e.sender){
                         this.typeStatus = 'typing'

                            setTimeout(()=>{

                                this.typeStatus =''

                            },3000);
                     }


       });


      Echo.join('liveUserStatus')
        .here((users) => {
                this.OnlinePerson = users
        })
        .joining((user) => {
            this.OnlinePerson.push(user)
        })
        .leaving((user) => {

            var AllOnline =  this.OnlinePerson.map((item ,index) => {

               return item['id']

           })
            var index =   AllOnline.findIndex(x => x.id === user.id)

           this.OnlinePerson.splice(index,1)

        })
        .error((error) => {
            console.error(error);
        });



        this.readMessage
         this.getALLteamToChat()




  },




  methods: {



      readMessage(){

            var resever = this.selected
            let formData = new FormData()
            formData.append("resever",resever)


            axios.post('setReadingMessage',formData)
            .then(res => {


            }).catch(err => {

            })


      },

    getALLteamToChat(){

    axios.get(`getUserToChatIgnoreMe/${this.$store.getters.USER.email}`)
      .then(res => {

          this.AllTeamToChat = res.data.admins
          this.isloading = true

      })
      .catch(err => {
          console.error(err);
      })

      },

    IsOnline(id){

           var res =  this.OnlinePerson.map((item ,index) => {

               return item['id']

           })
           return res.includes(id)
    },


  typing(){

        Echo.private('typingEvent')
            .whisper('typing', {

                 resever : this.selected,
                 sender : this.$store.getters.USER.id,
                message: this.chatInfo.message
        })

    },




    getOldMessageInChat(id){

         this.chatInfo.to  =   id
         this.selected  =   id

         this.readMessage()

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
              this.getALLteamToChat()


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




    watch:{
        show(){
            this.readMessage()
        }
    }

};
</script>
<style scoped>

::-webkit-scrollbar {
    width: 0px;
    background: transparent; /* make scrollbar transparent  hiden but still scrllo*/
};





</style>

