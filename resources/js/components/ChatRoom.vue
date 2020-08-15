<template>
    <div>
        <div id="nav-header">
            <div class="opponent" v-if="user.name !== undefined">
                <img :src="assetURL + '/' + user.avatar" class="avatar" alt="">
                <h4>
                    {{ user.name }}
                </h4>
            </div>

            <h4 class="py-2 " v-else>Welcome to MeChat App</h4>

            <div class="hamburger-menu">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </div>

        <div id="main">
            <div v-for="message in messages" :key="message.id" :class="message.to === user.id ? 'mychat' : 'opponent-chat'">
                <p>
                    {{ message.message }}
                </p>
            </div>
        </div>

        <div id="footer">
            <form @submit.prevent="postMessage" class="form-message">
                <input type="text" name="message" id="message" placeholder="Type message..." v-model="chat.message">
                <button type="submit" class="btn-send">
                    <i class="far fa-paper-plane"></i>
                    <span>Send</span>
                </button>
            </form>
        </div>

        <div id="nav-bottom">
            <Contact>

            </Contact>
        </div>
    </div>
</template>

<script>
    import Contact from './Contact'

    export default {
        name: "ChatRoom",

        components:{
            Contact
        },

        created(){
            this.assetURL = rootURL

            this.$root.$on('dataChat', (messages, user) => {
                this.messages = messages
                this.user = user
            })

            Echo.private('chat')
                .listen('MessageSent', (e) => {
                    this.messages.push(e.message)
                })
        },

        mounted(){

        },

        data(){
            return{
                assetURL: '',
                messages:[],
                user:{},
                chat:{
                    to: null,
                    message: ''
                }
            }
        },

        methods:{
            postMessage(){
                if(this.chat.to !== null){
                    axios.post(`${baseURL}/message?token=${token}`, this.chat)
                        .then(res => {
                            this.messages.push({
                                to: this.chat.to,
                                message: this.chat.message
                            })
                            this.chat.message = ''
                        })
                        .catch(err => console.log(err.response))
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        text: 'Please select contact first to send a message !'
                    })
                }
            }
        },

        watch:{
            user(user){
                this.chat.to = user.id
                this.chat.message = ''
            }
        }
    }
</script>

<style scoped>

</style>
