<template lang="pug">
  b-card(no-body='')
    b-card-header {{ __('auth.register') }}
    b-card-body
      b-form(@submit.prevent='onSubmit')
        b-form-group(:label='__("fields.name")')
          b-form-input(name='name', v-validate="'required|max:255'", v-model='name', :state='noErrors("name")', :placeholder='__("fields.name")')
          b-form-invalid-feedback {{ errors.first('name') }}
        b-form-group(:label='__("fields.email")')
          b-form-input(name='email', v-validate="'required|email|max:255'", v-model='email', :state='noErrors("email")', type='email', :placeholder='__("fields.email")')
          b-form-invalid-feedback {{ errors.first('email') }}
        b-form-group(:label='__("fields.password")')
          b-form-input(name='password', v-validate="'required|min:8'", v-model='password', :state='noErrors("password")', type='password', :placeholder='__("fields.password")', ref="password")
          b-form-invalid-feedback {{ errors.first('password') }}
        b-form-group(:label='__("fields.password confirmation")')
          b-form-input(name='password_confirmation', v-validate="'required|confirmed:password'", v-model='password_confirmation', :state='noErrors("password_confirmation")', type='password', :placeholder='__("fields.password confirmation")')
          b-form-invalid-feedback {{ errors.first('password_confirmation') }}
        .text-center
          b-button(type='submit', variant="success") {{ __('auth.register') }}
</template>
<script>
  export default {
    data() {
      return {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      }
    },
    methods: {
      onSubmit() {
        this.validateAll().then(() => this.sendRequest('auth.register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        }).then(response => window.location.href = response.data.redirectTo));
      }
    }
  }
</script>