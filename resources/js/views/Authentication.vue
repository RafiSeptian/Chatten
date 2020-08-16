<template>
    <div class="container">
        <div class="row wrapper align-items-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div id="brand">
                            <h3 class="text-center">
                                Chatten App
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
                        <div class="card mt-4">
                            <div class="card-body">
                                <form @submit.prevent="postAuth">
                                    <div class="form-group" v-show="!account">
                                        <label for="fullname" class="control-label">
                                            Fullname
                                        </label>
                                        <input type="text" class="form-control" name="fullname" id="fullname" v-model="user.name">
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="control-label">
                                            Username
                                        </label>
                                        <input type="text" class="form-control" name="email" id="email" v-model="user.username">
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="control-label">
                                            Password
                                        </label>
                                        <input type="password" class="form-control" name="password" id="password" v-model="user.password">
                                    </div>

                                    <div class="form-group" v-show="!account">
                                        <span class="d-block">Select avatar</span>
                                        <div class="avatars">
                                            <label for="avatar1">
                                                <input type="radio" class="custom-radio" name="avatar" value="icon1" v-model="user.avatar" id="avatar1">
                                                <img :src="assetURL +'/users/icon1.png'" class="avatar" alt="">
                                            </label>
                                            <label for="avatar2">
                                                <input type="radio" class="custom-radio" name="avatar" id="avatar2" value="icon2" v-model="user.avatar" >
                                                <img :src="assetURL +'/users/icon2.png'" class="avatar" alt="">
                                            </label>
                                            <label for="avatar3">
                                                <input type="radio" class="custom-radio" name="avatar" id="avatar3" value="icon3" v-model="user.avatar" >
                                                <img :src="assetURL +'/users/icon3.png'" class="avatar" alt="">
                                            </label>
                                            <label for="avatar4">
                                                <input type="radio" class="custom-radio" name="avatar" id="avatar4" value="icon4" v-model="user.avatar" >
                                                <img :src="assetURL +'/users/icon4.png'" class="avatar" alt="">
                                            </label>
                                            <label for="avatar5">
                                                <input type="radio" class="custom-radio" name="avatar" id="avatar5" value="icon5" v-model="user.avatar" >
                                                <img :src="assetURL +'/users/icon5.png'" class="avatar" alt="">
                                            </label>
                                            <label for="avatar6">
                                                <input type="radio" class="custom-radio" name="avatar" id="avatar6" value="icon6" v-model="user.avatar" >
                                                <img :src="assetURL +'/users/icon6.png'" class="avatar" alt="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mt-4 justify-content-center align-items-center">
                                        <div class="col-7">
                                            <a href="" @click.prevent="toggleStatus">
                                                {{ account ? 'Belum punya akun ?' : 'Sudah punya akun ?' }}
                                            </a>
                                        </div>

                                        <div class="col-5">
                                            <button class="btn btn-primary text-center" type="submit">
                                                Sign {{ account ? 'In' : 'Up' }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Authentication",

        created(){
            if(this.$cookies.get('token')){
                window.location.href = `${rootURL}`
            }

            this.assetURL = rootURL
        },

        data(){
            return{
                user:{
                    username:'',
                    password:'',
                    name:'',
                    avatar:''
                },

                account: true,

                assetURL: ''
            }
        },

        methods:{
            postAuth(){
                if(this.user.username !== '' && this.user.password !== ''){
                    axios.post(`${baseURL}/auth/${ this.account ? 'login' : 'register' }`, this.user)
                        .then(res => {
                            // set cookies token
                            this.$cookies.set('token', res.data.user.login_token, Infinity)

                            Toast.fire({
                                icon: 'success',
                                title: `${res.data.msg}`,
                                onDestroy: (toast) => {
                                    window.location.href = `${rootURL}`
                                }
                            })
                        })
                        .catch(err => {
                            if(err.response.status === 401){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: `${err.response.data.msg}`
                                })
                            }
                            else if(err.response.status === 422){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: `The given data was invalid or username has already been taken`
                                })
                            }
                        })
                }
            },

            toggleStatus(){
                if(this.account){
                    this.account = false
                }
                else{
                    this.account = true
                }
            }
        }
    }
</script>

<style scoped>

    .wrapper{
        height:100vh;
    }

    #brand h3{
        font-size: 45px !important;
        font-weight:bold !important;
        color: #fff !important;
        text-shadow: 3px 3px rgba(0, 0, 0, .3)
    }

    a{
        text-decoration:none;
        color: blue !important;
    }

    button{
        width:100%;
        text-align:center;
        font-size: 16px !important;
        font-weight: 400 !important;
        color: #202020 !important;
    }
</style>
