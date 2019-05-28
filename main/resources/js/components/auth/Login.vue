<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __('auth.login') }}
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form @submit.prevent="signIn()">
                <b-form-group :label="__('fields.email')">
                    <b-form-input type="email" name="email" v-validate="'required|email|max:255'" v-model="email"
                                  :state="noErrors('email')" :placeholder="__('fields.email')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first('email') }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group :label="__('fields.password')">
                    <b-form-input type="password" name="password" v-validate="'required'" v-model="password"
                                  :state="noErrors('password')" :placeholder="__('fields.password')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first('password') }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group>
                    <b-form-checkbox v-model="remember">
                        {{ __('auth.remember me') }}
                    </b-form-checkbox>
                </b-form-group>
                <div class="text-center">
                    <b-button type="submit" variant="success">
                        {{ __('auth.login') }}
                    </b-button>
                    <b-link class="btn btn-link" href="/password/reset">
                        {{ __('auth.forgot your password?') }}
                    </b-link>
                </div>
            </b-form>
        </b-card-body>
    </b-card>
</template>
<script>
  export default {
    data() {
      return {
        email: null,
        password: null,
        remember: false
      }
    },
    methods: {
      signIn() {
        this.validateAll().then(isValid => {
          if (isValid) {
            this.sendRequest('auth.login', {
              email: this.email,
              password: this.password,
              remember: this.remember
            }).then(response => window.location.href = response.data.redirectTo)
          }
        });
      }
    }
  }
</script>