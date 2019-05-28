<template>
    <b-navbar toggleable="lg" type="dark" variant="secondary">
        <div class="container">
            <b-navbar-brand href="/">
                Checker
            </b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"/>
            <b-collapse id="nav-collapse" class="justify-content-end" is-nav>
                <b-navbar-nav>
                    <b-nav-item href="/profile">
                        {{ __("messages.profile") }}
                    </b-nav-item>
                    <b-nav-item @click="logout()">
                        {{ __("messages.logout") }}
                    </b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </div>
    </b-navbar>
</template>
<script src="./auth.js"></script>