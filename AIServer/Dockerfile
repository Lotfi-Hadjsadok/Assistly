FROM node:23-alpine
USER root
RUN npm install -g nodemon

RUN apk add --no-cache \
    chromium

WORKDIR /usr/src/app

COPY package.json package-lock.json ./
COPY --chmod=755 start.sh ./

RUN npm install
COPY . .

EXPOSE 3000
