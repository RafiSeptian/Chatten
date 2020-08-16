<template>
    <div>
        <div id="sidebar">
            <Contact>

            </Contact>
        </div>

        <div id="content">
            <ChatRoom>

            </ChatRoom>
        </div>
    </div>
</template>

<script>
    import Contact from '../components/Contact'
    import ChatRoom from '../components/ChatRoom'

    export default {
        name: "ChatApp",

        created() {
            if(!this.$cookies.get('token')){
                window.location.href = `${rootURL}/login`
            }
        },

        components:{
            Contact,
            ChatRoom,
        }
    }
</script>

<style scoped>

</style>
