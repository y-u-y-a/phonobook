<template>
    <div>
        <div class="half-box">
            <Camera></Camera>
        </div>

        <div class="half-box">
            <div id="login">
                <div class="form">
                    <div class="title">ログインする</div>
                    <div class="form-container">
                        <input type="hidden" name="_token" :value="csrf" />
                        <FormInput @signalEvent="getEmail" label="メールアドレス" placeholder="8文字以上の半角英数字" ></FormInput>
                        <FormInput @signalEvent="getPass" label="パスワード" placeholder="8文字以上の半角英数字" ></FormInput>
                    </div>
                    <FormButton @signalEvent="login" button_name="ログインする"></FormButton>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import Camera    from "../../components/Camera.vue"
import FormInput from "../../components/form/Input.vue"
import FormButton from "../../components/form/Button.vue"

export default {
    components: {
        Camera,
        FormInput,
        FormButton
    },

    data() {
        return {
            csrf: document.querySelector("meta[name='csrf-token']").getAttribute("content"),
            email: "",
            password: ""
        };
    },

    methods: {

        getEmail(value){
            this.email = value
        },
        getPass(value){
            this.password = value
        },

        async login() {
            var params = {
                email: this.email,
                password: this.password
            }
            await this.$store.dispatch("User/login", params)
            .then(response => {
                alert("ログインしました")
                this.$router.push("/")
            })
            .catch(error => {
                console.log(error.name + ": " + error.message)
                alert("ログインに失敗しました")
            })
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

#login{
    width: 90%;
    margin: 0 auto;
}
.form{
    margin: 2rem 0;
    padding-bottom: 2rem;
    background: $white;
    .title{
        padding: 2rem 0;
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 2px;
        border-bottom: 1px solid $silver;
        text-align: center;
    }
    .form-container{
        width: 90%;
        margin: 0 auto;
        padding-top: 2rem;
    }
}
</style>
