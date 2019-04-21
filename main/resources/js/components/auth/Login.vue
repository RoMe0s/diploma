<template lang="pug">
  b-card(no-body='')
    b-card-header {{ __('auth.login') }}
    b-card-body
      b-form(@submit.prevent='onSubmit')
        b-form-group(:label='__("fields.email")')
          b-form-input(name='email', v-validate="'required|email|max:255'", v-model='email', :state='noErrors("email")', type='email', :placeholder='__("fields.email")')
          b-form-invalid-feedback {{ errors.first('email') }}
        b-form-group(:label='__("fields.password")')
          b-form-input(name='password', v-validate="'required'", v-model='password', :state='noErrors("password")', type='password', :placeholder='__("fields.password")')
          b-form-invalid-feedback {{ errors.first('password') }}
        b-form-group
          b-form-checkbox(v-model='remember') {{ __('auth.remember me') }}
        .text-center
          b-button(type='submit', variant="success") {{ __('auth.login') }}
          b-link(href='/password/reset', class="btn btn-link") {{ __('auth.forgot your password?') }}

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
      onSubmit() {
        this.validateAll().then(() => this.sendRequest('auth.login', {
          email: this.email,
          password: this.password,
          remember: this.remember
        }).then(response => window.location.href = response.data.redirectTo));
      }
    }
  }
</script>