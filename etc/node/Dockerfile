FROM node:21.6.2-alpine3.19

WORKDIR /app

COPY fe/package* .

# RUN rm -rf node_modules && rm -f yarn.lock package-lock.json

RUN npm install

COPY fe .

EXPOSE 5173

CMD [ "npm", "run", "docker" ]
# CMD [ "npm", "run", "build" ]