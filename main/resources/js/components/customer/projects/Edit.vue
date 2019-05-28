<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __("customer.projects.edit") }} "{{ title }}"
                <b-button-group class="float-right">
                    <b-link class="btn btn-primary" href="/projects" :title="__('messages.to list')">
                        <i class="fa fa-arrow-left"></i>
                    </b-link>
                    <b-link class="btn btn-success" :href="`/projects/${project.id}/settings`"
                            :title="__('messages.settings')">
                        <i class="fa fa-cog"></i>
                    </b-link>
                    <b-button variant="danger" @click.prevent="showDeleteConfirm()"
                              :title="__('messages.delete')">
                        <i class="fa fa-trash"></i>
                    </b-button>
                </b-button-group>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form @submit.prevent="update()">
                <b-form-group :label="__('fields.name')">
                    <b-form-input name="name" v-validate="'required|max:255'" v-model="name" :state="noErrors('name')"
                                  :placeholder="__('fields.name')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first("name") }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <div class="text-center">
                    <b-button type="submit" variant="success">
                        {{ __("messages.save") }}
                    </b-button>
                </div>
            </b-form>
        </b-card-body>
    </b-card>
</template>

<script>
  import DeleteConfirmMixin from "../../../mixins/deleteConfirm";

  export default {
    mixins: [DeleteConfirmMixin],
    props: {
      project: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        name: this.project.name,
        title: this.project.name
      }
    },
    methods: {
      showDeleteConfirm() {
        this.deleteConfirm(() => {
          this.sendRequest("customer.projects.destroy", this.project.id)
            .then(() => Swal.fire({
              title: this.__("messages.deleted!"),
              type: "success"
            }).then(() => window.location.href = "/projects"));
        });
      },
      update() {
        this.validateAll().then(isValid => {
          if (isValid) {
            this.sendRequest("customer.projects.update", [this.project.id, {name: this.name}])
              .then(() => {
                Swal.fire(this.__("messages.saved!"), "", "success");
                this.title = this.name;
              })
          }
        });
      }
    }
  }
</script>
