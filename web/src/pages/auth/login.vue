<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { useStore } from "vuex";

const store = useStore();

const initialValues = ref({
    userName: "testadmin",
    password: "password"
});


const submitForm = async (e) => {
    e.preventDefault();

    try {
        // setLoading(true)

        const resp = await store.dispatch("loginAsync", initialValues.value)
            .catch((error) => {
                console.log(error)
                throw error
            })
            .then((resp) => {
                return resp
            });

        console.log(resp)

        // setLoading(false)
        



    } catch (error) {
        console.log(error)
        // setLoading(false)
    }

}

</script>
<template>
    <div>

        <div class="container-fluid">
            <div class="row ">
                <div class="col-12 p-0">
                    <div class="login-card">
                        <div>
                            <div>
                                <a class="logo">
                                    <img class="img-fluid for-light" src="../../assets/images/logo/logo.png"
                                        alt="looginpage" />
                                    <img class="img-fluid for-dark" src="../../assets/images/logo/logo_dark.png"
                                        alt="looginpage" />
                                </a>
                            </div>
                            <div class="login-main">
                                <form class="theme-form needs-validation" novalidate @submit.prevent="submitForm">
                                    <h4>Sign in to account</h4>
                                    <p>Enter your username & password to login</p>
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Username</label>
                                        <input class="form-control" type="text" required=""
                                            placeholder="Enter your username" v-model="initialValues.userName">
                                        <!-- <div class="invalid-feedback" id="feedback-1" v-if="errors[1]">{{
                                            errors[1].msgUsername }}</div> -->

                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Password</label>
                                        <div class="form-input position-relative">
                                            <input class="form-control" type="password" required=""
                                                placeholder="Enter your password" v-model="initialValues.password">
                                            <!-- <div class="show-hide"><span class="show"> </span></div>
                                            <div class="invalid-feedback" id="feedback-1" v-if="errors[0]">{{
                                                errors[0].message }}</div> -->
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <div class="checkbox p-0">
                                            <input id="checkbox1" type="checkbox">
                                            <label class="text-muted" for="checkbox1">Remember password</label>
                                        </div>

                                        <div class="text-end mt-3">
                                            <!-- <button class="btn btn-primary btn-block w-100" type="submit"
                                                @click.prevent="login">Sign
                                                in</button> -->
                                            <button class="btn btn-primary btn-block w-100" type="submit">Sign
                                                in</button>

                                        </div>
                                    </div>
                                    <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2"
                                            href="sign-up.html">Create
                                            Account</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

