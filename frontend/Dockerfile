FROM node:7.10

RUN mkdir /app
ADD . /app
WORKDIR /app
RUN npm install
RUN ls -la

EXPOSE 9002
CMD ["npm", "start"]