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

        },

        components:{
            Contact,
            ChatRoom,
        }
    }
</script>

<style scoped>

</style>
