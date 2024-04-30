export default {
    data() {
        return {
            errors: [],
            formSubmitted: false,
            name: "",
            nameError: false,
            username: "",
            userError: false,
            password: "",
            passwordError: false,

        }
    },
    methods: {
        onCustomStyleSubmit() {
            this.formSubmitted = true;
            this.errors = [];
            // validate username
            if (this.username.length < 3 || this.username.length > 6) {
                this.userError = true;
                this.errors.push({
                    'msgUsername': 'Please choose a username.'
                });
            } else {
                this.userError = false;
            }
            // validate password
            if (this.password.length < 3 || this.password.length > 6) {
                this.passwordError = true;
                this.errors.push({
                    'msgPassword': 'Please choose a password.'
                });
            } else {
                this.passwordError = false;
            }
        },

    }
}