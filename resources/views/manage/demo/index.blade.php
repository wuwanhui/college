<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <script src="/js/app.js"></script>
</head>
<body>

<div class="aligned">

    <validator name="form">
        <form class="ui large form" :class="{ 'error': $form.invalid && trySubmit }" novalidate>
            <div class="ui stacked segment">
                <div class="field" :class="{ 'error': $form.email.invalid && trySubmit }">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="email" v-model="item.email" placeholder="E-mail address"
                               v-validate:email="{ required: true, email: true }">
                    </div>
                </div>
                <div class="field" :class="{ 'error': $form.password.invalid && trySubmit }">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" v-model="item.password" placeholder="Password"
                               v-validate:password="{ required: true, minlength: 6 }">
                    </div>
                </div>
                <div v-on:click="submit($form)" class="ui fluid large teal submit button">Login</div>
            </div>
        </form>
    </validator>
    <div class="ui error message" v-if="trySubmit">
        <ul class="list">
            <li v-if="$form.email.required">Please enter your e-mail</li>
            <li v-if="$form.email.email">Please enter a valid e-mail</li>
            <li v-if="$form.password.required">Please enter your password</li>
            <li v-if="$form.password.minlength">Your password must be at least 6 characters</li>
        </ul>
    </div>

</div>

<script type="text/javascript">

    Vue.validator('email', function (val) {
        return /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i.test(val)
    });

    var vm = new Vue({
        el: '.aligned',
        data: function () {
            return {
                item: {
                    email: null,
                    password: null,
                },
                trySubmit: false,
            }
        },
        methods: {
            onReset: function () {
                this.$resetValidation()
            },
            submit: function (form) {
                this.trySubmit = true
                if (form.valid) {
                    this.$log('item')
                }
            }
        }
    })
</script>
</body>
</html>