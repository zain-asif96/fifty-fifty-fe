# Fifty- Fifty (Prototype)

## Overview

### This website is an online platform for sending money internationally. The idea is in the simplest way is to connect people from the Sender and the Receiver countries, And each will send money in his own country, this way no international fees are required. And all parties are happy.

---

## Key Features

Sending money: easily send money to anywhere in the world with very low fees.
---

## Architecture

### This website is built using the LAMP stack (Linux, Apache, MySQL and PHP), and uses these Frameworks and Programming langauges:

- `PHP` (V 8.0.2)
- `Laravel` (V 9.19)
- `Vue.js` (V 3.2.41)
- `InertiaJs` (V 1.0)

### and consists of the following components:

- `Authentication and Authorization Component`.
    - This includes authentication of users using 2 Auth verification (SMS or Email).
    - Also includes authentication of Admin Users to access admin panels and set different authorization roles.

- `Transactions Component`.
    - Including all stages of transaction, from entering transaction info, receiver info to card authorization and
      transaction tracking.

- `Posts Component`.
    - Viewing the published posts according to user countries and allowing users to accept a post and complete the
      associated transaction.

---

## APIs

### This website uses the following APIs:

- `Twilio`: Used for 2-step verifications and SMS notifications.
    - API Website URL: https://www.twilio.com/docs/usage/api
- `SENDGRID`: Used for 2-step verifications and Email notifications.
    - Note that this can be replaced by default `SMTP` email setup in the `.env` file.
    - API Website URL: https://app.sendgrid.com/guide/integrate
- `STRIPE`: Used for card authorization, holding payment and for collecting fees from the sender.
    - API Website URL: https://stripe.com/docs/api
- `IP GEO LOCATION`: Used for determining user location by his IP address.
    - API Website URL: https://api.ip2location.io
- `CURRENCY EXCHANGE API`: Used to get real time updates of currency exchange rates.
    - API Website URL: https://api.freecurrencyapi.com/v1/latest
- `Pusher`: used for push notifications.
    - API Website URL: https://pusher.com/docs/

---

## Running the project locally or on Linux server:

### To run the project locally you have to follow these simple steps:

#### For backend setup:

- clone the project from github:
    - `git clone git@github.com:A-Marzouk/fifty-fifty.git`
- CD to the project directory:
    - `cd fifty-fifty`
- Copy the `.env.testing` (which has all testing keys for all used apis) or `.env.example` (with no keys) to `.env`
  file.
    - `cp .env.testing .env`
- Run the migrations and seeders (Confirm the prompt to create the database if it doesn't exist)
    - `php artisan migration:fresh --seed`
    - Make sure your MySQL connection is configured correctly in the `.env` file.
- Generate unique app key:
    - `php artisan key:generate`
- Run the server application:
    - `php artisan serve`

#### For frontend setup:

- Install NPM packages:
    - `npm install`
- Run the dev server
    - `npm run dev`

---

## Deployment

### This website is deployed using Azure App Services, and is temperately hosted on (https://fifty-prototype.azurewebsites.net).

### The deployment process involves the following steps:

- Building frontend assets:
    - vite build
- Uploading to the server using SSH connection to remote git repository hosted on the cloud.

---

## Testing

- The website components are covered by feature and unit testing using PHPUnit.
- To run the tests:
    - `php artisan test`

---

## Troubleshooting

If you encounter any issues while using this website, please refer to the following troubleshooting guide:

- Open the `Laravel.log` file
- Check servers log on the azure app service console.
- Contact the developer @ [Ahmed M.](mailto:ahmedmarzouk266@gmail.com)

