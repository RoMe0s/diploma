<template>
    <b-navbar toggleable="lg" type="dark" variant="secondary">
        <div class="container">
            <b-navbar-brand href="/">
                Checker
            </b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"/>
            <b-collapse id="nav-collapse" class="justify-content-end" is-nav>
                <b-navbar-nav>
                    <b-nav-item href="/login">
                        {{ __('messages.login') }}
                    </b-nav-item>
                    <b-nav-item href="/register">
                        {{ __('messages.register') }}
                    </b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </div>
    </b-navbar>
</template>