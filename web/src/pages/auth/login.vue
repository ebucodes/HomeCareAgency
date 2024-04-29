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
                                <form class="theme-form needs-validation" novalidate
                                    @submit.prevent="onCustomStyleSubmit">
                                    <h4>Sign in to account</h4>
                                    <p>Enter your username & password to login</p>
                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Username</label>
                                        <input class="form-control" type="text" required=""
                                            placeholder="Enter your username" v-model="username"
                                            v-bind:class="formSubmitted ? userError ? 'is-invalid' : 'is-valid' : ''">
                                        <div class="invalid-feedback" id="feedback-1" v-if="errors[1]">{{
                                            errors[1].msgUsername }}</div>

                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="col-form-label">Password</label>
                                        <div class="form-input position-relative">
                                            <input class="form-control" type="password" required=""
                                                placeholder="Enter your password" v-model="password"
                                                v-bind:class="formSubmitted ? passwordError ? 'is-invalid' : 'is-valid' : ''">
                                            <div class="show-hide"><span class="show"> </span></div>
                                            <div class="invalid-feedback" id="feedback-1" v-if="errors[0]">{{
                                                errors[0].message }}</div>
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

<script>
import Swal from 'sweetalert2'; // Import SweetAlert
import axios from 'axios'; // Import Axios for making HTTP requests
import formValidation from "@/mixins/commen/formValidation"; // Import your form validation mixin

export default {
    mixins: [formValidation],
}
</script>
