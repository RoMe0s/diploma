export default {
  methods: {
    itemsProvider(ctx) {
      return this.sendRequest(ctx.apiUrl, {
        filter: ctx.filter,
        sortBy: ctx.sortBy,
        sortDesc: +ctx.sortDesc,
        perPage: ctx.perPage,
        currentPage: ctx.currentPage
      }, () => []).then(this.itemsProviderCallback);
    },
    itemsProviderCallback(response) {
    }
  }
}