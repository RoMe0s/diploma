FROM node:10-alpine

RUN npm i -g laravel-echo-server

WORKDIR /application

ENTRYPOINT ["laravel-echo-server"]
CMD ["start", "--force"]