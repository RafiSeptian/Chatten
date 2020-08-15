<template>
    <div>
        <div id="header">
            <div class="brand">
                <h3>Chatten</h3>
            </div>
        </div>

        <div id="contact-list">
            <div class="contact" v-for="user in users" :key="user.id" @click.prevent="showMessage(user.id)">
                <img :src="user.avatar" alt="" class="avatar">
                <div class="detail">
                    <h4>{{ user.name }}</h4>
                    <span>
                        Online
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Contact",

        created(){
            this.getAllUsers();
        },

        data () {
            return {
                users:[],
            }
        },

        methods:{
            getAllUsers(){
                axios.get(`${baseURL}/message?token=${token}`)
                    .then(res => {
                        let users = res.data.users.map((user) => {
                            user.avatar = `${assetURL}/${user.avatar}`
                            return user
                        })

                        this.users = users
                    })
                    .catch(err => console.log(err.response))
            },

            showMessage(id){
                axios.get(`${baseURL}/message/${id}?token=${token}`)
                    .then(res =>{
                        this.$root.$emit('dataChat', res.data.messages, res.data.user)
                    })
                    .catch(err => console.log(err))
            }
        }
    }
</script>

<style scoped>
    .brand h3{
        font-weight: bold !important;
    }
</style>
