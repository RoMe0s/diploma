<template>
    <b-card no-body>
        <b-card-header>
            {{ __('auth.register') }}
        </b-card-header>
        <b-card-body>
            <b-form @submit.prevent="signUp()">
                <b-form-group :label="__('fields.name')">
                    <b-form-input name="name" v-validate="'required|max:255'" v-model="name" :state="noErrors('name')"
                                  :placeholder="__('fields.name')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first('name') }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group :label="__('fields.email')">
                    <b-form-input type="email" name="email" v-validate="'required|email|max:255'" v-model="email"
                                  :state="noErrors('email')" :placeholder="__('fields.email')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first('email') }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group :label="__('fields.password')">
                    <b-form-input type="password" name="password" v-validate="'required|min:8'" v-model="password"
                                  :state="noErrors('password')" :placeholder="__('fields.password')" ref="password"/>
                    <b-form-invalid-feedback>
                        {{ errors.first('password') }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group :label="__('fields.password confirmation')">
                    <b-form-input type="password" name="password_confirmation"
                                  v-validate="'required|confirmed:password'" v-model="password_confirmation"
                                  :state="noErrors('password_confirmation')"
                                  :placeholder="__('fields.password confirmation')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first('password_confirmation') }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group :label="__('fields.role')">
                    <b-form-select name="role" v-validate="'required'" v-model="role" :state="noErrors('role')"
                                   :options="transformRoles()"/>
                    <b-form-invalid-feedback>
                        {{ errors.first('role') }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <div class="text-center">
                    <b-button type="submit" variant="success">
                        {{ __('auth.register') }}
                    </b-button>
                </div>
            </b-form>
        </b-card-body>
    </b-card>
</template>
<script>
  export default {
    props: {
      roles: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        name: null,
        role: null,
        email: null,
        password: null,
        password_confirmation: null
      }
    },
    methods: {
      signUp() {
        this.validateAll().then(() => this.sendRequest('auth.register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        }).then(response => {
          console.log(response);
          window.location.href = response.data.redirectTo;
        }));
      },
      transformRoles() {
        return _.transform(this.roles, (result, value) => {
          result[value] = this.__(`auth.roles.${value}`);
        }, {});
      }
    }
  }
</script>
