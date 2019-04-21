<template lang="pug">
  div
    b-navbar(toggleable='lg', type='dark', variant='info')
      .container
        b-navbar-brand(href='#') Checker
        b-navbar-toggle(target='nav-collapse')
        b-collapse#nav-collapse.justify-content-end(is-nav='')
          b-navbar-nav
            b-nav-item(@click.prevent='signOut', v-if='user')
              strong {{ user.name }}
              | , logout
            b-nav-item(href='/register', v-if='!user') Register
            b-nav-item(href='/login', v-if='!user') Login
</template>
<script>
  export default {
    props: {
      user: {
        type: Object,
        default: null
      }
    },
    methods: {
      signOut() {
        this.sendRequest('auth.logout')
          .then(response => window.location.href = response.redirectTo);
      }
    }
  }
</script>