<template>
    <b-navbar toggleable="lg" type="dark" variant="info">
        <div class="container">
            <b-navbar-brand href="/">
                Checker
            </b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"/>
            <b-collapse id="nav-collapse" class="justify-content-end" is-nav>
                <b-navbar-nav>
                    <b-nav-item @click.prevent="signOut()" v-if="user">
                        <strong>{{ user.name }}</strong>, logout
                    </b-nav-item>
                    <b-nav-item href="/register" v-if="!user">
                        Register
                    </b-nav-item>
                    <b-nav-item href="/login" v-if="!user">
                        Login
                    </b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </div>
    </b-navbar>
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
          .then(response => window.location.href = response.data.redirectTo);
      }
    }
  }
</script>