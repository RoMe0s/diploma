import routes from '../router';

function findRoute(chunks = [], routes = {}) {
  const chunk = chunks.shift();
  if (chunk in routes) {
    return chunks.length ? findRoute(chunks, routes[chunk]) : routes[chunk];
  }
  return null;
}

function sendRequest(routeName, parameters) {
  const route = findRoute(routeName.split('.'), routes);
  if (typeof route === 'function') {
    return route(parameters);
  }
  return new Promise((resolve, reject) => reject('Route not found!'));
}

export default {
  methods: {
    sendRequest(route, parameters, errorHandler) {
      return sendRequest(route, parameters)
        .catch(error => {
          switch (typeof errorHandler) {
            case 'function':
              errorHandler();
              break;
            case 'string':
              this.notify(errorHandler);
              break;
            default:
              this.httpErrorHandler(error);
              break;
          }
        });
    },
    httpErrorHandler(error) {
      if ('response' in error) {
        const responseData = error.response.data;
        if ('errors' in responseData) {
          for (let field in responseData.errors) {
            for (let error of responseData.errors[field]) {
              this.$validator.errors.add({field, msg: error});
            }
          }
        }
        if ('message' in responseData) {
          this.notify(responseData.message);
          return;
        }
      }
      this.notify(this.__('messages.error'))
    }
  }
};