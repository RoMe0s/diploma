import ProviderMixin from "../../../../mixins/table/provider"

export default {
  mixins: [ProviderMixin],
  data() {
    return {
      fields: [
        {
          key: "id",
          sortable: true,
          label: this.__("columns.id")
        },
        {
          key: "name",
          sortable: true,
          label: this.__("columns.name")
        },
        {
          key: "estimate",
          sortable: true,
          label: this.__("columns.estimate")
        },
        {
          key: "size_from",
          sortable: true,
          label: this.__("columns.size_from")
        },
        {
          key: "size_to",
          sortable: true,
          label: this.__("columns.size_to")
        },
        {
          key: "min_price",
          sortable: true,
          label: this.__("columns.price_min")
        },
        {
          key: "max_price",
          sortable: true,
          label: this.__("columns.price_max")
        },
        {
          key: "actions",
          label: this.__("columns.actions")
        }
      ],
      perPage: 25,
      filter: null,
      sortBy: null,
      totalRows: 0,
      currentPage: 1,
      sortDesc: false,
      sortDirection: "desc",
      pageOptions: [25, 50, 100]
    }
  },
  methods: {
    itemsProviderCallback(response) {
      this.totalRows = response.data.totalRows
      return response.data.rows
    },
    append(id) {
      Swal.fire({
        type: "success",
        showCancelButton: true,
        title: this.__("messages.are you sure?"),
        cancelButtonText: this.__("messages.cancel")
      }).then(result => {
        if (result.value === true) {
          this.sendRequest("author.orders.append", id)
            .then(() => {
              Swal.fire(this.__("messages.accepted!"), "", "success")
              this.eventHub.$emit("order-was-taken")
              this.$refs.table.refresh()
            })
        }
      });
    }
  }
}